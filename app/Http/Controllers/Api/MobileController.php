<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MobileController extends Controller
{
    // Fetch Orders for a Driver
    public function getDriverOrders(Request $request)
    {
        // $driverId = $request->driver_id;
        $orders = Sale::with(['receiver', 'sender'])->paginate();
        // $orders = Sale::where('driver_id', $driverId)->get();
        return response()->json($orders);
    }

    public function getPendingOrders(Request $request)
    {
        $driverId = $request->driver_id;
        $orders = Sale::with(['receiver', 'sender'])->where('driver_id', $driverId)->where('accepted', false)->get();
        return response()->json($orders);
    }

    // Update Order Status
    public function updateOrderStatus(Request $request, $id)
    {
        $order = Sale::findOrFail($id);
        $order->status = $request->status;
        $order->save();
        return response()->json(['message' => 'Order status updated successfully']);
    }

    // Driver Location Update
    public function updateDriverLocation(Request $request)
    {
        $driver = Driver::findOrFail($request->driver_id);
        $driver->current_location = $request->location; // Assuming 'location' is a string like "lat, long"
        $driver->save();
        return response()->json(['message' => 'Location updated successfully']);
    }

    // Customer Places a New Order
    public function placeOrder(Request $request)
    {
        $order = new Sale();
        $order->fill($request->all()); // Make sure to validate and sanitize input
        $order->save();
        return response()->json(['message' => 'Order placed successfully']);
    }

    // Fetch Order Details
    public function getOrderDetails($order_no)
    {
        $order = Sale::with(['receiver', 'sender'])->where('order_no', $order_no)->first();
        return response()->json($order);
    }

    public function getOrder($id)
    {
        $order = Sale::with(['receiver', 'sender'])->findOrFail($id);
        return response()->json($order);
    }

    // Driver Accepts an Order
    public function acceptOrder(Request $request, $id)
    {
        $order = Sale::findOrFail($id);
        $order->driver_id = $request->driver_id;
        $order->status = 'Received';
        $order->accepted = true;
        $order->save();
        return response()->json(['message' => 'Order accepted']);
    }

    // User Authentication
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('AppToken')->accessToken; // Assuming you're using Laravel Passport for API authentication
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    // Logout User
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json(['message' => 'Successfully logged out']);
    }


    public function map_track(Request $request)
    {
        Log::debug($request->all());
    }
}
