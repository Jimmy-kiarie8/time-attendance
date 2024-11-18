<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\BaseController;
use App\Models\Loan;
use App\Models\Mpesa;
use App\Models\Transaction;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class MpesaController extends BaseController
{
    protected $mpesa, $store_transaction;


    public function __construct()
    {
        $this->model = new Mpesa();
        $this->json = 'mpesa.json';
        $this->title = 'Mpesa';
        $this->route = 'mpesa';
        $this->image = false;
        $this->upload = false;
        $this->image = false;
        $this->store_transaction = new PaymentService;

        $this->actions = [
            ['action_name' => 'Edit', 'icon' => 'mdi-pencil', 'color' => 'primary','route' => 'sheets'],
            // ['action_name' => 'Logo', 'icon' => 'mdi-image', 'color' => 'primary','route' => 'logo'],
            // Add more actions as needed
        ];
    }


    public function mpesa()
    {
        return Mpesa::first();
    }


    public function confirmation(Request $request)
    {
        $response = $request->all();
        return  $this->store_transaction->store_transaction($response);

        return response()->json(['message' => 'Payments applied to outstanding loans!']);

    }

    public function mpesa_update()
    {
        $transactions = Transaction::all();
        // $transaction
        foreach ($transactions as  $transaction) {
            $this->order_update($transaction->MSISDN, $transaction->TransAmount, $transaction->TransID);
        }
    }


    public function qrCode()
    {
        return $this->store_transaction->generateDynamicQRCode('LASS1', 1);
        return $this->store_transaction->authorizationToken();

        $shortcode = env('MPESA_SHORT_CODE');
        $passkey = env('MPESA_API_SECRET');
        $timestamp = date('YmdHis', strtotime('now'));
        return $this->store_transaction->base64($shortcode . $passkey . $timestamp);
    }
    public function url_register()
    {
     return   $this->store_transaction->url_register();
    }
    public function validation_url()
    {
        return true;
    }

    public function transaction_search($search)
    {
        $transactions = Transaction::where(function ($query) use ($search) {
            $query->where('MSISDN', 'LIKE', '%' . $search . '%');
            $query->orWhere('BillRefNumber', 'LIKE', '%' . $search . '%');
            $query->orWhere('TransID', 'LIKE', '%' . $search . '%');
            $query->orWhere('FirstName', 'LIKE', '%' . $search . '%');
            $query->orWhere('MiddleName', 'LIKE', '%' . $search . '%');
            $query->orWhere('LastName', 'LIKE', '%' . $search . '%');
        })->paginate(200);

        $transactions->transform(function ($transaction) {
            $transaction->name = $transaction->FirstName . ' ' . $transaction->MiddleName . ' ' . $transaction->LastName;
            return $transaction;
        });
        return $transactions;
    }

    public function transaction_loan($code)
    {
        return Loan::setEagerLoads([])->with(['client', 'products'])->where('mpesa_code', $code)->first();
    }

    public function stk_push($id, $phone)
    {
        $this->store_transaction->stk_push($id, $phone);
    }

    public function stk_response(Request $request, $order_no)
    {

        $resultBody = json_decode($request->getContent());
        $data  = $resultBody->Body->stkCallback->CallbackMetadata->Item;



        $amount = $data[0]->Value;
        $MpesaReceiptNumber = $data[1]->Value;
        // $PhoneNumber = $data[4]->Value;
        $this->order_paid($order_no, $amount, $MpesaReceiptNumber);

        return;
    }

    public function transactions_filter(Request $request)
    {
        $date = $request->date;
        $transactions = Transaction::when(!empty($date), function ($q) use ($date) {

            if ($date[0] == $date[1]) {
                return $q->whereDate('TransTime', $date);
            } else {
                return $q->whereBetween('TransTime', $date);
            }
        })->orderBy('id', 'DESC')->paginate(500);

        $transactions->transform(function ($transaction) {
            $transaction->name = $transaction->FirstName . ' ' . $transaction->MiddleName . ' ' . $transaction->LastName;
            return $transaction;
        });
        return $transactions;
    }
}
