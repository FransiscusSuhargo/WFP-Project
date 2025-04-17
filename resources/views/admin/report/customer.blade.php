@extends('admin.layouts.app')
@section('pageName', 'Customer Report Page')

@section('report-customer', 'active')
@section('content')
    <div class="card">
        <h1 class="text-center my-3">Most Order Customer Report</h1>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>User Id</th>
                            <th>Status</th>
                            <th>Total Order</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($customers as $customer)
                            <tr>
                                <td>{{ $customer->id }}</td>
                                <td>{{ $customer->name }}</td>
                                <td>{{ $customer->user_id }}</td>
                                <td>{{ $customer->status }}</td>
                                <td>{{ $customer->orders_count }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection