<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\BaseController;
use App\Http\Requests\StoreShiftRequest;
use App\Http\Requests\UpdateShiftRequest;
use App\Models\Shift;

class ShiftController extends  BaseController
{
    public function __construct()
    {
        // Set properties specific to IngredientController
        $this->modelClass = Shift::class;
        $this->model = new Shift();
        $this->json = 'shift.json';
        $this->title = 'Shifts';
        $this->route = 'shift';
        $this->upload = false;


        $this->actions = [
            ['action_name' => 'Edit', 'icon' => 'mdi-pencil', 'color' => 'primary', 'route' => 'loans'],
            ['action_name' => 'Delete', 'icon' => 'mdi-delete', 'color' => 'error', 'route' => 'loans'],
            // Add more actions as needed
        ];
    }
}
