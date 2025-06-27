@extends('customer.layouts.app')
@section('pageName', 'Cart Page')

@section('content')
    @if (session('status'))
        <div class="box success-box">{{ session('status') }}</div>
    @endif
    @if (count($cart) > 0)
        @if (count($cart) > 0)
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th>Nama</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Nutrition Value</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Control</th>
                    </tr>
                </thead>
                @foreach ($cart as $r)
                    <tr>
                        <td>
                            <p>{{ $r['food']->name }}</p>
                        </td>
                        <td>
                            <p>{{ $r['food']->category->name }}</p>
                        </td>
                        <td>
                            <p>{{ $r['food']->description }}</p>
                        </td>
                        <td>
                            <p>{{ $r['food']->nutrition_value }}</p>
                        </td>
                        <td>
                            <p>{{ $r['food']->price }}</p>
                        </td>
                        <td>{{ $r['quantity'] }}</td>
                        <td><a class="btn btn-warning" href="{{ url('/detail/' . $r['id']) }}">Lihat</a>
                            <form action="{{ route('deleteCart', $r['id']) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger">Batalkan</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
        @else
            <div class="box info-box">Belum ada data yang dibuat</div>
        @endif
    @endif
    <form method="POST" action="{{ route('checkout') }}">
        @csrf
        <input type="submit" value="Checkout" class="btn btn-success">
    </form>
@endsection

@section('script')
@endsection
