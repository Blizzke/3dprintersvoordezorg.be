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
                            <h2 class="heading mb-5">Bestellingen @yield('title')</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="alert alert-warning" role="alert" style="margin-top: 20px;">
                    <h4 class="alert-heading">Opgelet</h4>
                    <hr>
                    <p class="mb-0">
                        Orders die bestaan uit verschillende items worden steeds opgesplitst in meerdere orders.<br>
                        We doen dit omdat niet al onze helpers alle items kunnen leveren.
                        Het zou dus kunnen dat je voor een order met verschillende items wordt gecontacteerd door verschillende helpers.
                        Een overzicht kan je hieronder vinden.
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach($customer->orders as $order)
                <div class="col-12 col-sm-12 col-md-6 col-lg-4 .col-xl-3">
                    <div class="card" style="margin-bottom: 20px;">
                        <div class="card-header">
                            Bestelling {{$order->identifier}}
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">
                                {{$order->quantity}}&times; {{$order->item->name}}
                            </h5>
                            <h6 class="card-subtitle mb-2 text-muted" style="margin-top: 10px;">
                                <span class="fas
                                @switch($order->status_id)
                                @case(0)
                                    fa-asterisk
                                @break
                                @case(1)
                                    fa-tag
                                @break
                                @case(2)
                                    fa-print
                                @break
                                @case(3)
                                    fa-envelope
                                @break
                                @case(4)
                                    fa-clipboard-check
                                @break
                                @case(5)
                                    fa-times-circle
                                @break
                                @endswitch
                                    " aria-hidden="true" data-toggle="tooltip" data-placement="bottom"
                                      title=" {{$order->status}}"></span> {{$order->status}}
                            </h6>

                            <p class="card-text">
                                @if(!$order->is_new)
                                    Verwerkt door: <br>{{$order->helper->title}}<br/>
                                @else
                                    <br>
                                    <br>
                                @endif
                            </p>
                            <a href="{{route('order-customer', ['customer' => $customer->identifier, 'order'=> $order->identifier])}}"
                               class="card-link">Bestelling bekijken</a>
                        </div>
                    </div>
                </div>
        @endforeach
        </div>
    </div>
@endsection
