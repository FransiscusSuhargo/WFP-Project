@extends('employee.layouts.app')
@section('tracking', 'active')
@section('pageName', 'Tracking Page')

@section('style')
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y" style="height: 83dvh;">
        <div class="row h-100">
            <div class="col col-6">
                <div class="card" style="height: 100%;">
                    <div class="card-body overflow-auto">
                        <h5 class="card-title text-warning text-center">Process</h5>
                        <div id="viewProcessContainer">
                            {!! $viewProcess !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col col-6">
                <div class="card" style="height: 100%;">
                    <div class="card-body overflow-auto">
                        <h5 class="card-title text-success text-center">Ready</h5>
                        <div id="viewReadyContainer">
                            {!! $viewReady !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
{{--        <button class="btn btn-primary" id="btnTest">Test</button>--}}
    </div>
@endsection

@section('script')
    <script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
    @vite('resources/js/app.js')
    <script type="module">
        console.log(window.Echo);
        window.Echo.channel('new-order')
            .listen('NewOrderEvent', (e) => {
                console.log(e);
                $.ajax({
                    type: "POST",
                    url: "{{ route('employee.tracking.refresh') }}",
                    data: {
                        '_token': '{{ csrf_token() }}'
                    },
                    success: function (data) {
                        console.log(data);
                        $("#viewProcessContainer").html(data.view_process)
                        $("#viewReadyContainer").html(data.view_ready)
                    },
                    error: function (xhr) {
                        console.log(xhr);
                    }
                })
            });
    </script>
    <script>
        $("#btnTest").click(function () {
            $.ajax({
                type: "POST",
                url: "{{ route('employee.tracking.test') }}",
                data: {
                    '_token': '{{ csrf_token() }}'
                },
                success: function (data) {
                    console.log(data);
                    // $("#viewProcessContainer").html(data.view_process)
                    // $("#viewReadyContainer").html(data.view_ready)
                },
                error: function (xhr) {
                    console.log(xhr);
                }
            })
        })
        {{--// Enable pusher logging - don't include this in production--}}
        {{--Pusher.logToConsole = true;--}}

        {{--var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {--}}
        {{--    cluster: '{{ env('PUSHER_APP_CLUSTER') }}'--}}
        {{--});--}}

        {{--var channel = pusher.subscribe('new_order');--}}
        {{--channel.bind('NewOrderEvent', function(data) {--}}
        {{--    console.log(data);--}}
        {{--    $.ajax({--}}
        {{--        type: "POST",--}}
        {{--        url: "{{ route('employee.tracking.refresh') }}",--}}
        {{--        data: {--}}
        {{--            '_token': '{{ csrf_token() }}'--}}
        {{--        },--}}
        {{--        success: function (data) {--}}
        {{--            console.log(data);--}}
        {{--            $("#viewProcessContainer").html(data.view_process)--}}
        {{--            $("#viewReadyContainer").html(data.view_ready)--}}
        {{--        },--}}
        {{--        error: function (xhr) {--}}
        {{--            console.log(xhr);--}}
        {{--        }--}}
        {{--    })--}}
        {{--    // $("#viewReadyContainer").html(data.)--}}
        {{--});--}}

        {{--console.log($("#viewReadyContainer"))--}}
    </script>
@endsection

