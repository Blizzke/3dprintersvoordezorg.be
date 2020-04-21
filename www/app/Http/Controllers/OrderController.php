<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Order;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:helpers,customers')->except('customerLogin');
    }

    public function accept(Order $order)
    {
        $order->assign(Auth::user());
        return redirect()->route('dashboard');
    }

    public function release(Order $order)
    {
        $order->release(Auth::user());
        return redirect()->route('dashboard');
    }

    public function cancel(Order $order)
    {
        $order->cancel(Auth::user());
        return redirect()->route('dashboard');
    }

    public function work(Order $order, Request $request)
    {
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

    public function view(Order $order)
    {
        return view('orders.details', ['order' => $order]);
    }

    public function addComment(Order $order, Request $request)
    {
        $request->validate(['comment' => 'required']);

        $status = $order->newStatus(is_customer(), !is_customer() ? Auth::user(): null);
        $status->comment = $request->post('comment');
        $status->save();
        return redirect()->route('order', ['order' => $order->identifier]);
    }

    public function customerLogin($customer, $order)
    {
        // 127.0.0.1:8000/customer/3796438236/order/1586982646
        if ($customer->identifier != $order->customer->identifier)
            // Don't go to login page, that's for helpers
            throw new AuthenticationException('Foute ordergegevens', [], '/');

        Auth::guard('customers')->login($customer);
        return redirect()->route('order', ['order' => $order->identifier]);
    }
}
