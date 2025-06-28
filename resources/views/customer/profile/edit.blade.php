@extends('customer.layouts.app')
@section('pageName', 'Profile Page')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h2 class="text-center">Profile</h2>
                <form action="{{ route('profile.update') }}" method="post">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="" class="form-label">Name</label>
                        <input type="text" class="form-control" value="{{ $profile[0]->name }}" name="name">
                    </div>
                    <div class="form-group mb-3">
                        <label for="" class="form-label">Email</label>
                        <input type="email" class="form-control" value="{{ $profile[0]->user->email }}" name="email">
                    </div>
                    <input type="submit" value="Edit" class="btn btn-primary w-100 mb-3">
                </form>
            </div>
        </div>
    </div>
@endsection
