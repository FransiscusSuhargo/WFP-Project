@extends('admin.layouts.app')

@section('pageName', 'Insert Category Page')

@section('category', 'active')

@section('content')
    <div class="card mb-3">
        <h3 class="card-header text-primary">Insert Category</h3>
        <div class="card-body">
            <form action="{{ route('category.insert') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="exampleFormControlInput1" name="name"
                        placeholder="Enter category name here">
                </div>
                <div class="mb-3">
                    <input type="submit" value="INSERT" class="btn btn-primary w-100">
                </div>
            </form>
        </div>
    </div>
@endsection
