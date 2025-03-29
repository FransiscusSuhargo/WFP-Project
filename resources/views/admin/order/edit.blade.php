@extends('admin.layouts.app')

@section('pageName', 'Order Edit Page')
@section('order', 'active')

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card mb-3">
        <h3 class="card-header text-primary">Edit Order</h3>
        <div class="card-body">
            <form id="edit-food-form" action="{{ route('order.update') }}" method="POST" class="form-control">
                @csrf
                <div class="mb-3">
                    <label for="id" class="form-label">ID</label>
                    <input type="number" class="form-control-plaintext" id="id" name="id"
                        value="{{ $order->id }}" readonly>
                </div>
                <div class="mb-3">
                    <label for="customer" class="form-label">Customer Name</label>
                    <select name="customer_id" id="customer" class="form-select">
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}"
                                {{ $customer->name == $order->customer->name ? 'selected' : '' }}>
                                {{ $customer->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="queue" class="form-label">Queue Number</label>
                    <input name="queue_number" type="text" class="form-control" id="queue"
                        value="{{ $order->queue_number }}" placeholder="Enter Queue Number here">
                </div>
                <div class="mb-3">
                    <label for="date" class="form-label">Date</label>
                    <input type="datetime-local" class="form-control" id="date" name="date"
                        value="{{ $order->date }}" placeholder="Enter Date description">
                </div>
                <div class="mb-3">
                    <label for="type" class="form-label">Type</label>
                    <select name="type" id="type" class="form-select">
                        <option value="Dine-in" {{ $order->type == 'Dine-in' ? 'selected' : '' }}>Dine-in</option>
                        <option value="Takeaway" {{ $order->type == 'Takeaway' ? 'selected' : '' }}>Takeaway</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="ready" {{ $order->status == 'ready' ? 'selected' : '' }}>Ready</option>
                        <option value="process" {{ $order->status == 'process' ? 'selected' : '' }}>Process</option>
                        <option value="finished" {{ $order->status == 'finished' ? 'selected' : '' }}>Finished</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="payment" class="form-label">Payment Method</label>
                    <select name="payment_id" id="payment" class="form-select">
                        @foreach ($payments as $payment)
                            <option value="{{ $payment->id }}"
                                {{ $payment->id == $order->payment->id ? 'selected' : '' }}>
                                {{ $payment->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" id="updateFood" class="btn btn-primary w-100">UPDATE</button>
            </form>
        </div>
    </div>
@endsection
