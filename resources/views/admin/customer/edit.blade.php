@extends('admin.layouts.app')
@section('pageName', 'Customer Edit Page')
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
        <h3 class="card-header text-primary">Edit Customer</h3>
        <div class="card-body">
            <form action="{{ route('customer.update') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="id" class="form-label">ID</label>
                    <input type="text" class="form-control-plaintext" id="id" value="{{ $customer->id }}"
                        name="id">
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input class="form-control" type="text" id="name" name="name" value="{{ $customer->name }}"
                        placeholder="Enter category name here">
                </div>
                <div class="mb-3">
                    <label for="user_id" class="form-label">Email</label>
                    <select name="user_id" id="user_id" class="form-select">
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->email }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="start_date">Start Date</label>
                    <input class="form-control" type="date" id="start_date"
                        value="{{ $customer->member_start_date->format('Y-m-d') }}" name="start_date">
                </div>
                <div class="mb-3">
                    <label for="end_date">End Date</label>
                    <input class="form-control" type="date" id="end_date"
                        value="{{ $customer->member_end_date->format('Y-m-d') }}" name="end_date">
                </div>
                <div class="mb-3">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="member" {{ $customer->status == 'member' ? 'selected' : '' }} class="">Member
                        </option>
                        <option value="non member" {{ $customer->status == 'non member' ? 'selected' : '' }}>Non Member
                        </option>
                    </select>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary w-100">UPDATE</button>
                </div>
            </form>
        </div>
    </div>
@endsection
