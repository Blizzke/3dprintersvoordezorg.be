@foreach (\App\Order::new()->with('customer', 'item', 'statuses')->cursor() as $order)
    @if($loop->first)
        <h2>Nieuwe bestellingen</h2>
        @include('helpers.orders.list.start')
    @endif

    @include('helpers.orders.list.row', ['order' => $order, 'loop' => $loop])

    @if ($loop->last)
        @include('helpers.orders.list.end')
    @endif
@endforeach
