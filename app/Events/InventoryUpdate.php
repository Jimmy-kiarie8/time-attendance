<?php

namespace App\Events;

use Illuminate\Database\Eloquent\Model;
use Jimkiarie8\InventoryManagement\Models\Inventory;

class InventoryUpdate
{
    /**
     * Create a new InventoryUpdate instance.
     *
     * @param  \Jimkiarie8\InventoryManagement\Inventory|null  $oldInventory
     * @param  \Jimkiarie8\InventoryManagement\Inventory  $newInventory
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function __construct(public $oldInventory, public Inventory $newInventory, public Model $model)
    {
    }
}
