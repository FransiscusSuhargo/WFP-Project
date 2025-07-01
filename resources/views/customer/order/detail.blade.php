@extends('customer.layouts.app')
@section('pageName', 'Payment Page')

@section('content')
    <div class="container-fluid">
        @if (session('status'))
            <div class="alert alert-success" role="alert">{{ session('status') }}</div>
        @endif

    </div>
@endsection

@section('script')
@endsection
