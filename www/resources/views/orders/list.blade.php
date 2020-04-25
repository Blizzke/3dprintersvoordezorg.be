@extends('layouts.request')
@section('title', "Klant {$customer->identifier}")
@section('content')
<div class="block-31" style="position: relative;">
    <div class="owl-carousel loop-block-31 ">
        <div class="block-30 block-30-sm item" style="background-image: url('/images/shields1.jpg');"
             data-stellar-background-ratio="0.5">
            <div class="container">
                <div class="row align-items-center justify-content-center text-center">
                    <div class="col-md-7">
                        <h2 class="heading mb-5">@yield('title')</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Misschien vermelden: We splitsen de bestellingen per item omdat niet iedereen alle items kan opleveren --}}

<div class="site-section bg-light">
    <div class="container">
        @foreach($customer->orders as $order)
            Bestelling {{$order->identifier}} <br />
            <a href="{{route('order-customer', ['customer' => $customer->identifier, 'order'=> $order->identifier])}}">bekijken</a><br />
            Status: <span class="glyphicon
            @switch($order->status_id)
                @case(0)
                    glyphicon-asterik
                    @break
                @case(1)
                    glyphicon-tag
                    @break
                @case(2)
                    glyphicon-print
                    @break
                @case(3)
                    glyphicon-envelope
                    @break
                @case(4)
                    glyphicon-ok
                    @break
                @case(5)
                    glyphicon-remove
                    @break
            @endswitch
            " aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="{{$order->status}}"></span> {{$order->status}}<br />
            @if(!$order->is_new)
                Door {{$order->helper->title}}<br />
            @endif
            {{$order->quantity}}&times; {{$order->item->name}}
        @endforeach
    </div>
</div>
@endsection
