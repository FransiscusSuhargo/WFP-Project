@extends('admin.layouts.app')
@section('pageName', 'Customer Page')

@section('customer', 'active')

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
        <h1 class="text-center my-3">Customer Master</h1>
        <div class="card-body">
            <div class="d-flex justify-content-end mb-3">
                <a class="btn btn-primary text-white" href="{{ route('customer.add') }}">
                    <i class='bx bxs-plus-circle'></i> Insert Data
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <td>ID</td>
                            <td>Name</td>
                            <td>Email</td>
                            <td>Start Date</td>
                            <td>End Date</td>
                            <td>Status</td>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($customers as $customer)
                            <tr>
                                <td>{{ $customer->id }}</td>
                                <td>{{ $customer->name }}</td>
                                <td>{{ $customer->user->email }}</td>
                                <td>{{ $customer->member_start_date }}</td>
                                <td>{{ $customer->member_end_date }}</td>
                                <td><span
                                        class="badge bg-label-{{ $customer->status == 'member' ? 'success' : 'danger' }}">{{ $customer->status }}</span>
                                </td>
                                <td>
                                    <div class="d-flex gap-5">
                                        <a href="#getFormUpdateCustomer" class="btn btn-outline-primary" data-bs-toggle="modal" onclick="getCustomerForm({{$customer->id}})"><i class='bx bxs-edit-alt'></i>Edit</a>

                                        {{-- <a class="btn btn-outline-primary" href="#getFormUpdateCustomer" onclick="getCustomerForm({{$customer->id}})"><i --}}
                                                    {{-- class='bx bxs-edit-alt'></i>Edit</a> --}}
                                        {{-- <form action="{{ route('customer.edit', ['id' => $customer->id]) }}"
                                            method="get">
                                            @csrf
                                            <button class="btn btn-outline-primary"><i
                                                    class='bx bxs-edit-alt'></i>Edit</button>
                                        </form> --}}
                                        <form action="{{ route('customer.delete', ['id' => $customer->id]) }}"
                                            method="post" onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-outline-danger">
                                                <i class='bx bxs-trash'></i> DELETE
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('modals')
    <div class="modal fade" id="getFormUpdateCustomer" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Update Customer</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body" id="modalUpdateCustomerBody">
          </div>
        </div>
      </div>
    </div>
    @endpush
@endsection

@section('script')
    <script>
        function getCustomerForm(id) {
            const url = "{{ route('customer.edit', ['id' => '__id__']) }}".replace('__id__', id);
            $.ajax({
                type: "GET",
                url: url,
                data: {
                    '_token' :  '<?php echo csrf_token(); ?>'
                },
                success: function (response) {
                    if (response.status === "success") {
                        $("#modalUpdateCustomerBody").html(response.msg);
                    }
                }
            });            
        }
    </script>
    
@endsection
