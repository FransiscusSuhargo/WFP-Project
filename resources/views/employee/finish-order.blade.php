@extends('employee.layouts.app')
@section('finish-order', 'active')
@section('pageName', 'Order Page')

@section('style')
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div id="orderView">
                    {!! $orderView !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).on('click', '.btnFinish', function (e) {
            e.preventDefault();
            $(".btnFinish").prop("disabled", true);

            let orderId = $(this).data('order-id');
            console.log(orderId);

            $.ajax({
                type: "POST",
                url: "{{ route('employee.set-finish') }}", // Replace with your route
                data: {
                    '_token': '{{ csrf_token() }}',
                    'order_id': orderId
                },
                success: function (response) {
                    console.log("Success:", response);
                    $("#orderView").html(response.order_view);
                    // Optionally update UI, remove row, etc.
                },
                error: function (xhr) {
                    console.error("Error:", xhr);
                },
                complete: function () {
                    // Re-enable all buttons after request finishes
                    $(".btnReady").prop("disabled", false);
                }
            });
        })
    </script>
@endsection
