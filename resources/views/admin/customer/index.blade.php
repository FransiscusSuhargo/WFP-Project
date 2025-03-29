@extends('admin.layouts.app')
@section('pageName', 'Customer Page')

@section('customer', 'active')

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

    <div class="card">
        <h1 class="text-center my-3">Customer Master</h1>
        <div class="card-body">
            <div class="d-flex justify-content-end mb-3">
                <a class="btn btn-primary text-white" href="{{ route('customer.add') }}">
                    <i class='bx bxs-plus-circle'></i> Insert Data
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <td>ID</td>
                            <td>Name</td>
                            <td>Email</td>
                            <td>Start Date</td>
                            <td>End Date</td>
                            <td>Status</td>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($customers as $customer)
                            <tr>
                                <td>{{ $customer->id }}</td>
                                <td>{{ $customer->name }}</td>
                                <td>{{ $customer->user->email }}</td>
                                <td>{{ $customer->member_start_date }}</td>
                                <td>{{ $customer->member_end_date }}</td>
                                <td>{{ $customer->status }}</td>
                                <td>
                                    <div class="d-flex gap-5">
                                        <form action="{{ route('customer.edit', ['id' => $customer->id]) }}" method="get">
                                            @csrf
                                            <input type="submit" value="Edit" class="btn btn-outline-primary">
                                        </form>
                                        <form action="{{ route('customer.delete', ['id' => $customer->id]) }}"
                                            method="post" onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            @method('DELETE')
                                            <input type="submit" value="DELETE" class="btn btn-danger">
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

@endsection
