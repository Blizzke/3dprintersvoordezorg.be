@section('detailsVariableAssignmentThingy')
  {{ $customer = $order->customer }}
  {{ $item = $order->item }}
  {{ $write_access = ((is_helper() && $order->is_mine) || is_customer()) }}
@endsection
@extends('layouts.help')
@section('title', "Bestelling {$order->identifier}")
@section('content')
<h1>@yield('title')</h1>

@if(is_customer())
    @if($order->is_new)
    <p>We hebben je bestelling goed ontvangen. Intern proberen wij nu de persoon die het dichtste bij woont te vinden die dit voor u kan afhandelen.
        U wordt ook rechtstreeks door deze persoon gecontacteerd voor het afspreken van de exacte kostprijs en hoe het materiaal bij u zal geraken.</p>
    @endif
    <h2>Link</h2>
    <div class="well">
        <p>Je kan deze pagina in de toekomst altijd terug bezoeken via deze link:
            <a href="{{route('order-customer', ['customer' => $customer->identifier, 'order'=>$order->identifier])}}">
                {{route('order-customer', ['customer' => $customer->identifier, 'order'=>$order->identifier])}}
            </a>
        </p>
    </div>
@endif

@foreach($order->statuses as $status)
    @if($loop->first)
        <h2>Verloop bestelling:</h2>
        <div class="well">

            <ul>
                <li>Hoeveelheid afgewerkt/in stock tot nu toe: {{$order->quantity_done}} / {{ $order->quantity }}</li>
    @endif

    @if($status->type === 'status')
        <li><i>Status</i> ging naar <b>{{\App\Order::id_to_status($status->status_id)}}</b> op <b>{{$status->pretty_time}}</b>{{ $status->by ? " ({$status->by})" : '' }}</li>
    @elseif($status->type === 'quantity')
        <li>Er werd(en) <b>{{ $status->quantity }}</b> items afgewerkt op <b>{{$status->pretty_time}}</b> ({{ $status->by ?? 'onbekend' }})</li>
    @elseif($status->type === 'comment')
        @if(is_helper() or !$status->is_internal)
            <li>Op <b>{{ $status->pretty_time }}</b> zei <b>{{ $status->by ?? 'onbekend' }}</b>:
                <p>
                    {!! $status->comment !!}
                </p>
            </li>
        @endif
    @endif

    @if($loop->last)
            </ul>
        </div>
    @endif
@endforeach


@if($write_access)
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

    @if(is_helper())
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

        <h2>Status aanpassen:</h2>
        <p>
        @switch($order->status_id)
            @case(1)
                <a type="button" class="btn btn-success" href="{{route('order-status', ['order' => $order->identifier, 'status' => 2])}}">
                    <span class="glyphicon glyphicon-print" aria-hidden="true"></span> Start met bestelling
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
        @endswitch
        </p>
    @endif

    <h2>Aanvrager:</h2>
    <div class="well">
        {{ $customer->name }} ({{ $customer->sector }})<br />
        @if($customer->for)
            tav {{$customer->for}}<br/>
        @endif
        {{ $customer->street }} {{ $customer->number }}<br />
        {{ $customer->zip }} {{ $customer->city }}, {{ $customer->country }}<br />
        @if($customer->phone) Telefoon: {{$customer->phone}}<br />@endif
        @if($customer->mobile) GSM: {{$customer->mobile}}<br />@endif
        @if($customer->email) E-mail: <a href="mailto:{{$customer->email}}?subject=Je aanvraag bij 3dprintersvoordezorg">{{$customer->email}}</a><br />@endif
    </div>

@endif

<h2>Inhoud aanvraag:</h2>
<div class="well">
    <p>{{ $order->quantity }}&times; {{ $item->name }} ({{$item->verbose_price}} per stuk)</p>
@if(is_helper())
    @if($order->is_mine)
        <p>De vermelde prijzen zijn de maximum prijzen indien dit expliciet vermeld staat, je kan naar keus minder vragen ook. Tenzij anders vermeld zijn de prijzen inclusief BTW.</p>
    @endif
@elseif($item->is_max)
    <p>De bovenvermeldde prijs is de maximum prijs (exclusief verzending indien nodig) die hiervoor betaald zal moeten worden.<br />
        Deze prijs bestaat alleen uit de nodige materiaalkost en wordt ook weer ge&iuml;nvesteerd in nieuw materiaal om nog meer mensen te kunnen helpen.
    </p>
@endif
</div>


@endsection
