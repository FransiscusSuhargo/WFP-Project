@extends('customer.layouts.app')
@section('pageName', 'Order Page')

@section('content')
    <div class="container-fluid">
        @if (session('status'))
            <div class="alert alert-success" role="alert">{{ session('status') }}</div>
        @endif
        @if (count($orders) > 0)
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th>Order Id</th>
                        <th>Date</th>
                        <th>Queue Number</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Payment</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->created_at->diffForHumans() }}</td>
                            <td>{{ $order->queue_number }}</td>
                            <td>{{ $order->type }}</td>
                            <td>{{ ucfirst($order->status) }}</td>
                            <td>{{ ucwords(str_replace("_", " ", $order->payment_type)) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="text-center">Belum ada pesanan yang diproses</div>
        @endif
    </div>
@endsection

@section('script')
@endsection
