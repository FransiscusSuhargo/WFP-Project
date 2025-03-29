@extends('admin.layouts.app')

@section('pageName', 'Category Page')

@section('category', 'active')

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
        <h1 class="text-center my-3">Category Master</h1>
        <div class="card-body">
            <div class="d-flex justify-content-end mb-3">
                <a class="btn btn-primary text-white" href="{{ route('category.add') }}">
                    <i class='bx bxs-plus-circle'></i> Insert Data
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <td>ID</td>
                            <td>Name</td>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>{{ $category->name }}</td>
                                <td>
                                    <div class="d-flex gap-5">
                                        <form action="{{ route('category.edit', ['id' => $category->id]) }}" method="get">
                                            @csrf
                                            <button class="btn btn-outline-primary"><i
                                                    class='bx bxs-edit-alt'></i>Edit</button>
                                        </form>
                                        <form action="{{ route('category.delete', ['id' => $category->id]) }}"
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

@endsection
