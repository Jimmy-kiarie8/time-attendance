<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Logixsaas</title>

    {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"> --}}
    {{-- <link href="{{ asset('css/pdf2.css') }}" rel="stylesheet"> --}}
    <link href="{{ asset('css/pdf.css') }}" rel="stylesheet">

</head>

<body>
    <div class="mt-5 mb-5">
        <div class="d-flex justify-content-center row">
            <div class="col-md-10">
                <div class="receipt bg-white p-3 rounded">

                    <table class="table" style="margin-top: -35px;width: 100%">
                        <tr>
                            <td align="left" style="border: none">
                                <img src="https://logixsaas.com/wp-content/uploads/2023/08/Logixsaas-Consultancy-Limited-Logo_Approved-01-1-1.png" width="160" style="margin-top: 10px">
                            </td>
                            <td align="center" style="border: none">
                                <div style="">
                                    <h4 class="mt-2 mb-3">Sender</h4>
                                    <p class="fs-12 text-black-50">{{ $order->sender->name }}</p>
                                    <address class="fs-12 text-black-50">{{ $order->sender->phone }}</address>
                                    <address class="fs-12 text-black-50">{{ $order->sender->email }}</address>
                                    <address class="fs-12 text-black-50">{{ $order->sender->address }}</address>
                                </div>

                            </td>
                            <td align="right" style="text-align: left;border: none">
                                <div style="">
                                    <h4 class="mt-2 mb-3">Receiver</h4>
                                    <p class="fs-12 text-black-50">{{ $order->receiver->name }}</p>
                                    <address class="fs-12 text-black-50">{{ $order->receiver->phone }}</address>
                                    <address class="fs-12 text-black-50">{{ $order->receiver->email }}</address>
                                    <address class="fs-12 text-black-50">{{ $order->receiver->address }}</address>
                                </div>

                            </td>
                        </tr>
                    </table>
                    <table class="table bg-white table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Order date</th>
                                <th scope="col">Order number</th>
                                <th scope="col">Payment method</th>
                                <th scope="col">Shipping Address</th>
                                <th scope="col">City</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $order->created_at }}</td>
                                <td>{{ $order->order_no }}</td>
                                <td>COD</td>
                                <td>{{ $order->sender->address }}</td>
                                <td>{{ $order->sender->city }}</td>
                            </tr>
                        </tbody>
                    </table>

{{--
                    <table class="table bg-white table-bordered" style="width: 100%">
                        <thead>
                            <tr>
                                <th scope="col">Product name</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Mode of service</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->products as $product)
                                <tr>
                                    <td> {{ $product->product_name }} </td>
                                    <td> {{ $product->pivot->quantity }} </td>
                                    <td> Delivery service </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table> --}}


                    <table class="table">
                        <tr>
                            <td align="left">

                                <img src="{{ $order->barcode }}" alt="" style="width: 330px;height: 80px;"><br>
                                <b>{{ $order->order_no }}</b>
                            </td>
                            <td align="right">
                                <div style="d-block font-weight-bold; color:black">Total: <b>
                                        <b>{{ $order->shipping_charges }}</b></div>
                            </td>
                        </tr>
                    </table>

                    <span class="d-block">Expected delivery date</span><span class="font-weight-bold">
                        {{ Carbon\Carbon::parse($order->delivery_date)->format('D d M Y') }}
                    </span>
                    <hr>

                    <span class="d-block mt-3 text-black-50 fs-15">
                        <strong>{{ $order->notes }}</strong></span>


                </div>
            </div>
        </div>
    </div>


</body>

</html>
