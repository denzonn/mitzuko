@extends('layouts.dashboard')

@section('title')
    Dashboard Transactions Detail Pages - Store
@endsection

@section('content')
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                @foreach ($transactions as $transaction)
                    <div class="dashboard-title">#{{ $transaction->code }}</div>
                @endforeach
                <p class="dashboard-subtitle">Transactions Details</p>
            </div>
            <div class="dashboard-content" id="transactionDetails">
                <div class="row">
                    <div class="col-12">
                        @forelse ($transactions as $transaction)
                            <div class="card card-list d-block">
                                <a href="{{ route('dashboard-transaction') }}" class="text-muted py-3 px-3 m-0 text-right"
                                    style="text-decoration: none; a:hover {
    cursor: pointer;
}">
                                    <img src="/images/left-arrow.png" alt="" style="width: 15px; height: auto"
                                        class="py-3" /> KEMBALI </a>
                                <div class="px-3">
                                    <hr class="m-0">
                                </div>
                                <div class="card-body" style="background: #f3f3f3">
                                    <h5>Alamat Pengiriman</h5>
                                    <div class="row">
                                        <div class="col-8 col-lg-4 col-md-4">
                                            <div class="col-12 subtitle-dashboard px-0" style="font-size: 15px">
                                                {{ $transaction->user->name }}
                                            </div>
                                            <div class="col-12 text-muted subtitle-dashboard px-0" style="font-size: 15px">
                                                {{ $transaction->user->email }} | {{ $transaction->user->phone_number }}
                                            </div>
                                            <div class="col-12 text-muted subtitle-dashboard px-0" style="font-size: 15px">
                                                Jl. {{ $transaction->user->address_one }},
                                                {{ $transaction->user->address_two }},
                                                {{ $transaction->user->provinces->name }},
                                                {{ $transaction->user->regencies->name }},
                                                {{ $transaction->user->country }},
                                                {{ $transaction->user->zip_code }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="px-3">
                                    <hr class="m-0">
                                </div>
                                @forelse ($transaction->transaction_details as $detail)
                                    <div class="row">
                                        <div class="col-12 col-lg-10 col-md-10">
                                            <a class="d-block" style="text-decoration: none"
                                                href="{{ route('detail', $detail->product->slug) }}">
                                                <div class="card-body">
                                                    <div class="row align-items-center">
                                                        <div class="col-2 col-lg-1 col-md-1">
                                                            <img src="{{ Storage::url($detail->product->galleries->first()->photos ?? '') }}"
                                                                alt="" style="width: 70px; height: auto" />
                                                        </div>
                                                        <div class="col-7 col-lg-9 col-md-9">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="col-12 subtitle-dashboard"
                                                                        style="font-size: 20px">
                                                                        {{ $detail->product->name }}
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <div class="col-12 text-muted subtitle-dashboard"
                                                                        style="font-size: 15px">
                                                                        @foreach ($variantData as $item)
                                                                            @if ($item->id == $detail->variant_type_id)
                                                                                <div class="text-muted"
                                                                                    style="font-size: 15px">
                                                                                    Variant : {{ $item->name }}
                                                                                </div>
                                                                            @endif
                                                                        @endforeach
                                                                        @if (empty($detail->variant_type_id))
                                                                        @endif
                                                                    </div>
                                                                    <div class="col-12  subtitle-dashboard"
                                                                        style="font-size: 15px">
                                                                        Quantity : {{ $detail->quantity }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-3 col-lg-2 col-md-2">
                                                            <div class="col-12 subtitle-dashboard" style="font-size: 20px">
                                                                Rp. {{ number_format($detail->price, 0, ',', '.') }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        @if ($transaction->shipping_status == 'SUCCESS' && $transaction->transaction_status == 'SUCCESS')
                                            @if ($detail->review_status == 0)
                                                <div class="col-12 col-lg-2 col-md-2 d-flex align-items-center">
                                                    <a href="{{ route('dashboard-transaction-review', $detail->id) }}"
                                                        class="btn btn-info p-2 mb-lg-0 mb-2">Review Product
                                                    </a>
                                                </div>
                                            @else
                                                <div class="col-12 col-lg-2 col-md-2 d-flex align-items-center">
                                                    <span style="font-size: 20px">Review </span><img src="/images/done.png"
                                                        alt="" style="height: 25px; width: auto">
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                    <div class="px-3">
                                        <hr class="m-0">
                                    </div>
                                @empty
                                    <img src="/images/order.png" alt="" class="no-order">
                                @endforelse
                                <span>
                                    <div class="d-flex align-items-center p-3 ">
                                        <div class="col-6 px-0">
                                            <h6> Total
                                                Pesanan :
                                                <div style="font-size: 22px; color: #f74d2e">
                                                    Rp.
                                                    {{ number_format($transaction->total, 0, ',', '.') }}
                                                </div>
                                            </h6>
                                        </div>
                                        <div class="col-6 text-right px-0 buttons d-flex justify-content-end">
                                            @if ($transaction->shipping_status == 'PENDING' && $transaction->transaction_status == 'PENDING')
                                                <a type="button" class="btn btn-payment p-2 mb-lg-0 mb-2">Bayar
                                                    Sekarang
                                                </a>
                                            @elseif ($transaction->shipping_status == 'PENDING' && $transaction->transaction_status == 'SUCCESS')

                                            @elseif ($transaction->shipping_status == 'SHIPPING' && $transaction->transaction_status == 'SUCCESS')
                                                <form
                                                    action="{{ route('dashboard-transaction-success', $transaction->id) }}"
                                                    method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    <button type="submit" class="btn btn-payment p-2 mr-1">
                                                        Konfirmasi Paket
                                                    </button>
                                                </form>
                                            @elseif ($transaction->shipping_status == 'SUCCESS' && $transaction->transaction_status == 'SUCCESS')
                                                <a href="{{ route('home') }}" class="btn btn-payment p-2 mb-lg-0 mb-2">Beli
                                                    Lagi
                                                </a>
                                            @endif

                                            @if ($transaction->shipping_status == 'SHIPPING' && $transaction->transaction_status == 'SUCCESS')
                                                <a type="button" class="btn btn-info p-2">Lacak Pesanan
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </span>
                            </div>
                        @empty
                            <img src="/images/order.png" alt="" class="no-order">
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
