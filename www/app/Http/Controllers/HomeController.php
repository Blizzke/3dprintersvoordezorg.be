<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function frontpage()
    {
        $items = \App\Item::whereNotNull('on_fp')->orderBy('on_fp');
        return view('welcome', ['items' => $items]);
    }
}
