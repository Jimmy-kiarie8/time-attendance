<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\BaseController;
use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Models\Department;

class DepartmentController extends  BaseController
{
    public function __construct()
    {
        $this->modelClass = Department::class;
        $this->model = new Department();
        $this->json = 'department.json';
        $this->title = 'Departments';
        $this->route = 'Departments';
        $this->upload = false;

        $this->apiFun = 'getDepartments';


        $this->actions = [
            // ['action_name' => 'Edit', 'icon' => 'mdi-pencil', 'color' => 'primary', 'route' => 'loans'],
            // ['action_name' => 'Delete', 'icon' => 'mdi-delete', 'color' => 'error', 'route' => 'loans'],
            // Add more actions as needed
        ];
    }
}
