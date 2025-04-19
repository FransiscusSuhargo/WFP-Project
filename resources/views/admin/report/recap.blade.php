@extends('admin.layouts.app')
@section('pageName', 'Recap Report Page')

@section('report-recap', 'active')
@section('content')
    <div class="card">
        <h1 class="text-center my-3">Monthly Order Recap Report</h1>
        <div class="card-body">
            <div class="row mb-4 text-center">
                <form id="monthYearForm" method="POST" action="{{ route('report.recap') }}" class="mb-4">
                    @csrf
                    <div class="row justify-content-center">
                        <div class="col-md-4">
                            <label for="monthYear" class="form-label">Select Month & Year:</label>
                            <input type="month" name="monthYear" id="monthYear" class="form-control"
                                value="{{ request('monthYear') ?? now()->format('Y-m') }}">
                        </div>
                    </div>
                </form>
            </div>
            <div class="row mb-4 text-center">
                <div class="col-md-6">
                    <h5>Total Revenue</h5>
                    <p><strong>Rp {{ number_format($totalRevenue, 0, ',', '.') }}</strong></p>
                </div>
                <div class="col-md-6">
                    <h5>Total Customers</h5>
                    <p><strong>{{ $totalCustomers }}</strong></p>
                </div>
            </div>
            <h3 class="text-center my-3">Total Order Each Food</h3>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Food Name</th>
                            <th>Total Ordered</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($foodOrders as $order)
                            <tr>
                                <td>{{ $order->food->name }}</td>
                                <td>{{ $order->total_order }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('monthYear').addEventListener('change', function () {
            document.getElementById('monthYearForm').submit();
    });
    </script>
@endsection