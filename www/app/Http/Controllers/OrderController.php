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
        $this->middleware('auth:customers,helpers')
            ->except('customerLogin', 'newOrderView', 'newOrderForm');
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
        if ($request->has('is_internal'))
            $status->is_internal = true;

        $status->save();
        return redirect()->route('order', ['order' => $order->identifier]);
    }

    public function updateStatus(Order $order, Request $request)
    {
        $request->validate(['status' => 'required|numeric']);
        $order->statusUpdateStatus($request->get('status'), false, Auth::user());
        return redirect()->route('order', ['order' => $order->identifier]);
    }

    public function addQuantity(Order $order, Request $request)
    {
        $request->validate(['quantity' => 'required|numeric']);

        $status = $order->newStatus(false, Auth::user());
        $status->type = 'quantity';
        $status->quantity = $request->post('quantity');
        $status->save();
        return redirect()->route('order', ['order' => $order->identifier]);
    }

    public function customerLogin($customer, $order)
    {
        if ($customer->identifier != $order->customer->identifier)
            // Don't go to login page, that's for helpers
            throw new AuthenticationException('Foute ordergegevens', [], '/');

        Auth::guard('customers')->login($customer);
        return redirect()->route('order', ['order' => $order->identifier]);
    }

    public function newOrderView()
    {
        return view('orders.new', ['items' => \App\Item::query()->get()]);
    }

    public function newOrderForm(Request $request)
    {

    }
}
