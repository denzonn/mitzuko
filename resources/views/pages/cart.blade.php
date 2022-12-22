@extends('layouts.app')

@section('title')
    Cart Pages - Store
@endsection

@section('content')
    <div class="page-content page-cart">
        <!-- BreadCrumbs -->
        <section class="store-breadcrumbs" data-aos="fade-down" data-aos-delay="100">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="index.html">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Cart</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>

        <!-- Cart -->
        <section class="store-cart">
            <div class="container">
                <!-- Table Cart -->
                <div class="row" data-aos="fade-up" data-aos-delay="100">
                    <div class="col-12 table-responsive">
                        <table class="table table-borderless table-cart">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Menu</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="width: 15%">
                                        <img src="/images/bed-g38528a4bb_1920.jpg" alt="" class="cart-image" />
                                    </td>
                                    <td style="width: 30%">
                                        <div class="product-title">Bed</div>
                                        <div class="product-subtitle">by Wardah</div>
                                    </td>
                                    <td style="width: 15%">
                                        <input type="number" class="quantity" value="1" />
                                    </td>
                                    <td style="width: 25%">
                                        <div class="product-title">Rp. 200.000</div>
                                        <div class="product-subtitle">Rupiah</div>
                                    </td>
                                    <td style="width: 20%">
                                        <a href="#" class="btn btn-remove-cart">Remove</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- HR -->
                <div class="row" data-aos="fade-up" data-aos-delay="150">
                    <div class="col-12">
                        <hr />
                    </div>
                    <div class="col-12">
                        <h2 class="mb-4">Shipping Details</h2>
                    </div>
                </div>
                <!-- Form -->
                <div class="row mb-2" data-aos="fade-up" data-aos-delay="200">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="addressOne">Address 1</label>
                            <input type="text" class="form-control" id="addressOne" name="addressOne" value="Telkomas" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="addressTwo">Address 2</label>
                            <input type="text" class="form-control" id="addressTwo" name="addressTwo" value="Telkomas" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="province">Province</label>
                            <select name="province" id="province" class="form-control">
                                <option value="Jawa">Jawa</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="city">City</label>
                            <select name="city" id="city" class="form-control">
                                <option value="Jawa">Jawa</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="postalCode">Postal</label>
                            <input type="text" class="form-control" id="postalCode" name="postalCode" value="90214" />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="country">Country</label>
                            <input type="text" class="form-control" id="country" name="country" value="90214" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="mobile">Mobile</label>
                            <input type="number" class="form-control" id="mobile" name="mobile" value="90214" />
                        </div>
                    </div>
                </div>
                <!-- HR -->
                <div class="row" data-aos="fade-up" data-aos-delay="150">
                    <div class="col-12">
                        <hr />
                    </div>
                    <div class="col-12">
                        <h2 class="mb-2">Payment Information</h2>
                    </div>
                </div>
                <!-- Payment -->
                <div class="row" data-aos="fade-up" data-aos-delay="200">
                    <div class="col-4 col-md-3">
                        <div class="product-title">Rp. 500.000</div>
                        <div class="product-subtitle">Product Price</div>
                    </div>
                    <div class="col-4 col-md-3">
                        <div class="product-title">Rp. 20.000</div>
                        <div class="product-subtitle">Product Discount</div>
                    </div>
                    <div class="col-4 col-md-3">
                        <div class="product-title text-success">Rp. 480.000</div>
                        <div class="product-subtitle">Total</div>
                    </div>
                    <div class="col-12 col-lg-3 col-md-3">
                        <a href="success.html" class="btn btn-success mt-3 px-4 btn-block">Checkout Now</a>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
