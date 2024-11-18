<?php

namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use App\Mail\UserMail;
use App\Models\Company;
use App\Models\File;
use App\Models\Role;
use App\Models\User;
use App\Services\DataTransformService;
use App\Services\ZKTecoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use Illuminate\Support\Str;


abstract class BaseController extends Controller
{
    protected $model;
    protected $modelClass;
    protected $json;
    protected $title;
    protected $route;
    protected $image;
    protected $upload = false;
    protected $actions;
    protected $create = false;
    protected $stepper = false;
    protected $canFilter = false;
    protected $canFilterTab = false;
    protected $filterRoute = '';
    protected $filterFile = 'filters.json';
    protected $modalWidth = 700;
    protected $apiFun;
    protected $queryParams=[];

    protected function getRequestClass(): string
    {
        return 'App\\Http\\Requests\\Store' . class_basename($this->modelClass) . 'Request';
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $zkTecoService = new ZKTecoService;
        // Dynamically call the method stored in $this->apiFun
        if (method_exists($zkTecoService, $this->apiFun)) {
            $data = $zkTecoService->{$this->apiFun}($this->queryParams); // Call the method dynamically
        } else {
            // Handle the case where the method does not exist
            // e.g., throw an exception or log an error
            abort(404, "Method {$this->apiFun} not found in ZKTecoService");
        }


        if (request('axios')) {
            // return $this->model->paginate(100);
        }
        // $data = $this->model->latest()->paginate(100);
        $company = Company::first();

        $jsonFile = public_path('data/' . $this->json); // Get the full path to the JSON file

        $trans = new DataTransformService;
        $jsonData = $trans->data_transform($jsonFile);


        $headers = [];

        // $headers[] = ['title' => 'Created At', 'key' => 'created_at'];
        $employees = $zkTecoService->getEmployeeData();
        $department = $zkTecoService->getDepartmentData();
        $areas = $zkTecoService->getAreaData();

        foreach ($jsonData as $key => $item) {
            if ($item['model'] === 'employee') {
                $jsonData[$key]['items'] = $employees;
            } elseif($item['model'] === 'department') {
                $jsonData[$key]['items'] = $department;
            } elseif($item['model'] === 'area') {
                $jsonData[$key]['items'] = $areas;
            }


            if ($item['table_display']) {
                $headers[] = [
                    'title' => $item['label'],
                    'key' => $item['model']
                ];
            }
        }
        // $headers[] = ['title' => 'Actions', 'key' => 'actions'];

        $filterData = null;
        if ($this->canFilter) {
            // Filter
            $jsonFilter = public_path('data/' . $this->filterFile); // Get the full path to the JSON file

            $trans = new DataTransformService;
            $filterData = $trans->data_transform($jsonFilter);
            if ($this->route === 'attendance') {

                foreach ($filterData as $key => $value) {
                    if ($value['model'] === 'employee') {
                        $filterData[$key]['items'] = $employees;
                    } elseif($value['model'] === 'department') {
                        $filterData[$key]['items'] = $department;
                    }
                }

            }
        }

        // return $filterData;

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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $requestClass = $this->getRequestClass();
        $formRequest = new $requestClass();
        $validated = $request->validate($formRequest->rules());


        $dataValue = $validated;

        DB::beginTransaction();

        try {
            // $jsonFile = public_path('data/' . $this->json); // Get the full path to the JSON file

            // $trans = new DataTransformService;
            // $jsonData = $trans->data_transform($jsonFile);
            // Handle file uploads
            // $client_id = (array_key_exists('client_id', $dataValue)) ? $dataValue['client_id'] : null;
            // $user_id = (array_key_exists('user_id', $dataValue)) ? $dataValue['client_id'] : null;
            // foreach ($jsonData as $field) {
            //     if ($field['type'] === 'file' && $request->hasFile($field['model'])) {
            //         if ($field['multiple']) {
            //             $files = $request->file($field['model']);
            //             foreach ($files as $file) {
            //                 $path = $file->store('/storage/uploads/' . $field['model'], 'public');
            //                 $this->upload($path, $client_id, $field['label']);
            //             }
            //         } else {
            //             $path = $request->file($field['model'])->store('/storage/uploads/' . $field['model'], 'public');
            //             $this->upload($path, $client_id, $field['label']);
            //         }
            //     }
            // }



            if ($this->route == 'users') {
                $password = Str::random(8);
                $dataValue['password'] = Hash::make($password);
            }

            $dataValue['user_id'] = Auth::id();

            $dataValue['processing_fee_paid'] = true;
            $model = $this->model->create($dataValue);


            if ($this->route == 'users') {
                $role = Role::find($dataValue['role_id']);
                // $role = Role::find($dataValue['role_id']);
                $model->assignRole($role);

                $user = User::find($model->id);
                // Mail::to($user->email)->send(new UserMail($user, $password));
            }
            DB::commit();
            return response()->json(['message' => $this->title . ' Created']);

            // return redirect()->back()->with('message', 'Created');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return $this->model->find($id);
    }

    public function edit($id)
    {
        $driver_groups = $this->model->find($id);

        $jsonFile = public_path('data/' . $this->json); // Get the full path to the JSON file

        $trans = new DataTransformService;
        return $trans->data_edit_transform($jsonFile, $driver_groups);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        // $trans = new DataTransformService;
        $dataValue = $request->all();

        DB::beginTransaction();

        try {

            $this->model->find($id)->update($dataValue);

            // if ($this->route == 'users') {
            //     $role = Role::find($dataValue['role_id']);
            //     $this->model->find($id)->assignRole($role);
            // }

            DB::commit();
            return response()->json(['message' => $this->title . ' Updated']);
            // return redirect()->back()->with('message', 'Updated');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->model->find($id)->delete();
        return redirect()->back()->with('message', 'Deleted');
    }

    public function image(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            if ($request->hasFile('file')) {

                $image = $request->file('file');
                $image_path = $image->store($this->title, 'public');
                $image = "/storage/" . $image_path;

                if ($this->route == 'company') {
                    $this->model->find($id)->update(['logo' => $image]);
                } else {
                    $this->model->find($id)->update(['image' => $image]);
                }
            } else {
                return;
            }

            DB::commit();

            return redirect()->back()->with('message', 'Image uploaded');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function jsonData()
    {
        $file = request('file');
        // $docs = request('docs');

        $jsonFile = public_path('data/' . $file); // Get the full path to the JSON file

        $trans = new DataTransformService;
        return $trans->data_transform($jsonFile);
    }
}
