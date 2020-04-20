@foreach (\App\Order::inProgress()->with('customer', 'item', 'helper', 'statuses')->cursor() as $order)
    @if($loop->first)
        <h2>Aan de gang</h2>
        @include('helpers.orders.list.start', ['show' => ['helper', 'status']])
    @endif

    @include('helpers.orders.list.row', ['order' => $order, 'loop' => $loop, 'show' => ['helper', 'status']])

    @if ($loop->last)
        @include('helpers.orders.list.end')
    @endif
@endforeach
