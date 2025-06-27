@extends('customer.layouts.app')
@section('pageName', 'Cart Page')

@section('content')
    <div class="details col-md-6">
        <form method="POST" action="{{ route('putCart', $food->id) }}">
            @csrf
            @method('PUT')
            <h3 class="product-title">{{ $food->name }} </h3>
            <p><i>{{ $food->category->name }}</i></p>
            <p class="product-description">{{ $food->description }}</p>
            <h4 class="price">current price: <span>{{ $food->price }}</span></h4>
            <p class="vote">{{ $food->nutrition_facts }}</p>
            <p><b>Quantity: </b><input type="number" min=1 value="1" name="quantity"></p>
            <div class="action"> <input class="add-to-cart button default-button" type="submit" value="add to cart">
            </div>
        </form>
    </div>
@endsection