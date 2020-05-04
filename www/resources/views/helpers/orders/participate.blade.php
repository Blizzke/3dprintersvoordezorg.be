@section('detailsVariableAssignmentThingy')
  {{ $customer = $order->customer }}
  {{ $item = $order->item }}
  {{ $full_access = ($order->is_mine || is_dispatcher() ) }}
@endsection
@extends('layouts.help')
@section('title', "Bestelling {$order->identifier} - Meehelpen")
@section('content')
<h1>@yield('title')</h1>

<h2>Co&ouml;rdinator:</h2>
<div class="well">
    {{ $order->helper->display_name }} (discord: {{$order->helper->chat_name ?? 'onbekend'}})<br />
    {{ $order->helper->location }}<br/>
</div>

<h2>Bestelling:</h2>
<div class="well">
    <p>{{ $customer->name }} ({{ $customer->sector }})<br />
    {{ $customer->zip }} {{ $customer->city }}, {{ $customer->country }}</p>
    <p>{{ $order->quantity }}&times; {{ $item->name }} ({{$item->verbose_price}} per stuk)</p>
</div>

<div class="well">
    <form method="POST" action="{{route('order-help', ['order'=>$order->identifier])}}">
        <p>Als je kunt/wilt helpen aan een bestelling, plaats hieronder dan je "offerte", hoeveel je kunt
        produceren en wat je vraagprijs zou zijn hiervoor. Alleen de order-co&ouml;rdinator ziet deze informatie.
            Vermeld liefst ook of je wel of niet opstuurt/brengt of wilt dat het opgehaald wordt.
            Een standaard <2kg verzending naar adres kost 5.7€ bij bpost, heb je natuurlijk altijd
            de kans dat het pak verdwijnt in hun warenhuis wegens te weinig capaciteit.</p>
        <p>Neem best ook even contact met de co&ouml;rdinator via discord om te zien of het &uuml;berhaupt wel nodig is en of
            je vraagprijs ok is voor hem/haar</p>
        @csrf
        <div class="form-group">
            <label for="quantity">Aantal dat ik kan maken:</label>
            <input id="quantity" name="quantity" type="text"
                   class="form-control @error('quantity') is-invalid @enderror"
                   value=""/>
            @error('quantity')<div class="alert alert-danger">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label class="control-label" for="comment">Prijsopgaaf/verzendkost/commentaar:</label>
            <textarea id="comment" name="comment" rows="5" class="form-control @error('comment') is-invalid @enderror" placeholder="Voorstel"></textarea>
            @error('comment')<div class="alert alert-danger">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <button class="btn btn-success btn-submit form-control">Help aanbieden</button>
        </div>
    </form>
</div>
@endsection
