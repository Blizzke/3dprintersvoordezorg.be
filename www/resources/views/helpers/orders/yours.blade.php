@foreach (\App\Order::yours()->get() as $order)
    @if($loop->first)
        <h2>Jouw bestellingen</h2>
        @include('helpers.orders.list.start', ['show' => ['status']])
    @endif

    @include('helpers.orders.list.row', ['order' => $order, 'loop' => $loop, 'show' => ['status']])

    @if ($loop->last)
        @include('helpers.orders.list.end')
    @endif
@endforeach
