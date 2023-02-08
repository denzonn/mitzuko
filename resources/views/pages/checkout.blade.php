@extends('layouts.dashboard')

@section('title')
    Payment Page
@endsection

@section('content')
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">Payment</h2>
                <p class="dashboard-subtitle">
                    Big result start from the small one
                </p>
            </div>
            <div class="dashboard-content">
                <div class="tab-content" id="myTabContent">
                    <div class="row mt-3">
                        <div class="col-12 mt-2">
                            <div class="card card-list d-block">
                                <h6 class="text-muted py-3 px-3 m-0 text-right"> <img src="/images/shopping-cart.png"
                                        style="width: 25px; height: auto">
                                    Silahkan Lakukan Pembayaran
                                </h6>
                                <div class="px-3">
                                    <hr class="m-0">
                                </div>
                                @forelse ($transactions->transaction_details as $detail)
                                    <a class="d-block" style="text-decoration: none"
                                        href="{{ route('dashboard-transaction-details', $detail->transaction->id) }}">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-3 col-md-1">
                                                    <img src="{{ Storage::url($detail->product->galleries->first()->photos ?? '') }}"
                                                        alt="" />
                                                </div>
                                                <div class="col-9 col-md-5">
                                                    {{ $detail->product->name }}
                                                </div>
                                                <div class="col-3 col-md-2 text-muted">
                                                    by {{ $detail->product->brand }}
                                                </div>
                                                <div class="col-9 col-md-3">
                                                    {{ $transactions->created_at->format('d F Y') }}
                                                </div>
                                                <div class="col-md-1 d-none d-md-block">
                                                    <img src="/images/angle.png" alt="" />
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="px-3">
                                        <hr class="m-0">
                                    </div>
                                @empty
                                    <img src="/images/order.png" alt="" class="no-order">
                                @endforelse
                                <span>
                                    <div class="d-flex align-items-center p-3 ">
                                        <div class="col-8 col-lg-8 col-md-8 px-0">
                                            <h6> Total
                                                Pesanan :
                                                <div style="font-size: 22px; color: #f74d2e">
                                                    Rp.
                                                    {{ number_format($transactions->total, 0, ',', '.') }}
                                                </div>
                                            </h6>
                                        </div>
                                        <div class="col-4 col-lg-4 col-md-4 text-right px-0">
                                            <button class="btn btn-payment p-2 mb-lg-0 mb-2" id="pay-button">
                                                Bayar
                                                Sekarang
                                            </button>
                                        </div>
                                    </div>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('addon-script')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-E7jDP62VSg3Hgl4Y"></script>
    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function() {
            // SnapToken acquired from previous step
            snap.pay('{{ $snapToken }}', {
                // Optional
                onSuccess: function(result) {

                },
                // Optional
                onPending: function(result) {
                    /* You may add your own js here, this is just example */
                    document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                },
                // Optional
                onError: function(result) {
                    /* You may add your own js here, this is just example */
                    document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                }
            });
        };
    </script>
@endpush
