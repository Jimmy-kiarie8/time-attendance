<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\BaseController;
use App\Http\Requests\StoreHolidayRequest;
use App\Http\Requests\UpdateHolidayRequest;
use App\Models\Holiday;

class HolidayController extends   BaseController
{
    public function __construct()
    {
        // Set properties specific to IngredientController
        $this->modelClass = Holiday::class;
        $this->model = new Holiday();
        $this->json = 'holiday.json';
        $this->title = 'Holidays';
        $this->route = 'Holidays';
        $this->upload = false;


        $this->actions = [
            ['action_name' => 'Edit', 'icon' => 'mdi-pencil', 'color' => 'primary', 'route' => 'loans'],
            ['action_name' => 'Delete', 'icon' => 'mdi-delete', 'color' => 'error', 'route' => 'loans'],
            // Add more actions as needed
        ];
    }
}
