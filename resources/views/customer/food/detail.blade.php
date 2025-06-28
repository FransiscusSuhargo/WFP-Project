@extends('customer.layouts.app')
@section('pageName', 'Cart Page')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="details">
                    <form method="POST" action="{{ route('putCart', $food->id) }}">
                        @csrf
                        @method('PUT')
                        <h3 class="product-title">{{ $food->name }} </h3>
                        <p><i>{{ $food->category->name }}</i></p>
                        <p class="product-description">{{ $food->description }}</p>
                        <div class="form-group mb-3">
                            <label for="">Current Price</label>
                            <input type="number" class="form-control" value="{{ $food->price }}">
                        </div>
                        <p class="vote">{{ $food->nutrition_facts }}</p>
                        <div class="form-group mb-3">
                            <label class="form-label" for="">Quantity</label>
                            <input class="form-control" type="number" min=1 value="1" name="quantity">
                        </div>
                        <div class="action">
                            <input class="btn btn-primary w-100" type="submit" value="Add to Cart">
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </div>

@endsection
