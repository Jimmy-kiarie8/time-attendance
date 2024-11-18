<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\BaseController;
use App\Http\Requests\StoreDeviceRequest;
use App\Http\Requests\UpdateDeviceRequest;
use App\Models\Device;

class DeviceController extends   BaseController
{
    public function __construct()
    {
        // Set properties specific to IngredientController
        $this->modelClass = Device::class;
        $this->model = new Device();
        $this->json = 'device.json';
        $this->title = 'Devices';
        $this->route = 'Devices';
        $this->upload = false;


        $this->actions = [
            ['action_name' => 'Edit', 'icon' => 'mdi-pencil', 'color' => 'primary', 'route' => 'loans'],
            ['action_name' => 'Delete', 'icon' => 'mdi-delete', 'color' => 'error', 'route' => 'loans'],
            // Add more actions as needed
        ];
    }
}
