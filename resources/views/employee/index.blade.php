@extends('employee.layouts.app')
@section('order', 'active')
@section('pageName', 'Order Page')

@section('style')
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
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
                                    <button class="btn btn-warning">Set to Ready</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $orders->onEachSide(1)->withQueryString()->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection
