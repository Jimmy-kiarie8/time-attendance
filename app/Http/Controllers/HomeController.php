<?php

namespace App\Http\Controllers;

use App\Services\DataTransformService;

class HomeController extends Controller
{

    public function jsonData()
    {
        $file = request('file');
        // $docs = request('docs');

        $jsonFile = public_path('data/' . $file); // Get the full path to the JSON file

        $trans = new DataTransformService;
        return $trans->data_transform($jsonFile);
    }
}
