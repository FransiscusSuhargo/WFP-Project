@extends('admin.layouts.app')

@section('pageName', 'Insert Food Page')

@section('food', 'active')

@section('content')
    <div class="card mb-3">
        <h5 class="card-header">INSERT FOOD</h5>
        <div class="card-body">
            <form action="{{ route('food.insert') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="exampleFormControlInput1" name="name"
                        placeholder="Enter food name here">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" class="form-control" id="description" rows="3" placeholder="Enter description here"></textarea>

                </div>
                <div class="mb-3">
                    <label for="nutrition" class="form-label">Nutrition Value</label>
                    <textarea name="nutrition" class="form-control" id="nutrition" rows="3" placeholder="Enter nutrition value here"></textarea>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <div class="d-flex align-items-center">
                        <span class="me-2 lh-1">Rp.&nbsp;</span>
                        <input class="form-control" type="number" id="price" placeholder="Enter price here"
                            name="price">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="category" class="form-label">Category</label>
                    <select name="category" id="" class="form-select">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
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
