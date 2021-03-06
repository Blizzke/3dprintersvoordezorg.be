@foreach (\App\Order::inProgress()->get() as $order)
    @if($loop->first)
        <h2>Aan de gang</h2>
        @include('helpers.orders.list.start', ['show' => ['helper', 'status']])
    @endif

    @include('helpers.orders.list.row', ['order' => $order, 'loop' => $loop, 'show' => ['helper', 'status'], 'readonly' => !is_dispatcher()])

    @if ($loop->last)
        @include('helpers.orders.list.end')
    @endif
@endforeach
