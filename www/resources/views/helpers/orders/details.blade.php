@section('detailsVariableAssignmentThingy')
  {{ $customer = $order->customer }}
  {{ $item = $order->item }}
  {{ $full_access = ($order->is_mine || is_dispatcher() ) }}
@endsection
@extends('layouts.help')
@section('title', "Bestelling {$order->identifier}")
@section('content')
<h1>@yield('title')</h1>

@if ($order->is_mine)
<h2>Link</h2>
<div class="well">
    <p>De klant kan deze pagina in de toekomst altijd terug bezoeken via deze link:</p>
    <p>{{route('order-customer', ['customer' => $customer->identifier, 'order'=>$order->identifier])}}</p>
    <p>Zijn/haar/hun klantnummer voor volgende bestellingen is {{ $customer->identifier }}.</p>
</div>
@endif

@if ($item->make_info)
<h2>Uitvoering:</h2>
<div class="well">
    <dl class="dl-horizontal">
    @foreach($item->maker_info as $name => $value)
            <dt>{{$name}}</dt><dd>{!! $value !!}</dd>
    @endforeach
    </dl>
</div>
@endif {{-- make info --}}

@foreach($order->statuses as $status)
    @if($loop->first)
        <h2>Verloop bestelling:</h2>
        <div class="well">
            @if(is_dispatcher())
                <dl class="dl-horizontal">
                    <dt>Order #</dt><dd> {{$order->id}} ({{$order->identifier}})</dd>
                    <dt>Customer #</dt><dd> {{$order->customer->id}} ({{$order->customer->identifier}})</dd>
                </dl>
            @endif

            <ul>
                <li>Hoeveelheid afgewerkt/in stock tot nu toe: {{$order->quantity_done}} / {{ $order->quantity }}</li>
    @endif

    @if($status->type === 'status')
        <li><i>Status</i> ging naar <b>{{\App\Order::id_to_status($status->status_id)}}</b> op <b>{{$status->pretty_time}}</b>{{ $status->by ? " ({$status->by})" : '' }}</li>
    @elseif($status->type === 'quantity')
        <li>Er werd(en) <b>{{ $status->quantity }}</b> items afgewerkt op <b>{{$status->pretty_time}}</b> ({{ $status->by ?? 'onbekend' }})</li>
    @elseif($status->type === 'comment')
        <li>Op <b>{{ $status->pretty_time }}</b> zei <b>{{ $status->by ?? 'onbekend' }}</b>:
            <p>
                {!! nl2br($status->comment) !!}
            </p>
        </li>
    @endif

    @if($loop->last)
            </ul>
        </div>
    @endif
@endforeach

@if ($full_access || $order->working_on_it)
    <h2>Commentaar toevoegen:</h2>
    <div class="well">
        <form method="POST" action="{{route('order-comment', ['order'=>$order->identifier])}}">
            @csrf
            <p><textarea name="comment" cols="80" rows="5" placeholder="Commentaar"></textarea><br />
                <input type="checkbox" name="is_internal" value="1"/> Intern (alleen zichtbaar voor makers)</p>
            <div class="form-group">
                <button class="btn btn-success btn-submit">Voeg toe</button>
            </div>
        </form>
    </div>

    <h2>Aantal toevoegen:</h2>
    <div class="well">
        <form method="POST" action="{{route('order-add-quantity', ['order'=>$order->identifier])}}">
            @csrf
            <p><input type="text" name="quantity" size="5" placeholder="#" /> (kan meerdere keren, je kunt hiermee status bijhouden)</p>
            <div class="form-group">
                <button class="btn btn-success btn-submit">Voeg toe</button>
            </div>
        </form>
    </div>

    @if ($full_access)
        <h2>Status aanpassen:</h2>
        <div class="well">
        @switch($order->status_id)
            @case(0)
                <a type="button" class="btn btn-success" href="{{route('order-accept', ['order' => $order->identifier, 'details' => 1])}}">
                    <span class="glyphicon glyphicon-play" aria-hidden="true"></span> Ik ga deze uitvoeren
                </a> (ik ga het order maken of als order-co&ouml;rdinator optreden)
                @break
            @case(1)
                <a type="button" class="btn btn-success" href="{{route('order-status', ['order' => $order->identifier, 'status' => 2])}}">
                    <span class="glyphicon glyphicon-print" aria-hidden="true"></span> Start met productie
                </a>
                @break
            @case(2)
                <a type="button" class="btn btn-success" href="{{route('order-status', ['order' => $order->identifier, 'status' => 3])}}">
                    <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> Afgewerkt, klaar voor leveren/opsturen
                </a>
                @break
            @case(3)
                <a type="button" class="btn btn-success" href="{{route('order-status', ['order' => $order->identifier, 'status' => 4])}}">
                    <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Opgestuurd/geleverd (afgewerkt)
                </a>
                @break
            @case(6)
                <a type="button" class="btn btn-success" href="{{route('order-status', ['order' => $order->identifier, 'status' => 0])}}">
                    <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Opgestuurd/geleverd (afgewerkt)
                </a>
                @break
        @endswitch

        </div>

        <h2>Extra's:</h2>
        <div class="well">
            <form method="POST" action="{{route('order-options', ['order'=>$order->identifier])}}">
                @csrf
                <div class="checkbox">
                  <label>
                    <input type="checkbox" value="1" name="please_help" {{$order->help_is_welcome ? 'checked' : ''}}> Ik kan best wel wat hulp gebruiken (zet uit om het help-icon te verbergen in het overzicht).
                  </label>
                </div>
                <div class="form-group">
                    Materiaal:
                    @foreach (\App\Order::MATERIALS as $value => $name)
                    <label class="radio-inline">
                      <input type="radio" name="material" value="{{$value}}" {{$value==$order->material ? 'checked':''}}> {{$name}}
                    </label>
                    @endforeach
                </div>
        @if ($order->helpers)
            <h3>Helpers</h3>
            <ul>
            <li>{{\App\OrderStatus::contributed($order, $order->helper)}} item(s) door {{$order->helper->display_name}}<br /></li>
            @foreach($order->helpers as $helper)
                <li>{{$helper->contributed}} / {{$helper->quantity}} item(s) door {{$helper->display_name}}<br />
                    {!! nl2br($helper->comment) !!}
                </li>
            @endforeach
            </ul>
        @endif {{-- extra helpers --}}
                <div class="form-group">
                    <button class="btn btn-success btn-submit">Bewaren</button>
                </div>
            </form>
        </div>

        <h2>Aanvrager:</h2>
        <div class="well">
            {{ $customer->name }} ({{ $customer->sector }})<br />
            @if($order->for)
                tav {{$order->for}}<br/>
            @endif
            {{ $customer->street }} {{ $customer->number }}<br />
            {{ $customer->zip }} {{ $customer->city }}, {{ $customer->country }}<br />
            @if($customer->phone) Telefoon: {{$customer->phone}}<br />@endif
            @if($customer->mobile) GSM: {{$customer->mobile}}<br />@endif
            @if($customer->email) E-mail: <a href="mailto:{{$customer->email}}?subject=Je aanvraag bij 3dprintersvoordezorg">{{$customer->email}}</a><br />@endif
            Klant nummer: {{$customer->identifier}}
        </div>
    @endif {{-- full_access --}}
@endif {{-- coordinator or helper --}}

<h2>Inhoud aanvraag:</h2>
<div class="well">
    @if($order->is_new)
        <p>{{ $customer->zip }} {{ $customer->city }}, {{ $customer->country }}</p>
    @endif
    <p>{{ $order->quantity }}&times; {{ $item->name }} (materiaal: {{$order->material_name}}) ({{$item->verbose_price}} per stuk)</p>
@if($order->is_mine)
    @if($item->is_max)
        <p>De vermelde prijs is een maximum prijs. Je kan naar keus minder vragen, maar nooit meer.</p>
    @endif
@endif
</div>

@if (($order->is_new || is_dispatcher()) && $order->customer->has_geo_location)
    <h2>Kaart:</h2>
    <div class="well">
        <div id="map" style="height: 400px"></div>
        @include('orders._map', ['order' => $order])
    </div>
@endif {{-- new order or dispatcher --}}
@endsection
