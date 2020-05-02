<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Item;
use App\Order;
use App\OrderHelper;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:helpers,customers')
            ->except('customerLogin', 'orderOverview', 'newOrderView', 'newOrderForm');
    }

    public function accept(Order $order, Request $request)
    {
        $order->assign(Auth::user());
        if ($request->filled('details') && $request->get('details') == 1) {
            // Redirect to the order details page instead of dashboard
            return redirect()->route('order', ['order' => $order->identifier]);
        }
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

    public function participate(Order $order)
    {
        return view('helpers.orders.participate', ['order' => $order]);
    }

    public function doParticipate(Order $order, Request $request)
    {
        $request->validate(['quantity' => 'required|numeric|min:1', 'comment' => 'required']);
        $participant = new OrderHelper($request->all());
        $participant->order()->associate($order);
        $participant->helper()->associate(Auth::user());
        // Approve by default to speed up things, since the coordinator asked for help.
        $participant->approved = true;
        $participant->saveOrFail();

        return redirect()->route('order', ['order' => $order->identifier]);
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
        if (Auth::user() instanceof \App\Helper) {
            return view('helpers.orders.details', ['order' => $order]);
        }
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

    public function updateOptions(Order $order, Request $request)
    {
        if ($request->get('material') != $order->material) {
            $order->material = $request->get('material');
            $order->helperComment('Het materiaal werd aangepast naar "' . Order::MATERIALS[$order->material] . '"', true);
        }

        $please_help = (bool) ((int)$request->get('please_help', 0));
        if ($please_help != $order->help_is_welcome) {
            $order->help_is_welcome = $please_help;
            $order->helperComment('Hulp gevraag status werd aangepast naar: ' . ($please_help ? 'ja' : 'nee'), true);
        }
        $order->save();
        return redirect()->back();
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
        $input = $request->all();

        Validator::extend('products_ordered', function ($attribute, $value, $parameters, $validator) {
             return count(array_filter($value, function($var) use ($parameters) { return ( $var && (int)$var >= (int)$parameters[0]); }));
        });

        Validator::extend('sector_limits', function ($attribute, $value, $parameters, $validator) use ($input) {
            $sector = isset($input['sector']) ? $input['sector'] : null;
            if (isset($input['customer_id'])) {
                // Pre-existing customer, fetch it and its sector
                $customer = Customer::select('sector')->whereIdentifier($input['customer_id'])->first();
                if ($customer) {
                    $sector = $customer->sector;
                }
            }

            $items = Item::select('type', 'sector')->get();
            foreach ($items as $item) {
                if (!$value[$item->type] || !$item->sector)
                    // No products of this type ordered or not limited by sector
                    continue;

                if (!$sector || strpos($item->sector, "|$sector|") === false)
                    // The sector is not in the allowed sectors
                    return false;
            }
            return true;
        });

        $product = [
            'quantity'   => 'products_ordered:1|sector_limits',
        ];
        $messages = [
            'products_ordered' => 'Gelieve minstens 1 product te bestellen',
            'sector_limits' => 'Eén of meer van de producten die je besteld zijn gelimiteerd op klanten-sector'
        ];

        /** @var Customer $customer */
        if ($request->filled('customer_id')) {
            // Customer ID was specified, validate against database
            $request->validate(['customer_id' => 'required|exists:customers,identifier'] + $product, $messages);
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
            ] + $product, $messages);
            $customer = Customer::create($input);
        }

        Auth::guard('customers')->login($customer);

        /** @var Order $order */
        // Now the order, since we create in one go and customer/item are required, mass assign them as well
        $input['customer_id'] = $customer->id;

        $orders = 0;
        foreach ($input['quantity'] as $item => $quantity) {
            if (!$quantity)
                // Laravel adds "nulls" so skip those
                continue;

            $order = new Order();
            $order->fill($input);

            $item = Item::whereType($item)->firstOrFail();
            $order->item()->associate($item);
            $order->quantity = $quantity;

            $order->statusUpdateStatus(0, true);
            $order->save();

            // Optional comment
            if ($request->filled('comment')) {
                $status = $order->newStatus(true);
                $status->comment = $request->get('comment');
                $status->save();
            }

            $this->notifyDiscord($order);
            $orders ++;
        }

        if ($orders === 1) {
            // 1 order, go directly to order details
            return redirect()->route('order', ['order' => $order->identifier]);
        }
        // Redirect to order overview page
        return redirect()->route('customer', ['customer' => $customer->identifier]);
    }

    public function orderOverview(Customer $customer)
    {
        return view('orders.list', ['customer' => $customer]);
    }

    private function notifyDiscord(Order $order)
    {
        try {
            $hookUrl = env('DISCORD_ORDER_HOOK');
            if ($hookUrl) {
                $closestHelpers = $order->closestHelpers();
                $helperList = [];
                if ($closestHelpers) {
                    foreach ($closestHelpers as $helper) {
                        $helperList[] = $helper['name'] . ' (' . $helper['distance'] . ')';
                    }
                    $helperList = "\n\nDichtstbijzende helpers: " . implode(', ', $helperList);
                }

                $curl = curl_init($hookUrl);
                // Return, don't echo...
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                // Discord always expects form-data
                curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
                // And a post
                curl_setopt($curl, CURLOPT_POST, 1);

                $orderUrl = route('order', ['order' => $order->identifier]);
                $order = <<<EOD
__**Nieuwe bestelling: {$order->customer->zip}**__ - $orderUrl
```
Gemeente: {$order->customer->zip} {$order->customer->city}

Naam: {$order->customer->name} ({$order->customer->sector})

Aantal: {$order->quantity}

Type: {$order->item->title}$helperList
```
EOD;
                curl_setopt($curl, CURLOPT_POSTFIELDS, $query = json_encode(['content' => $order]));
                curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt($curl, CURLOPT_HEADER, 0);
                curl_exec($curl);
                curl_close($curl);
            }
        }
        catch (\Throwable $e) {
        }
    }

    public function viewMap(Order $order)
    {
        return view('orders.map', ['order' => $order]);
    }
}
