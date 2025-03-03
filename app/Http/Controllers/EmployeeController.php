<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\BaseController;
use App\Models\Company;
use App\Models\Employee;
use App\Services\DataTransformService;
use App\Services\EmployeeApiService;
use App\Services\TransactionService;
use App\Services\ZKTecoService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class EmployeeController extends BaseController
{
    protected $zkTecoService;

    public function __construct(ZKTecoService $zkTecoService)
    {
        $this->zkTecoService = $zkTecoService;
        $this->modelClass = Employee::class;
        $this->model = new Employee();
        $this->json = 'employee.json';
        $this->title = 'Employees';
        $this->route = 'employees';
        $this->upload = false;
        $this->apiFun = 'getEmployees';
        $this->create = true;
        $this->queryParams = ["page_size" => 150];


        $this->actions = [
            // ['action_name' => 'Sync', 'icon' => 'mdi-pencil', 'color' => 'primary', 'route' => 'sync-employee'],
            // ['action_name' => 'Delete', 'icon' => 'mdi-delete', 'color' => 'error', 'route' => 'loans'],
        ];
    }


    public function store(Request $request)
    {
        $data = $request->all();
        $data['area'] = [$data['area']];

        return  $this->zkTecoService->createEmployee($data);
    }


    public function edit($id)
    {
        $zkt = new ZKTecoService;
        $employee = $zkt->getEmployeeById($id);

        // Add detailed logging to debug the response
        Log::info('Employee data from API:', [
            'employee' => $employee,
            'employee_type' => gettype($employee),
            'employee_keys' => is_array($employee) || is_object($employee) ? array_keys((array)$employee) : 'Not an array or object'
        ]);

        // Convert the employee data to an object if it's an array
        if (is_array($employee)) {
            $employee = json_decode(json_encode($employee));
        }

        Log::info('Employee data after conversion:', [
            'employee_type' => gettype($employee),
            'employee_keys' => is_object($employee) ? get_object_vars($employee) : 'Not an object'
        ]);

        // Fetch departments and areas from API
        $departments = $zkt->getDepartments();
        $areas = $zkt->getAreas();
        
        Log::info('Departments from API:', [
            'count' => is_array($departments) ? count($departments) : 'not an array',
            'sample' => is_array($departments) && !empty($departments) ? $departments[0] : 'no sample'
        ]);
        Log::info('Areas from API:', [
            'count' => is_array($areas) ? count($areas) : 'not an array',
            'sample' => is_array($areas) && !empty($areas) ? $areas[0] : 'no sample'
        ]);

        $jsonFile = public_path('data/' . $this->json); // Get the full path to the JSON file

        $trans = new DataTransformService;
        $formData = $trans->data_edit_transform($jsonFile, $employee, $departments, $areas);

        return $formData;
        // Return the Inertia view with the form data
        return Inertia::render('Views/form', [
            'title' => $this->title,
            'route' => $this->route,
            'formData' => $formData,
            'id' => $id
        ]);
    }

    public function deleteBio(Request $request)
    {

        $data= $request->all();

        $flatArray = Arr::flatten($request->all());

        $data = [
            "employees"=> $flatArray,
            "finger_print"=> true
        ];
       return $this->zkTecoService->deleteBio($data);
    }

    public function index1()
    {
        $params = [
            'page',
            'page_size',
            'emp_code',
            'emp_code_icontains',
            'first_name',
            'first_name_icontains',
            'last_name',
            'last_name_icontains',
            'department',
            'areas'
        ];

        // return response()->json($this->employeeService->getEmployees($params));
        $data = $this->zkTecoService->getEmployees();


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
