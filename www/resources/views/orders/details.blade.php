@section('detailsVariableAssignmentThingy')
  {{ $customer = $order->customer }}
  {{ $item = $order->item }}
  {{ $write_access = ((is_helper() && $order->is_mine) || is_customer()) }}
@endsection
@extends('layouts.request')
@section('title', "Bestelling {$order->identifier}")
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

<div class="site-section bg-light">
    <div class="container">

        @if($order->is_new)
        <p>We hebben je bestelling goed ontvangen. Intern proberen wij nu de persoon die het dichtste bij je woont te vinden.
            Deze persoon zal de bestelling op zich nemen en je rechtstreeks contacteren voor het afspreken van de kostprijs en hoe het materiaal bij u zal geraken.</p>
        <p>Pas op dat moment zal er aan de bestelling begonnen worden.</p>
        @endif

        <h2>Link</h2>
        <div class="well">
            <p>Je kan deze pagina in de toekomst altijd terug bezoeken via deze link:</p>
            <p>
                <a href="{{route('order-customer', ['customer' => $customer->identifier, 'order'=>$order->identifier])}}">
                    {{route('order-customer', ['customer' => $customer->identifier, 'order'=>$order->identifier])}}
                </a>
            </p>
            <p>Je klantnummer voor volgende bestellingen is {{ $customer->identifier }}.</p>
        </div>

        <h2>Verloop bestelling:</h2>
        <div class="well">
        @foreach($order->statuses as $status)
            @if($loop->first)
                <ul>
                    <li>Hoeveelheid afgewerkt/in stock tot nu toe: {{$order->quantity_done}} / {{ $order->quantity }}</li>
            @endif

            @if($status->type === 'status')
                <li><i>Status</i> ging naar <b>{{\App\Order::id_to_status($status->status_id)}}</b> op <b>{{$status->pretty_time}}</b>{{ $status->by ? " ({$status->by})" : '' }}</li>
            @elseif($status->type === 'quantity')
                <li>Er werd(en) <b>{{ $status->quantity }}</b> items afgewerkt op <b>{{$status->pretty_time}}</b> ({{ $status->by ?? 'onbekend' }})</li>
            @elseif($status->type === 'comment' && !$status->is_internal)
                <li>Op <b>{{ $status->pretty_time }}</b> zei <b>{{ $status->by ?? 'onbekend' }}</b>:
                    <p>
                        {!! $status->comment !!}
                    </p>
                </li>
            @endif

            @if($loop->last)
                </ul>
            @endif
        @endforeach
            <h3>Commentaar toevoegen:</h3>
            <form method="POST" action="{{route('order-comment', ['order'=>$order->identifier])}}">
                @csrf
                <p><textarea name="comment" cols="80" rows="5" placeholder="Commentaar"></textarea><br /></p>
                <div class="form-group">
                    <button class="btn btn-success btn-submit">Voeg toe</button>
                </div>
            </form>
        </div>

        @if (!$order->is_new)
            <h2>Je maker:</h2>
            <div class="well">
                <div id="map" style="height: 400px"></div>
                @include('orders._map', ['order' => $order])
            </div>
        @endif

        <h2>Inhoud aanvraag:</h2>
        <div class="well">
            <p>{{ $order->quantity }}&times; {{ $item->name }} ({{$item->verbose_price}} per stuk)</p>
        @if($item->is_max)
            <p>De bovenvermeldde prijs is de maximum prijs (exclusief verzending indien nodig) die hiervoor betaald zal moeten worden.<br />
                Deze prijs bestaat alleen uit de nodige materiaalkost en wordt ook weer ge&iuml;nvesteerd in nieuw materiaal om nog meer mensen te kunnen helpen.
            </p>
        @endif
        </div>

        <h2>Jouw gegevens:</h2>
        <div class="well">
            {{ $customer->name }} ({{ $customer->sector }})<br />
            @if($order->for)
                tav {{$order->for}}<br/>
            @endif
            {{ $customer->street }} {{ $customer->number }}<br />
            {{ $customer->zip }} {{ $customer->city }}, {{ $customer->country }}<br />
            @if($customer->phone) Telefoon: {{$customer->phone}}<br />@endif
            @if($customer->mobile) GSM: {{$customer->mobile}}<br />@endif
            @if($customer->email) E-mail:{{$customer->email}}<br />@endif
            Klant nummer: {{$customer->identifier}}
        </div>
    </div>
</div>

@endsection
