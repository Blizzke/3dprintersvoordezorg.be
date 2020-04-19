<tr>
    @if(isset($show) && in_array('id', $show))
        <td> {{ $order->id }}</td>
    @endif
    <td>@datetime($order->created_at)</td>
    <td>{{ $order->customer->sector }}</td>
    <td>{{ $order->customer->name }}</td>
    <td>{{ $order->customer->location }}</td>
    <td>{{ $order->quantity }}&times; {{ $order->item->name }}</td>
    @if(isset($show) && in_array('helper', $show))
        <td>{{ $order->helper->display_name }}</td>
    @endif
    @if(isset($show) && in_array('status', $show))
        <td>{{ $order->status }}</td>
    @endif
    <td>
        <button type="button" class="btn btn-default">
          <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
        </button>

        @if($order->is_mine)
            <button type="button" class="btn btn-default">
              <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            </button>
        @endif
    </td>
</tr>

