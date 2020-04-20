<tr @if($loop->odd) class="active" @endif>
    @section('rowVariableAssignmentThingy')
      {{ $status = "{$order->status}" . ($order->helper ? " ({$order->helper->display_name})" : "") }}
      {{ $order_id = "order-{$order->identifier}" }}
    @endsection
    @if(isset($show) && in_array('id', $show))
        <td> {{ $order->id }}</td>
    @endif
    <td>@datetime($order->created_at)</td>
    <td>{{ $order->customer->sector }}</td>
    <td>{{ $order->customer->name }}</td>
    <td>{{ $order->customer->location }}</td>
    <td>{{ $order->quantity }}&times; {{ $order->item->name }}</td>
    @if(isset($show) && in_array('status', $show))
        <td>
            @switch($order->status_id)
                @case(0)
                    <span class="glyphicon glyphicon-asterik" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="{{$status}}"></span>
                    @break
                @case(1)
                    <span class="glyphicon glyphicon-tag" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="{{ $status }}"></span>
                    @break
                @case(2)
                    <span class="glyphicon glyphicon-print" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="{{ $status }}"></span>
                    @break
                @case(3)
                    <span class="glyphicon glyphicon-envelope" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="{{ $status }}"></span>
                    @break
                @case(4)
                    <span class="glyphicon glyphicon-ok" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="{{ $status }}"></span>
                    @break
                @case(5)
                    <span class="glyphicon glyphicon-remove" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="{{ $status }}"></span>
                    @break
            @endswitch
        </td>
    @endif
    <td>
        <button type="button" class="btn btn-default" data-toggle="collapse" data-target="#{{$order_id}}">
          <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
        </button>

        @if($order->is_mine /*and $order->is_in_production*/)
            <a type="button" class="btn btn-default" data-confirm="1" data-toggle="tooltip" data-placement="bottom" title="Vrijgeven" href="{{route('order-release', ['order' => $order->identifier])}}">
              <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
            </a>
        @endif

        @if($order->is_in_production)
            <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="bottom" title="Werk bijdragen">
              <span class="glyphicon glyphicon-inbox" aria-hidden="true"></span>
            </button>
        @endif

        @if($order->is_new)
            <a type="button" class="btn btn-default" data-toggle="tooltip" data-confirm="1" data-placement="bottom" title="Bestelling accepteren" href="{{route('order-accept', ['order' => $order->identifier])}}">
              <span class="glyphicon glyphicon-play" aria-hidden="true"></span>
            </a>

        @endif

        @if($order->can_cancel)
            <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="bottom" title="Annuleren (afsluiten)">
              <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
            </button>
        @endif
    </td>
</tr>
<tr class="collapse @if($loop->odd) active @endif" id="{{ $order_id }}">
    <td colspan="6">
        @include('helpers.orders.detail', ['order' => $order])
    </td>
</tr>
