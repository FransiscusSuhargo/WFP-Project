@extends('customer.layouts.app')
@section('pageName', 'Dashboard Page')

@section('content')
    <section>
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">

                    <div class="bootstrap-tabs product-tabs">
                        <div class="tabs-header d-flex justify-content-between border-bottom my-5">
                            <h3>Trending Products</h3>
                        </div>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-all" role="tabpanel"
                                aria-labelledby="nav-all-tab">
                                <div
                                    class="product-grid row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">

                                    @foreach ($foods as $food)
                                        <div class="col">
                                            <div class="product-item">
                                                {{-- <span class="badge bg-success position-absolute m-3">-30%</span> --}}
                                                <a href="#" class="btn-wishlist"><svg width="24" height="24">
                                                        <use xlink:href="#heart"></use>
                                                    </svg></a>
                                                <figure>
                                                    <a href="index.html" title="Product Title">
                                                        <img src="images/thumb-bananas.png" class="tab-image">
                                                    </a>
                                                </figure>
                                                <h3>{{ $food->name }}</h3>
                                                {{-- <span class="qty">1 Unit</span><span class="rating"><svg width="24"
                                                        height="24" class="text-primary">
                                                        <use xlink:href="#star-solid"></use>
                                                    </svg> 4.5</span> --}}
                                                <span >{{ $food->description }}</span>
                                                <span >{{ $food->nutrition_value }}</span>
                                                <span class="price">{{ $food->price }}</span>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="input-group product-qty">
                                                        <span class="input-group-btn">
                                                            <button type="button"
                                                                class="quantity-left-minus btn btn-danger btn-number"
                                                                data-type="minus">
                                                                <svg width="16" height="16">
                                                                    <use xlink:href="#minus"></use>
                                                                </svg>
                                                            </button>
                                                        </span>
                                                        <input type="text" id="quantity" name="quantity"
                                                            class="form-control input-number" value="1">
                                                        <span class="input-group-btn">
                                                            <button type="button"
                                                                class="quantity-right-plus btn btn-success btn-number"
                                                                data-type="plus">
                                                                <svg width="16" height="16">
                                                                    <use xlink:href="#plus"></use>
                                                                </svg>
                                                            </button>
                                                        </span>
                                                    </div>
                                                    <a href="#" class="nav-link">Add to Cart <iconify-icon
                                                            icon="uil:shopping-cart"></a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <!-- / product-grid -->

                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
@endsection
