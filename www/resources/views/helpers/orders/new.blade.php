@foreach (\App\Order::new()->get() as $order)
    @if($loop->first)
        <h2>Nieuwe bestellingen</h2>
        @include('helpers.orders.list.start')
    @endif

    @if($user->hasFeature('item:'.$order->item->type))
        @include('helpers.orders.list.row', ['order' => $order, 'show_distance' => true])
    @endif

    @if ($loop->last)
        @include('helpers.orders.list.end')
    @endif
@endforeach
