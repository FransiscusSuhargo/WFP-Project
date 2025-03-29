@extends('admin.layouts.app')

@section('pageName', 'Order Insert Page')
@section('order', 'active')

@section('content')
    <div class="card mb-3">
        <h3 class="card-header text-primary">INSERT ORDER</h3>
        <div class="card-body">
            <form action="{{ route('order.insert') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Customer Name</label>
                    <select name="customer_id" id="name" class="form-select">
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="date" class="form-label">Date</label>
                    <input type="datetime-local" name="date" class="form-control" id="date"
                        placeholder="Enter date here">
                </div>
                <div class="mb-3">
                    <label for="queue" class="form-label">Queue Number</label>
                    <input type="text" name="queueNumber" id="queue" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="type" class="form-label">Type</label>
                    <select name="type" id="type" class="form-select">
                        <option value="Dine-in">Dine-in</option>
                        <option value="Takeaway">Takeaway</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <input type="text" name="status" id="status" class="form-control-plaintext" value="process">
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Payment Method</label>
                    <select name="payment_id" id="" class="form-select">
                        @foreach ($payments as $payment)
                            <option value="{{ $payment->id }}">{{ $payment->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <input type="submit" value="INSERT" class="btn btn-primary w-100">
                </div>
            </form>
        </div>
    </div>
@endsection
