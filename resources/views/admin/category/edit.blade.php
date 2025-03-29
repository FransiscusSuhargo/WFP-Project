@extends('admin.layouts.app')
@section('pageName', 'Category Edit Page')
@section('category', 'active')

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
        <h3 class="card-header text-primary">Edit Category</h3>
        <div class="card-body">
            <form action="{{ route('category.update') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="exampleFormControlReadOnlyInputPlain1" class="form-label">ID</label>
                    <input type="text" readonly="" class="form-control-plaintext"
                        id="exampleFormControlReadOnlyInputPlain1" value="{{ $category->id }}" name="id">
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input class="form-control" type="text" id="name" name="name" value="{{ $category->name }}"
                        placeholder="Enter category name here">
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary w-100">UPDATE</button>
                </div>
            </form>
        </div>
    </div>
@endsection
