<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\BaseController;
use App\Http\Requests\StoreAttendanceLogRequest;
use App\Http\Requests\UpdateAttendanceLogRequest;
use App\Models\AttendanceLog;
use App\Models\Company;
use App\Services\DataTransformService;
use App\Services\TransactionService;
use App\Services\ZKTecoService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AttendanceLogController extends  BaseController
{
    public function __construct()
    {
        $this->modelClass = AttendanceLog::class;
        $this->model = AttendanceLog::latest()->with(['employee:id,employee_id,name']);
        $this->json = 'attendance-logs.json';
        $this->title = 'Attendance';
        $this->route = 'attendance';
        $this->upload = false;
        $this->apiFun = 'getAttendanceRecords';

        $this->canFilter = true;
        $this->canFilterTab = false;
        $this->filterRoute = 'filter-attendance';
        $this->filterFile = 'filters.json';
        $this->queryParams = [
            'start_time' => Carbon::today()->toDateTimeString(),
            "page_size" => 150
        ];
        $this->actions = [
            // ['action_name' => 'Edit', 'icon' => 'mdi-pencil', 'color' => 'primary', 'route' => 'loans'],
            // ['action_name' => 'Delete', 'icon' => 'mdi-delete', 'color' => 'error', 'route' => 'loans'],
            // Add more actions as needed
        ];
    }

    public function filter(Request $request)
    {
        $queryParams = [
            'start_time' => Carbon::parse($request->start_date)->startOfDay()->toDateTimeString(),
            'end_time' => Carbon::parse($request->end_date)->endOfDay()->toDateTimeString(),
            'emp_code' => ($request->employee) ? $request->employee['emp_code'] : null,
            'department' => ($request->department) ? $request->department['dept_code'] : null,
        ];

        $zkTecoService = new ZKTecoService;
        // Dynamically call the method stored in $this->apiFun
        if (method_exists($zkTecoService, $this->apiFun)) {
            return $zkTecoService->{$this->apiFun}($queryParams); // Call the method dynamically
        } else {
            // Handle the case where the method does not exist
            // e.g., throw an exception or log an error
            abort(404, "Method {$this->apiFun} not found in ZKTecoService");
        }

    }


    public function index1()
    {
        if (request('axios')) {
            return $this->model->paginate(100);
        }
        //  $data = $this->model->latest()->paginate(100);

        $transactions = new TransactionService;
        $data = $transactions->getTransactions();
        // paginate data
        // $data = $data->paginate(100);

        $company = Company::first();

        $jsonFile = public_path('data/' . $this->json); // Get the full path to the JSON file

        $trans = new DataTransformService;
        $jsonData = $trans->data_transform($jsonFile);


        $headers = [];

        // $headers[] = ['title' => 'Created At', 'key' => 'created_at'];

        foreach ($jsonData as $item) {
            if ($item['table_display']) {
                $headers[] = [
                    'title' => $item['label'],
                    'key' => $item['model']
                ];
            }
        }
        $headers[] = ['title' => 'Actions', 'key' => 'actions'];

        $filterData = null;
        if ($this->canFilter) {
            // Filter
            $jsonFilter = public_path('data/' . $this->filterFile); // Get the full path to the JSON file

            $trans = new DataTransformService;
            $filterData = $trans->data_transform($jsonFilter);

            return $filterData;
        }

        return Inertia::render('Views/index', [
            'data' => $data,
            'company' => $company,
            'formData' => $jsonData,
            'headers' => $headers,
            'title' => $this->title,
            'actions' => $this->actions,
            'modelRoute' => $this->route,
            'upload' => $this->upload,
            'canCreate' => $this->create,
            'canFilter' => $this->canFilter,
            'canFilterTab' => $this->canFilterTab,
            'filterRoute' => $this->filterRoute,
            'modalWidth' => $this->modalWidth,
            'filterData' => $filterData

        ]);
    }
}
