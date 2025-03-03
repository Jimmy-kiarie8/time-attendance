<?php

namespace App\Services;

use App\Models\Branch;
use App\Models\Client;
use App\Models\Coa;
use App\Models\Guarantor;
use App\Models\Loan;
use App\Models\LoanType;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class DataTransformService
{

    public function data_transform($jsonFile)
    {
        if (!File::exists($jsonFile)) {
            return response('JSON file not found', 404);
        }

        $jsonData = json_decode(File::get($jsonFile), true);

        $modelMap = [
            'client_id' => 'clients',
            'role_id' => 'roles',
            'loan_id' => 'loans',
            'branch_id' => 'branches',
            'officer_id' => 'officers',
            'guarantor_id' => 'guarantors',
            'loan_type_id' => 'loan_types',
            'coa_id' => 'coa'
        ];

        $fetchModels = $this->getModelsToFetch($jsonData, $modelMap);
        $modelData = $this->fetchModelData($fetchModels);

        return $this->transformJsonData($jsonData, $modelData, $modelMap);
    }

    private function getModelsToFetch(array $jsonData, array $modelMap): array
    {
        $fetchModels = [];
        foreach ($jsonData as $item) {
            if ($item['type'] === 'select' && isset($modelMap[$item['model']])) {
                $fetchModels[$modelMap[$item['model']]] = true;
            }
        }
        return $fetchModels;
    }

    private function fetchModelData(array $fetchModels): array
    {
        $modelData = [];
        $modelClassMap = [
            'clients' => Client::class,
            'roles' => Role::class,
            'loans' => Loan::class,
            'branches' => Branch::class,
            'officers' => User::class,
            'guarantors' => Guarantor::class,
            'loan_types' => LoanType::class,
            'coa' => Coa::class
        ];

        foreach ($fetchModels as $model => $fetch) {
            if ($model === 'loans') {
                if ($fetch) {
                    $modelData[$model] = $modelClassMap[$model]::select('id', 'reference')->take(100)->get();
                }
            }
            elseif ($model === 'officers') {
                $modelData[$model] = $modelClassMap[$model]::role("Loan Officer")->get();
            }

            else {
                if ($fetch) {
                    $modelData[$model] = $modelClassMap[$model]::select('id', 'name')->take(100)->get();
                }
            }
        }
        return $modelData;
    }

    private function transformJsonData(array $jsonData, array $modelData, array $modelMap): array
    {
        foreach ($jsonData as &$item) {
            if ($item['type'] === 'select' && isset($modelMap[$item['model']])) {
                $modelKey = $modelMap[$item['model']];
                if (isset($modelData[$modelKey])) {
                    $item['items'] = $modelData[$modelKey]->map(function ($modelItem) {
                        return [
                            'value' => $modelItem->id,
                            'label' => $modelItem->name
                        ];
                    })->toArray();
                }
            }
            elseif ($item['type'] === 'date') {
                // dd($item['model'], Carbon::now()->format('Y-m-d'));
                $item['value'] = Carbon::now()->format('Y-m-d');
            }
        }
        return $jsonData;
    }


    public function data_edit_transform($jsonFile, $data, $departments = null, $areas = null)
    {
        if (!File::exists($jsonFile)) {
            return response('JSON file not found', 404);
        }

        // Decode JSON file content
        $jsonData = json_decode(File::get($jsonFile), true);

        // Validate that the data is present
        if (!$data) {
            return response('Data not found', 404);
        }

        // Convert data to object if it's an array
        if (is_array($data)) {
            $data = json_decode(json_encode($data));
        }

        // Define the model mapping similar to data_transform
        $modelMap = [
            'department_id' => 'departments',
            'area_id' => 'areas',
            'guarantor_1' => 'guarantors',
            'coa_id' => 'coa',
            'loan_type_id' => 'loan_types',
            // Add other mappings if necessary
        ];

        // Fetch any models needed for 'select' fields
        $fetchModels = $this->getModelsToFetch($jsonData, $modelMap);
        $modelData = $this->fetchModelData($fetchModels);

        // Add departments from API if available
        if ($departments) {
            $depts = collect();
            foreach ($departments as $dept) {
                if (is_array($dept)) {
                    $depts->push((object)[
                        'id' => $dept['id'],
                        'name' => $dept['dept_name']
                    ]);
                } else {
                    $depts->push((object)[
                        'id' => $dept->id,
                        'name' => $dept->dept_name
                    ]);
                }
            }
            $modelData['departments'] = $depts;
        } elseif (isset($data->department)) {
            $modelData['departments'] = collect([
                (object)[
                    'id' => $data->department->id,
                    'name' => $data->department->dept_name
                ]
            ]);
        }

        // Add areas from API if available
        if ($areas) {
            $areasList = collect();
            foreach ($areas as $area) {
                if (is_array($area)) {
                    $areasList->push((object)[
                        'id' => $area['id'],
                        'name' => $area['area_name']
                    ]);
                } else {
                    $areasList->push((object)[
                        'id' => $area->id,
                        'name' => $area->area_name
                    ]);
                }
            }
            $modelData['areas'] = $areasList;
        } elseif (isset($data->area) && is_array($data->area)) {
            $areasList = collect();
            foreach ($data->area as $area) {
                $areasList->push((object)[
                    'id' => $area->id,
                    'name' => $area->area_name
                ]);
            }
            $modelData['areas'] = $areasList;
        }

        // Transform the JSON data using both the database values and the pre-fetched model data
        return $this->transformJsonDataWithDbValues($jsonData, $modelData, $modelMap, $data);
    }

    private function transformJsonDataWithDbValues(array $jsonData, array $modelData, array $modelMap, $data): array
    {
        foreach ($jsonData as &$item) {
            // Handle 'text' fields: Replace value with the data from the database
            if (($item['type'] === 'date' || $item['type'] === 'text' || $item['type'] === 'long_text' ||$item['type'] === 'number') && isset($data->{$item['model']})) {
                $item['value'] = $data->{$item['model']};  // Fill with the value from the database record
            }

            // Handle special nested fields from employee data
            if ($item['model'] === 'department_id' && isset($data->department)) {
                $item['value'] = $data->department->id;
            }

            if ($item['model'] === 'department_name' && isset($data->department)) {
                $item['value'] = $data->department->dept_name;
            }

            if ($item['model'] === 'area_id' && isset($data->area) && !empty($data->area)) {
                $item['value'] = $data->area[0]->id;  // Get the first area ID
            }

            if ($item['model'] === 'area_name' && isset($data->area) && !empty($data->area)) {
                $item['value'] = $data->area[0]->area_name;  // Get the first area name
            }

            // Handle attemployee fields
            if (strpos($item['model'], 'attemployee.') === 0 && isset($data->attemployee)) {
                $attField = str_replace('attemployee.', '', $item['model']);
                if (isset($data->attemployee->{$attField})) {
                    $item['value'] = $data->attemployee->{$attField};
                }
            }

            // Special handling for department field
            if ($item['model'] === 'department' && $item['type'] === 'select') {
                if (isset($modelData['departments'])) {
                    // Set options from departments data
                    $item['items'] = $modelData['departments']->map(function ($dept) {
                        return [
                            'value' => $dept->id,
                            'label' => $dept->name
                        ];
                    })->toArray();

                    // Set the value to match the expected structure in the example
                    if (isset($data->department)) {
                        // Convert to array if it's an object
                        if (is_object($data->department)) {
                            $item['value'] = [
                                'id' => $data->department->id,
                                'dept_code' => $data->department->dept_code,
                                'dept_name' => $data->department->dept_name
                            ];
                        } else {
                            $item['value'] = $data->department;
                        }
                    }
                }
            }

            // Special handling for area field
            if ($item['model'] === 'area' && $item['type'] === 'select') {
                if (isset($modelData['areas'])) {
                    // Set options from areas data
                    $item['items'] = $modelData['areas']->map(function ($area) {
                        return [
                            'value' => $area->id,
                            'label' => $area->name
                        ];
                    })->toArray();

                    // Set the value to match the expected structure in the example
                    if (isset($data->area) && !empty($data->area)) {
                        $areaArray = [];
                        foreach ($data->area as $area) {
                            if (is_object($area)) {
                                $areaArray[] = [
                                    'id' => $area->id,
                                    'area_code' => $area->area_code,
                                    'area_name' => $area->area_name
                                ];
                            } else {
                                $areaArray[] = $area;
                            }
                        }
                        $item['value'] = $areaArray;
                    }
                }
            }

            // Handle 'select' fields: Add items from the related models
            if ($item['type'] === 'select' && isset($modelMap[$item['model']])) {
                $modelKey = $modelMap[$item['model']];
                if (isset($modelData[$modelKey])) {
                    // Set options from the related model data
                    $item['items'] = $modelData[$modelKey]->map(function ($modelItem) {
                        return [
                            'value' => $modelItem->id,
                            'label' => $modelItem->name
                        ];
                    })->toArray();

                    // Set the current selected value from the database record
                    if ($item['model'] === 'department_id' && isset($data->department)) {
                        $item['value'] = $data->department->id;
                    } elseif ($item['model'] === 'area_id' && isset($data->area) && !empty($data->area)) {
                        $item['value'] = $data->area[0]->id;
                    } else {
                        $item['value'] = $data->{$item['model']} ?? null;
                    }
                }
            } elseif($item['type'] === 'select') {
                if ($item['model'] === 'department_id' && isset($data->department)) {
                    $item['value'] = $data->department->id;
                } elseif ($item['model'] === 'area_id' && isset($data->area) && !empty($data->area)) {
                    $item['value'] = $data->area[0]->id;
                } else {
                    $item['value'] = $data->{$item['model']} ?? null;
                }
            }
        }

        return $jsonData;
    }

    public function store($data)
    {
        $dataValue = [];
        foreach ($data as $item) {
            $model = $item['model'];
            if ($item['type']  == 'radio') {
                $value = ($item['value'] == 'Yes') ? true : false;
            } elseif ($item['type']  == 'select') {
                $value = null;

                if (isset($item['value'])) {
                    if (is_array($item['value'])) {
                        $value = isset($item['value']['value']) ? $item['value']['value'] : null;
                    } elseif (is_string($item['value'])) {
                        $value = $item['value']; // If it's a string, directly assign it
                    } elseif (is_integer($item['value'])) {
                        $value = $item['value']; // If it's a string, directly assign it
                    }
                }
                Log::info($value);
            } else {
                $value = $item['value'];
            }

            $dataValue[$model] = $value;
        }
        return $dataValue;
    }
}
