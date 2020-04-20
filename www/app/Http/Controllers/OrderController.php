<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function accept($order)
    {
        /** @var Order $order */
        $order = Order::whereIdentifier($order)->firstOrFail();
        $order->assign(Auth::user());
        return redirect()->route('dashboard');
    }

    public function release($order)
    {
        /** @var Order $order */
        $order = Order::whereIdentifier($order)->firstOrFail();
        $order->release(Auth::user());
        return redirect()->route('dashboard');
    }

    public function work($order, Request $request)
    {
        /** @var Order $order */
        $order = Order::whereIdentifier($order)->firstOrFail();
        if ($request->has('items')) {
            $status = $order->newStatus(false, Auth::user());
            $status->quantity = $request->get('items');
            $status->save();
        }

        if ($request->ajax())
            // Don't return a redirect response for ajax, XHR tries to reload via ajax, kinda sux
            return response()->json(['redirect_to' => route('dashboard')]);
        return redirect()->route('dashboard');
    }
}
