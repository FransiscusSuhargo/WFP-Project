@extends('customer.layouts.app')
@section('pageName', 'Cart Page')

@section('content')
    <div class="container-fluid">
        @if (session('status'))
            <div class="alert alert-success" role="alert">{{ session('status') }}</div>
        @endif
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
                        <th>Add On</th>
                        <th>Modifier</th>
                        <th>Note</th>
                        <th>Control</th>
                    </tr>
                </thead>
                @for ($i = 0; $i < count($cart); $i++)
                    @php
                        $addons = $cart[$i]['food']->addons ?? [];
                        $modifiers = $cart[$i]['food']->modifiers ?? [];
                        $maxRows = max(count($addons), count($modifiers), 1);
                    @endphp

                    @for ($r = 0; $r < $maxRows; $r++)
                        <tr>
                            @if ($r === 0)
                                <td rowspan="{{ $maxRows }}">{{ $cart[$i]['food']->name }}</td>
                                <td rowspan="{{ $maxRows }}">{{ $cart[$i]['food']->category->name ?? '-' }}</td>
                                <td rowspan="{{ $maxRows }}">{{ $cart[$i]['food']->description }}</td>
                                <td rowspan="{{ $maxRows }}">{{ $cart[$i]['food']->nutrition_value }}</td>
                                <td rowspan="{{ $maxRows }}">{{ $cart[$i]['food']->price }}</td>
                                <td rowspan="{{ $maxRows }}">{{ $cart[$i]['quantity'] }}</td>
                            @endif

                            {{-- Addon column --}}
                            <td>
                                {{ $addons[$r]->name ?? '' }}
                            </td>

                            {{-- Modifier column --}}
                            <td>
                                {{ $modifiers[$r]->name ?? '' }}
                            </td>
                            @if ($r === 0)
                                <td rowspan="{{ $maxRows }}">{{ $cart[$i]['food']->note ?? '' }}</td>
                            @endif

                            @if ($r === 0)
                                <td rowspan="{{ $maxRows }}">
                                    <a class="btn btn-warning w-100 mb-1"
                                        href="{{ route('detailmenu', $cart[$i]['id']) }}">Lihat</a>

                                    <form method="POST" action="{{ route('show.customize.order', $i) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-light w-100 mb-1">Customize</button>
                                    </form>

                                    <form action="{{ route('deleteCart', $cart[$i]['id']) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger w-100">Batalkan</button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                    @endfor
                @endfor

            </table>
        @else
            <div class="text-center">Belum ada pesanan yang dibuat</div>
        @endif
        @if (count($cart) != 0)
{{--            <form method="POST" action="{{ route('checkout') }}">--}}
{{--                @csrf--}}
{{--                </form>--}}
                <div class="form-group mb-3">
                    <label for="">Dine In/Takeaway</label>
                    <select name="order_type" id="order_type" class="form-select">
                        <option value="Dine-in">Dine-in</option>
                        <option value="Takeaway">Takeaway</option>
                    </select>
                </div>
                <input
                    type="submit"
                    value="Checkout"
                    class="btn btn-success w-100"
                    id="pay-button"
                >
            @endif

    </div>
@endsection

@section('script')
    <script type="text/javascript"
            src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="{{ config('midtrans.client_key') }}"></script>
    <script>
        // const payButton = document.getElementById('pay-button');
        const payButton = $("#pay-button");
        const orderType = $("#order_type").val();
        payButton.on('click', function () {
            $.ajax({
                type: 'POST',
                url: '{{ route('customer.order.checkout') }}',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'order_type': orderType
                },
                success: function (response) {

                    let token = response.snap_token;
                    let orderId = response.order_id;

                    window.snap.pay(token, {
                        onSuccess: function (result) {
                            // Hapus Cart
                            $.ajax({
                                type: 'POST',
                                url: '{{ route('customer.order.checkout.success') }}',
                                data: {
                                    '_token': '{{ csrf_token() }}',
                                },
                                success: function (response) {
                                    console.log(response);
                                    // window.location.href = response.redirect_url;
                                    window.location.replace(response.redirect_url);
                                }
                            })
                        },
                        onPending: function (result) {
                            $.ajax({
                                type: 'POST',
                                url: '{{ route('customer.order.checkout.failed') }}',
                                data: {
                                    '_token': '{{ csrf_token() }}',
                                    'order_id': orderId
                                },
                                success: function (response) {
                                    alert("Order cancelled successfully");
                                }
                            })
                        },
                        onError: function (result) {
                            // alert("Payment failed");
                            // Hapus Order
                            $.ajax({
                                type: 'POST',
                                url: '{{ route('customer.order.checkout.failed') }}',
                                data: {
                                    '_token': '{{ csrf_token() }}',
                                    'order_id': orderId
                                },
                                success: function (response) {
                                    alert("Order cancelled successfully");
                                }
                            })
                        },
                        onClose: function () {
                            // alert("Close");
                            // Hapus Order
                            $.ajax({
                                type: 'POST',
                                url: '{{ route('customer.order.checkout.failed') }}',
                                data: {
                                    '_token': '{{ csrf_token() }}',
                                    'order_id': orderId
                                },
                                success: function (response) {
                                    alert("Order cancelled successfully");
                                }
                            })
                        }
                    })
                },
                error: function (xhr) {
                    console.log(xhr)
                }
            })
        })

    </script>
@endsection
