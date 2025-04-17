@extends('admin.layouts.app')
@section('pageName', 'Date Report Page')

@section('report-date', 'active')
@section('content')
    <div class="card">
        <h1 class="text-center my-3">Date with Most Order Report</h1>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Order Date</th>
                            <th>Total Order</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d M Y') }}</td>
                                <td>{{ $order->order_count }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection