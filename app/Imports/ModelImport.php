<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
// use App\Models\AutoGenerate;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ModelImport implements ToModel, WithHeadingRow, WithChunkReading, ShouldQueue, WithBatchInserts
{

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Model([
            //
        ]);
    }
    public function chunkSize(): int
    {
        return 1000;
    }


    public function batchSize(): int
    {
        return 100;
    }


    public function onUnknownSheet($sheetName)
    {
        // E.g. you can log that a sheet was not found.
        info("Sheet {$sheetName} was skipped");
    }
}
// protected $fillable = ['product_name','online_channel','prescription_only','active','manage_inventory','is_controlled','is_flagable','in_stock', 'short_description','description','cost_price','selling_price','compare_price','category_id', 'code', 'brand_id', 'subcategory_id'];
