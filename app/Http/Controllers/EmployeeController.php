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
