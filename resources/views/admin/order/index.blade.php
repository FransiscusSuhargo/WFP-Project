@extends('admin.layouts.app')

@section('pageName', 'Order Page')
@section('order', 'active')

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
        <h1 class="text-center my-3">Order Master</h1>
        <div class="card-body">
            <div class="d-flex justify-content-end mb-3">
                <a class="btn btn-primary text-white" href="{{ route('order.add') }}">
                    <i class='bx bxs-plus-circle'></i> Insert Data
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Customer Name</th>
                            <th>Payment Method</th>
                            <th>Date</th>
                            <th>Queue Number</th>
                            <th>Type</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->customer->name }}</td>
                                <td>{{ ucwords(str_replace("_", " ", $order->payment_type))}}</td>
                                <td>{{ $order->date }}</td>
                                <td> <span
                                        class="badge bg-label-{{ $order->type == 'Dine-in' ? 'primary' : 'dark' }}">{{ $order->type }}</span>
                                </td>
                                <td> <span
                                        class="badge bg-label-{{ $order->status == 'ready' ? 'success' : ($order->status == 'finished' ? 'warning' : 'danger') }}">{{ $order->status }}</span>
                                </td>
                                <td>
                                    <a href="#getFormUpdateOrder" onclick="getFormOrder({{$order->id}})" class="btn btn-outline-primary" data-bs-toggle="modal"><i
                                                class='bx bxs-edit-alt'></i>Edit</a>
                                    {{-- <form action="{{ route('order.edit', ['id' => $order->id]) }}" method="get">
                                        <button class="btn btn-outline-primary w-100"><i
                                                class='bx bxs-edit-alt'></i>Edit</button>
                                    </form> --}}
                                    <form action="{{ route('order.delete', $order->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger w-100">
                                            <i class='bx bxs-trash'></i> DELETE
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('modals')
    <div class="modal fade" id="getFormUpdateOrder" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Update Order</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body" id="modalUpdateOrderBody">
          </div>
        </div>
      </div>
    </div>
    @endpush

@endsection

@section('script')
<script>
    function getFormOrder(id) {
        const url = "{{ route('order.edit', ['id' => '__id__']) }}".replace('__id__', id);

        $.ajax({
            type: "GET",
            url: url,
            data: {
                '_token' :  '<?php echo csrf_token(); ?>'
            },
            success: function (response) {
                if (response.status === "success") {
                    $("#modalUpdateOrderBody").html(response.msg);
                }

            }
        });

    }
</script>

@endsection
