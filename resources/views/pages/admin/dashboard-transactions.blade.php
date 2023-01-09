@extends('layouts.admin')
@section('title')
    Dashboard Transaction Pages - Store
@endsection

@section('content')
    <!-- Page Content -->
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">Transactions</h2>
                <p class="dashboard-subtitle">
                    Big result start from the small one
                </p>
            </div>
            <div class="dashboard-content">
                <div class="tab-content" id="myTabContent">
                    <div class="row mt-3">
                        <div class="col-12 mt-2">
                            @foreach ($buyTransactions as $transaction)
                                <a class="card card-list d-block"
                                    href="{{ route('admin-dashboard-transaction-details', $transaction->id) }}">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-1">
                                                <img src="{{ Storage::url($transaction->product->galleries->first()->photos ?? '') }}"
                                                    alt="" />
                                            </div>
                                            <div class="col-md-5">
                                                {{ $transaction->product->name }}
                                            </div>
                                            <div class="col-md-2 text-muted">
                                                by {{ $transaction->product->brand }}
                                            </div>
                                            <div class="col-md-3">
                                                {{ $transaction->created_at }}
                                            </div>
                                            <div class="col-md-1 d-none d-md-block">
                                                <img src="/images/angle.png" alt="" />
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
