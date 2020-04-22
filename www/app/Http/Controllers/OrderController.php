<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Item;
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
        $product = [
            'item' => 'required|exists:items,name',
            'quantity' => 'required|numeric|max:200',
        ];

        // Still here, if we don't have a customer, create one:
        $input = $request->all();

        /** @var Customer $customer */
        if ($request->filled('customer_id')) {
            // Customer ID was specified, validate against database
            $request->validate(['customer_id' => 'required|exists:customers,identifier'] + $product);
            $customer = Customer::whereIdentifier($request->post('customer_id'))->first();
        }
        else {
            $request->validate([
                'sector' => 'required',
                'name' => 'required',
                'zip' => 'required',
                'phone' => 'required_without_all:mobile,email',
                'mobile' => 'required_without_all:phone,email',
                'email' => 'required_without_all:phone,mobile',
            ] + $product);
            $customer = Customer::create($input);
        }

        Auth::guard('customers')->login($customer);

        /** @var Order $order */
        // Now the order, since we create in one go and customer/item are required, mass assign them as well
        $input['customer_id'] = $customer->id;
        $input['item_id'] = Item::whereName($input['item'])->firstOrFail()->id;
        $order = Order::create($input);

        $order->statusUpdateStatus(0, true);
        $order->save();

        // Optional comment
        if ($request->filled('comment')) {
            $status = $order->newStatus(true);
            $status->comment = $request->get('comment');
            $status->save();
        }

        return redirect()->route('order', ['order' => $order->identifier]);
    }
}
