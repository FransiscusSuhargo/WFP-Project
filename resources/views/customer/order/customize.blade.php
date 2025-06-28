@extends('customer.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h3 class="mb-3">Customize Food</h3>
                <form action="{{ route('customize.order', $id) }}" method="post">
                    @csrf
                    <div class="mb-3 form-group">
                        <label class="form-label" for="">Food Name</label>
                        <input class="form-control" type="text" value="{{ $food->name }}" id="" readonly>
                    </div>
                    <div class="mb-3 form-group">
                        <label class="form-label" for="">Quantity</label>
                        <input class="form-control" type="number" value="{{ $cart['quantity'] }}" readonly>
                    </div>
                    <div class="mb-3 form-group">
                        <label for="">Add Ons</label>
                        <select class="js-example-basic-multiple" name="addons[]" multiple="multiple" style="width: 100%">
                            @foreach ($addOns as $addon)
                                <option value="{{ $addon->id }}" @if (in_array($addon->id, $cart['addons'] ?? [])) selected @endif>
                                    {{ $addon->name }} (+{{ $addon->price }})
                                </option>
                            @endforeach

                        </select>
                    </div>
                    <div class="mb-3 form-group">
                        <label for="">Modifiers</label>
                        <select class="js-example-basic-multiple" name="modifiers[]" multiple="multiple" style="width:100%">
                            @foreach ($modifiers as $modifier)
                                <option value="{{ $modifier->id }}" @if (in_array($modifier->id, $cart['modifiers'] ?? [])) selected @endif>
                                    {{ $modifier->name }}
                                </option>
                            @endforeach

                        </select>
                    </div>
                    <div class="mb-3 form-group">
                        <label class="form-label" for="">Note</label>
                        <input class="form-control" type="text" name="note"
                            @if (isset($cart['note']) && $cart['note'] != '') value="{{ $cart['note'] }}" @endif>
                    </div>
                    <input type="submit" class="btn btn-success w-100" value="Customize">
                </form>
            </div>

        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });
    </script>
@endsection
