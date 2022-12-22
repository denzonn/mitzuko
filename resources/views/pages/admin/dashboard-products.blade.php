@extends('layouts.admin')

@section('title')
    Dashboard Product Pages - Store
@endsection

@section('content')
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">My Products</h2>
                <p class="dashboard-subtitle">Manage it well and get money</p>
            </div>
            <div class="dashboard-content">
                <div class="row">
                    <div class="col-12">
                        <a href="dashboard-products-create.html" class="btn btn-success">Add New Product</a>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-6 col-sm-4 col-md-4 col-lg-3">
                        <a href="dashboard-products-details.html" class="card card-dashboard-product d-block">
                            <div class="card-body">
                                <img src="/images/bed-g38528a4bb_1920.jpg" alt=""
                                    class="w-100 mb-2 product-photo" />
                                <div class="product-title">Bed</div>
                                <div class="product-category">Furniture</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
