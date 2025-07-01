<table class="table table-striped overflow-auto">
    <thead class="table-dark">
    <tr>
        <th style="color: white; text-align: center;">Queue Number</th>
        <th style="color: white; text-align: center;">Status</th>
        <th style="color: white; text-align: center;">Type</th>
        <th style="color: white; text-align: center;">Payment</th>
        <th style="color: white; text-align: center;">Order Date</th>
        <th style="color: white; text-align: center;">Action</th>
    </tr>
    </thead>
    <tbody>
    @foreach($orders as $order)
        <tr>
            <td style="text-align: center;">{{ $order->queue_number }}</td>
            <td style="text-align: center;">{{ $order->status }}</td>
            <td style="text-align: center;">{{ $order->type }}</td>
            <td style="text-align: center;">{{ $order->payment_type }}</td>
            <td style="text-align: center;">{{ $order->created_at->diffForHumans() }}</td>
            <td style="text-align: center;">
                <a href="{{ route('employee.order', ['order_id' => $order->id]) }}" class="btn btn-secondary">Detail</a>
                @if($order->status == 'process')
                    <button type="button" class="btn btn-warning btnReady" data-order-id="{{ $order->id }}">Set to Ready</button>
                @else
                    <button type="button" class="btn btn-danger btnFinish" data-order-id="{{ $order->id }}">Set to Finish</button>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<div class="mt-4">
    {{ $orders->onEachSide(1)->withQueryString()->links('pagination::bootstrap-5') }}
</div>
