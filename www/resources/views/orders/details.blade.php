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
    <p>Beste,</p>
    @if($order->is_new)
    <p>We hebben je bestelling ontvangen. Intern proberen wij nu de persoon die het dichtste bij woont te vinden die dit voor u kan afhandelen.
        U wordt ook rechtstreeks door deze persoon gecontacteerd voor het afspreken van de exacte kostprijs en hoe het materiaal bij u zal geraken.</p>
    @endif
    <p>Je kan deze pagina in de toekomst altijd terug bezoeken via deze link:
        <a href="{{route('order-customer', ['customer' => $customer->identifier, 'order'=>$order->identifier])}}">
            {{route('order-customer', ['customer' => $customer->identifier, 'order'=>$order->identifier])}}
        </a>
    </p>
@endif

@foreach($order->statuses as $status)
    @if($loop->first)
        Verloop bestelling:
        <ul>
    @endif

    @if($status->type === 'status')
        <li><i>Status</i> ging naar <b>{{\App\Order::id_to_status($status->status_id)}}</b> op <b>{{$status->created_at}}</b>{{ $status->by ? " ({$status->by})" : '' }}</li>
    @elseif($status->type === 'quantity')
        <li>Er werden <b>{{ $status->quantity }}</b> items afgewerkt op <b>{{$status->created_at}}</b> ({{ $status->by ?? 'onbekend' }})</li>
    @elseif($status->type === 'comment')
        <li>Op <b>{{ $status->created_at }}</b> zei <b>{{ $status->by ?? 'onbekend' }}</b>:
            <p>
                {!! $status->comment !!}
            </p>
        </li>
    @endif

    @if($loop->last)
        </ul>
    @endif
@endforeach


@if($write_access)
    <div class="well">
        <form method="POST" action="{{route('order-comment', ['order'=>$order->identifier])}}">
            @csrf
            <textarea name="comment" cols="80" rows="5" placeholder="Commentaar"></textarea>
            <div class="form-group">
                <button class="btn btn-success btn-submit">Voeg toe</button>
            </div>
        </form>
    </div>

    Aanvrager:
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

Inhoud aanvraag:
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
