<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\BaseController;
use App\Jobs\SendSmsJob;
use App\Models\Client;
use App\Models\SmsLog;
use App\Notifications\SendSmsNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SmsLogController extends BaseController
{
    public function __construct()
    {
        // Set properties specific to IngredientController
        $this->model = new SmsLog;
        $this->modelClass = SmsLog::class;
        $this->json = 'smslogs.json';
        $this->title = 'Sms';
        $this->route = 'sms';
        $this->upload = false;
        $this->modalWidth = 800;
        $this->canFilter = true;
        $this->filterFile = 'sms-filters.json';
        $this->filterRoute = 'sms-filter';


        $this->actions = [
            ['action_name' => 'Edit', 'icon' => 'mdi-pencil', 'color' => 'primary', 'route' => 'loans'],
            ['action_name' => 'Delete', 'icon' => 'mdi-delete', 'color' => 'error', 'route' => 'loans'],
            // Add more actions as needed
        ];
    }

    public function store(Request $request)
    {
        $requestClass = $this->getRequestClass();
        $formRequest = new $requestClass();
        $validated = $request->validate($formRequest->rules());

        try {
            // Determine which clients to send the SMS to
            if ($validated['sms'] === 'All') {
                $clients = Client::take(2)->get();
            } else {
                $clients = Client::take(2)->whereIn('id', $validated['client_id'])->get();
            }

            if (count($clients) < 1) {
                return response()->json(['message' => 'No contacts found!']);
            }

            $message = $validated['message'];

            SendSmsJob::dispatch($clients, $message);

            // Return a response indicating success
            return response()->json(['message' => $this->title . ' Message sent']);
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    public function smsFilter(Request $request)
    {
        $start_date = ($request->start_date) ? Carbon::parse($request->start_date)->startOfDay() : null;
        $end_date = ($request->end_date) ? Carbon::parse($request->end_date)->startOfDay() : null;
        $branch_id = $request->branch_id;
        $officer_id = $request->officer_id;
        $client_id = $request->client_id;
        $status = ($request->status === 'all') ? null : $request->status;

        switch ($status) {
            case 'Active':
                $status = 'Disbursed';
                break;

            default:
                $status = $status;
                break;
        }

        // DB::enableQueryLog();
        return $this->model->when(($start_date && $end_date), function ($query) use ($start_date, $end_date) {
            $query->whereBetween('application_date', [$start_date, $end_date]);
        })->paginate(100);

        // dd(DB::getQueryLog());
    }
}
