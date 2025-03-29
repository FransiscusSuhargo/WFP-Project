@extends('admin.layouts.app')

@section('food', 'active')

@section('pageName', 'Edit Food')

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
        <h3 class="card-header text-primary">Edit Food</h3>
        <div class="card-body">
            <form id="edit-food-form" action="{{ route('food.update') }}" method="POST" class="form-control">
                @csrf
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">ID</label>
                    <input type="number" class="form-control-plaintext" id="exampleFormControlInput1" name="id"
                        value="{{ $food->id }}" readonly>
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Name</label>
                    <input name="name" type="text" class="form-control" id="exampleFormControlInput1"
                        value="{{ $food->name }}" placeholder="Enter food name">
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Description</label>
                    <input type="text" class="form-control" id="exampleFormControlInput1" name="description"
                        value="{{ $food->description }}" placeholder="Enter food description">
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Nutrition Value</label>
                    <textarea name="nutrition" type="text" class="form-control" id="exampleFormControlInput1"
                        placeholder="Enter food Nutrition">{{ $food->nutrition_value }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Price</label>
                    <input type="number" class="form-control" name="price" id="exampleFormControlInput1"
                        placeholder="Enter food Price" value="{{ $food->price }}"></input>
                </div>
                <div class="mb-3">
                    <label for="defaultSelect" class="form-label">Category</label>
                    <select id="category" class="form-select">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" id="updateFood" class="btn btn-primary w-100">UPDATE</button>
            </form>
        </div>
    </div>
@endsection
