<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSettingRequest;
use App\Http\Requests\UpdateSettingRequest;
use App\Models\Appearance;
use App\Models\EmailConfig;
use App\Models\Setting;
use App\Models\SmsConfig;
use App\Services\DataTransformService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $settings = Setting::first();

        $sms = SmsConfig::where('is_default', true)->first();
        $email = EmailConfig::where('is_default', true)->first();

        // $jsonFile = public_path('data/settings.json'); // Get the full path to the JSON file


        // $trans = new DataTransformService;
        // $jsonData = $trans->data_transform($jsonFile);

        $headers = [];
        $headers[] = ['title' => 'Created At', 'key' => 'created_at'];


        if (!$settings) {
            $settings = collect([
                "currency" => 'KES',
                "dateFormat" => 'd M Y',
                "timeZone" => 'EAT',
                "language" => 'English',
                "defaultInterestRate" => 0,
                "loanDuration" => '12 months',
                "repaymentFrequency" => 'Monthly',
                "latePaymentPenalties" => 0,
                "automaticRepaymentProcessing" => false,
                "partialPaymentAllowance" => false
            ]);
        }

        if (!$sms) {

            $sms = collect([
                "name" => '',
                "provider" => '',
                "api_key" => '',
                "username" => '',
                "sender_id" => '',
                "additional_settings" => '',
                "is_default" => '',
            ]);
        }
        if (!$email) {

            $email = collect([
                "name" => '',
                "provider" => '',
                "host" => '',
                "port" => '',
                "username" => '',
                "password" => '',
                "encryption" => '',
                "from_address" => '',
                "from_name" => '',
                "additional_settings" => '',
            ]);
        }

        $headers[] = ['title' => 'Actions', 'key' => 'actions'];
        // return $headers;
        return Inertia::render('Settings/index', [
            'formData' => $settings,
            'sms' => $sms,
            'email' => $email,
            'headers' => $headers,
            'title' => 'Settings',
            'modelRoute' => 'settings',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $settings = Setting::first();
        if ($settings) {
            $settings = Setting::first()->update($request->all());
            return response()->json(['message' => 'Settings Updated', 'data' => $settings]);
        } else {
            $settings = Setting::create($request->all());
            return response()->json(['message' => 'Settings Updated', 'data' => $settings]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSettingRequest $request, Setting $setting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Setting $setting)
    {
        //
    }

}
