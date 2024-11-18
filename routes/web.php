<?php

use App\Http\Controllers\AppearanceController;
use App\Http\Controllers\AttendanceLogController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\SmsLogController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/', [DashboardController::class, 'analytics'])->name('dashboard');

    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('settings', SettingController::class);
    Route::resource('appearance', AppearanceController::class);
    Route::resource('sms', SmsLogController::class);
    Route::resource('attendance', AttendanceLogController::class);

    Route::resource('employees', EmployeeController::class);
    Route::resource('departments', DepartmentController::class);
    Route::resource('shifts', ShiftController::class);
    Route::resource('devices', DeviceController::class);
    Route::resource('holiday', HolidayController::class);
    Route::resource('leave', LeaveController::class);


    Route::resource('company', CompanyController::class);
    Route::post('/logo/{id}', [CompanyController::class, 'logo']);
    Route::post('/profile/{id}', [UserController::class, 'profile']);


    Route::post('/reverse/{id}', [TransactionController::class, 'reverse']);


    Route::post('/sync-employee', [EmployeeController::class, 'sync']);
    Route::post('/delete-bio', [EmployeeController::class, 'deleteBio']);

    Route::get('/theme', [AppearanceController::class, 'getThemeColors']);
    Route::post('/filter-attendance', [AttendanceLogController::class, 'filter']);




    Route::post('/sms-filter', [SmsLogController::class, 'smsFilter']);
    Route::get('/json-data', [HomeController::class, 'jsonData']);


    Route::get('/reports', [ReportController::class, 'index']);


    Route::post('/report', [ReportController::class, 'generate']);
    Route::post('/report-download', [ReportController::class, 'downloadReport']);

    Route::get('/generateInstallmentsFailingDue', [ReportController::class, 'generateInstallmentsFailingDue']);


});

