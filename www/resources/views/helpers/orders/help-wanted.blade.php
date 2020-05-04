@foreach (\App\Order::inProgress()->get() as $order)
    @if($loop->first)
        <h2>Hulp Gevraagd</h2>
        @include('helpers.orders.list.start', ['show' => ['helper', 'status']])
    @endif

    @if($order->help_is_welcome && $user->hasFeature('item:'.$order->item->type))
        @include('helpers.orders.list.row', ['order' => $order, 'loop' => $loop, 'show' => ['helper', 'status']])
    @endif


    @if ($loop->last)
        @include('helpers.orders.list.end')
    @endif
@endforeach
