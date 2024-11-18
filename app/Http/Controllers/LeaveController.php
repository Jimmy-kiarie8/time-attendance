<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\BaseController;
use App\Http\Requests\StoreLeaveRequest;
use App\Http\Requests\UpdateLeaveRequest;
use App\Models\Leave;

class LeaveController extends   BaseController
{
    public function __construct()
    {
        // Set properties specific to IngredientController
        $this->modelClass = Leave::class;
        $this->model = new Leave();
        $this->json = 'leave.json';
        $this->title = 'Leaves';
        $this->route = 'Leaves';
        $this->upload = false;


        $this->actions = [
            ['action_name' => 'Edit', 'icon' => 'mdi-pencil', 'color' => 'primary', 'route' => 'loans'],
            ['action_name' => 'Delete', 'icon' => 'mdi-delete', 'color' => 'error', 'route' => 'loans'],
            // Add more actions as needed
        ];
    }
}
