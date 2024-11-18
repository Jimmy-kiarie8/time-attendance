<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\BaseController;
use App\Models\Transaction;

class TransactionController extends BaseController
{
    protected $mpesa, $store_transaction;


    public function __construct()
    {
        $this->model = new Transaction();
        $this->json = 'transactions.json';
        $this->title = 'Transaction';
        $this->route = 'transactions';
        $this->image = false;
        $this->upload = false;
        $this->image = false;
        $this->create = false;

        $this->actions = [
            // ['action_name' => 'Edit', 'icon' => 'mdi-pencil', 'color' => 'primary','route' => 'sheets'],
            // ['action_name' => 'Logo', 'icon' => 'mdi-image', 'color' => 'primary','route' => 'logo'],
        ];
    }

    public function reverse($id)
    {
        Transaction::find($id)->update(['overpayment_amount'=> 0]);
        return response()->json(['message' => 'Reversed!'], 201);
    }

}
