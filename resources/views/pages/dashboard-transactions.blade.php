@extends('layouts.dashboard')

@section('title')
    Dashboard Transactions Pages - Store
@endsection

@section('content')
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <div class="dashboard-title">#STORE0839</div>
                <p class="dashboard-subtitle">Transactions Details</p>
            </div>
            <div class="dashboard-content" id="transactionDetails">
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-md-4">
                                        <img src="/images/bed-g38528a4bb_1920.jpg" alt=""
                                            class="w-100 mb-3 product-photo" />
                                    </div>
                                    <div class="col-12 col-md-8">
                                        <div class="row">
                                            <div class="col-6 col-md-6">
                                                <div class="product-title">Customer Name</div>
                                                <div class="product-subtitle">
                                                    Denson Patibang
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-6">
                                                <div class="product-title">Product Name</div>
                                                <div class="product-subtitle">Bed Cover</div>
                                            </div>
                                            <div class="col-6 col-md-6">
                                                <div class="product-title">
                                                    Date of Transaction
                                                </div>
                                                <div class="product-subtitle">
                                                    6 Januari, 2020
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-6">
                                                <div class="product-title">Payment Status</div>
                                                <div class="product-subtitle text-danger">
                                                    Pending
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-6">
                                                <div class="product-title">Total Amount</div>
                                                <div class="product-subtitle">
                                                    6 Januari, 2020
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-6">
                                                <div class="product-title">Mobile</div>
                                                <div class="product-subtitle">Pending</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 mt-4">
                                        <h5>Shipping Information</h5>
                                    </div>
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-6 col-md-6">
                                                <div class="product-title">Address I</div>
                                                <div class="product-subtitle">
                                                    Denson Patibang
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-6">
                                                <div class="product-title">Address II</div>
                                                <div class="product-subtitle">
                                                    Denson Patibang
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-6">
                                                <div class="product-title">Province</div>
                                                <div class="product-subtitle">
                                                    Denson Patibang
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-6">
                                                <div class="product-title">City</div>
                                                <div class="product-subtitle">
                                                    Denson Patibang
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-6">
                                                <div class="product-title">Postal Code</div>
                                                <div class="product-subtitle">
                                                    Denson Patibang
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-6">
                                                <div class="product-title">Country</div>
                                                <div class="product-subtitle">
                                                    Denson Patibang
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-3">
                                                <div class="product-title">Shipping Status</div>
                                                <div class="product-subtitle">SHIPPING</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
