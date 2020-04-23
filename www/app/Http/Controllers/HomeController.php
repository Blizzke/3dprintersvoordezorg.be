<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Item;
use App\Order;
use App\OrderStatus;

class HomeController extends Controller
{
    public function frontPage()
    {
        $items = Item::whereNotNull('on_fp')->orderBy('on_fp')->get();

        $printed = OrderStatus::selectRaw('sum(quantity) AS sum')->whereIn('order_id', function ($q) {
            $q->from('orders')->select('id')->where('status_id', 4);
        })->firstOrFail()['sum'];

        $printing = Order::selectRaw('sum(quantity) AS sum')->whereIn('status_id', [1, 2])->firstOrFail()['sum'];

        $wait = Order::selectRaw('sum(quantity) AS sum')->where('status_id', 0)->firstOrFail()['sum'];

        $volunteers = Helper::count();

        return view('welcome', ['items' => $items, 'printed' => $printed, 'printing' => $printing, 'wait' => $wait, 'helpers' => $volunteers]);
    }
}
