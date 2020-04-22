<?php

namespace App\Http\Controllers;

use App\Item;

class HomeController extends Controller
{
    public function frontPage()
    {
        $items = Item::whereNotNull('on_fp')->orderBy('on_fp')->get();
        return view('welcome', ['items' => $items]);
    }
}
