<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Services\DataTransformService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonFile = public_path('data/settings-field.json');
        $trans = new DataTransformService;
        $jsonData = $trans->data_transform($jsonFile);

        foreach ($jsonData as $data) {
            $setting = new Setting();
            $setting->name = $data['model'];
            $value = $data['value'];
            $value_type = $data['type'];

            if ($data['type'] == "radio") {
                $value_type = 'boolean';
                if ($data['value'] == "Yes") {
                    $value = true;
                } else {
                    $value = false;
                }
            }
            $setting->value = $value;
            $setting->value_type = $value_type;
            $setting->save();
        }
    }
}
