@section('detailVariableAssignmentThingy')
    {{ $customer = $order->customer }}
    {{ $item = $order->item }}
@endsection
@if($order->is_mine)

    <p>Je hebt deze bestelling aanvaard. Zorg ervoor dat je eerst contact neemt met de besteller om een prijs af te spreken
        en de nodige praktische details te overlopen/overeen te komen. Begin zeker niet eerder aan een bestelling!</p>

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
        @if($customer->email) E-mail: {{$customer->email}}<br />@endif
    </div>
@endif

Inhoud aanvraag:
<div class="well">
    <p>{{ $order->quantity }}&times; {{ $item->name }} ({{$item->verbose_price}} per stuk)</p>
    <p>De vermeldde prijzen zijn de maximum prijzen indien dit expliciet vermeld staat.
        Dat wil zeggen dat het je eigen keuze is of je deze prijs wilt vragen of minder.
        Tenzij anders vermeld zijn de prijzen inclusief BTW.</p>
</div>

@foreach($order->statuses as $status)
    @if($loop->first)
        Overzicht:
        <ul>
    @endif

    @if($status->type === 'status')
        <li>Status ging naar <b>{{\App\Order::id_to_status($status->status_id)}}</b> op <b>{{$status->created_at}}</b> ({{ $status->helper->name }})</li>
    @elseif($status->type === 'quantity')
        <li>Er werden <b>{{ $status->quantity }}</b> items afgewerkt op <b>{{$status->created_at}}</b> ({{ $status->helper->name }})</li>
    @endif

    @if($loop->last)
        </ul>
    @endif
@endforeach
