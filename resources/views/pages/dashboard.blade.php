@extends('layouts.dashboard')

@section('title')
    Dashboard Pages - Store
@endsection

@section('content')
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <div class="dashboard-title">Dashboard</div>
                <p class="dashboard-subtitle">Look what you made today!</p>
            </div>
            <div class="dashboard-content">
                <div class="row mt-3">
                    <div class="col-12 mt-2">
                        <h5 class="mb-3">Recent Transaction</h5>
                        <a href="dashboard-transaction-details.html" class="card card-list d-block">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-1 col-sm-2 col-xs-2">
                                        <img src="/images/bedroom-g31559bc87_1280.jpg" alt="" />
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-4">
                                        Bed Cover
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-3">Denson</div>
                                    <div class="col-md-3 col-sm-3 col-xs-3">
                                        12 Januari, 2020
                                    </div>
                                    <div class="col-md-1 d-none d-md-block">
                                        <img src="/images/angle.png" alt="" />
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
