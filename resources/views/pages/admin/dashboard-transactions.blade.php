@extends('layouts.admin')

@section('title')
    Dashboard Transaction Pages - Store
@endsection

@section('content')
    <!-- Page Content -->
    <div class="section-content section-dashboard-home mb-5" data-aos="fade-up">
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
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item mr-4" role="presentation">
                                    <a class="nav-link active" id="pills-belum-bayar-tab" data-toggle="pill"
                                        href="#pills-belum-bayar" role="tab" aria-controls="pills-belum-bayar"
                                        aria-selected="true">Belum Bayar</a>
                                </li>
                                <li class="nav-item mr-4" role="presentation">
                                    <a class="nav-link " id="pills-dikemas-tab" data-toggle="pill" href="#pills-dikemas"
                                        role="tab" aria-controls="pills-dikemas" aria-selected="false">Dikemas</a>
                                </li>
                                <li class="nav-item mr-4" role="presentation">
                                    <a class="nav-link" id="pills-dikirim-tab" data-toggle="pill" href="#pills-dikirim"
                                        role="tab" aria-controls="pills-dikirim" aria-selected="false">Dikirim</a>
                                </li>
                                <li class="nav-item mr-4" role="presentation">
                                    <a class="nav-link" id="pills-Selesai-tab" data-toggle="pill" href="#pills-Selesai"
                                        role="tab" aria-controls="pills-Selesai" aria-selected="false">Selesai</a>
                                </li>
                                <li class="nav-item  mr-4" role="presentation">
                                    <a class="nav-link" id="pills-batal-tab" data-toggle="pill" href="#pills-batal"
                                        role="tab" aria-controls="pills-batal" aria-selected="false">Batal</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="pills-cod-tab" data-toggle="pill" href="#pills-cod"
                                        role="tab" aria-controls="pills-cod" aria-selected="false">Cod</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-belum-bayar" role="tabpanel"
                                    aria-labelledby="pills-belum-bayar-tab">
                                    @forelse ($pendingTransactions as $transaction)
                                        <div class="card card-list d-block">
                                            <h6 class="text-muted py-3 px-3 m-0 text-right"> <img
                                                    src="/images/shopping-cart.png" style="width: 25px; height: auto">
                                                Silahkan Lakukan Pembayaran
                                            </h6>
                                            <div class="px-3">
                                                <hr class="m-0">
                                            </div>
                                            @forelse ($transaction->transaction_details as $detail)
                                                <a class="d-block" style="text-decoration: none"
                                                    href="{{ route('admin-dashboard-transaction-details', $detail->transaction->id) }}">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-3 col-md-1 pr-1">
                                                                <img src="{{ Storage::url($detail->product->galleries->first()->photos ?? '') }}"
                                                                    alt="" style="width: 70px; height: auto" />
                                                            </div>
                                                            <div class="col-9 col-md-5 " style="line-height: 30px">
                                                                {{ $detail->product->name }}
                                                                {{-- Lakukan perulangan terhadap variant  --}}
                                                                @foreach ($variantData as $item)
                                                                    @if ($item->id == $detail->variant_type_id)
                                                                        <div class="text-muted" style="font-size: 15px">
                                                                            Variant : {{ $item->name }}
                                                                        </div>
                                                                    @endif
                                                                @endforeach
                                                                @if (empty($detail->variant_type_id))
                                                                @endif
                                                            </div>
                                                            <div class="col-3 col-md-2 text-muted ">
                                                                by {{ $transaction->user->name }}
                                                            </div>
                                                            <div class="col-9 col-md-3">
                                                                {{ $transaction->created_at->format('d F Y') }}
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
                                                                {{ number_format($transaction->total, 0, ',', '.') }}
                                                            </div>
                                                        </h6>
                                                    </div>
                                                </div>
                                            </span>
                                        </div>
                                    @empty
                                        <img src="/images/order.png" alt="" class="no-order">
                                    @endforelse
                                </div>
                                <div class="tab-pane fade" id="pills-dikemas" role="tabpanel"
                                    aria-labelledby="pills-dikemas-tab">
                                    @forelse ($successTransactions as $transaction)
                                        <div class="card card-list d-block">
                                            <h6 class="text-muted py-3 px-3 m-0 text-right"> <img
                                                    src="/images/package.png" style="width: 25px; height: auto">
                                                Pesanan Anda Sedang Dikemas</h6>
                                            <div class="px-3">
                                                <hr class="m-0">
                                            </div>
                                            @forelse ($transaction->transaction_details as $detail)
                                                <a class="d-block" style="text-decoration: none"
                                                    href="{{ route('admin-dashboard-transaction-details', $detail->transaction->id) }}">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-3 col-md-1" style="line-height: 30px">
                                                                <img src="{{ Storage::url($detail->product->galleries->first()->photos ?? '') }}"
                                                                    alt="" style="width: 70px; height: auto" />
                                                            </div>
                                                            <div class="col-9 col-md-5 pl-0">
                                                                {{ $detail->product->name }}
                                                                {{-- Lakukan perulangan terhadap variant  --}}
                                                                @foreach ($variantData as $item)
                                                                    @if ($item->id == $detail->variant_type_id)
                                                                        <div class="text-muted" style="font-size: 15px">
                                                                            Variant : {{ $item->name }}
                                                                        </div>
                                                                    @endif
                                                                @endforeach
                                                                @if (empty($detail->variant_type_id))
                                                                @endif
                                                            </div>
                                                            <div class="col-3 col-md-2 text-muted">
                                                                by {{ $transaction->user->name }}
                                                            </div>
                                                            <div class="col-9 col-md-3">
                                                                {{ $transaction->created_at->format('d F Y') }}
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
                                                            <div style="font-size: 22px; color: #ff7158">
                                                                Rp.
                                                                {{ number_format($transaction->total, 0, ',', '.') }}
                                                            </div>
                                                        </h6>
                                                    </div>
                                                </div>
                                            </span>
                                        </div>
                                    @empty
                                        <img src="/images/order.png" alt="" class="no-order">
                                    @endforelse
                                </div>
                                <div class="tab-pane fade" id="pills-dikirim" role="tabpanel"
                                    aria-labelledby="pills-dikirim-tab">
                                    @forelse ($shippingTransactions as $transaction)
                                        <div class="card card-list d-block">
                                            <h6 class="text-muted py-3 px-3 m-0 text-right"> <img
                                                    src="/images/shipping.png" style="width: 25px; height: auto">
                                                Pesanan Anda Sedang Dalam Perjalanan</h6>
                                            <div class="px-3">
                                                <hr class="m-0">
                                            </div>
                                            @forelse ($transaction->transaction_details as $detail)
                                                <a class="d-block" style="text-decoration: none"
                                                    href="{{ route('admin-dashboard-transaction-details', $detail->transaction->id) }}">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-3 col-md-1">
                                                                <img src="{{ Storage::url($detail->product->galleries->first()->photos ?? '') }}"
                                                                    alt="" style="width: 70px; height: auto" />
                                                            </div>
                                                            <div class="col-9 col-md-5 pl-0" style="line-height: 30px">
                                                                {{ $detail->product->name }}
                                                                {{-- Lakukan perulangan terhadap variant  --}}
                                                                @foreach ($variantData as $item)
                                                                    @if ($item->id == $detail->variant_type_id)
                                                                        <div class="text-muted" style="font-size: 15px">
                                                                            Variant : {{ $item->name }}
                                                                        </div>
                                                                    @endif
                                                                @endforeach
                                                                @if (empty($detail->variant_type_id))
                                                                @endif
                                                            </div>
                                                            <div class="col-3 col-md-2 text-muted">
                                                                by {{ $transaction->user->name }}
                                                            </div>
                                                            <div class="col-9 col-md-3">
                                                                {{ $transaction->created_at->format('d F Y') }}
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
                                                            <div style="font-size: 22px; color: #ff7158">
                                                                Rp.
                                                                {{ number_format($transaction->total, 0, ',', '.') }}
                                                            </div>
                                                        </h6>
                                                    </div>
                                                    <div class="col-4 col-lg-4 col-md-4 text-right px-0">
                                                        <a href="{{ route('admin-dashboard-transaction-success', $transaction->id) }}"
                                                            class="btn btn-payment p-2 mb-lg-0 mb-2 confirmBtn">Konfirmasi
                                                            Pesanan
                                                        </a>
                                                        <a type="button" class="btn btn-info p-2">
                                                            Lacak Pesanan
                                                        </a>
                                                    </div>
                                                </div>
                                            </span>
                                        </div>
                                    @empty
                                        <img src="/images/order.png" alt="" class="no-order">
                                    @endforelse
                                </div>
                                <div class="tab-pane fade" id="pills-Selesai" role="tabpanel"
                                    aria-labelledby="pills-Selesai-tab">
                                    @forelse ($doneTransactions as $transaction)
                                        <div class="card card-list d-block">
                                            <h6 class="text-muted py-3 px-3 m-0 text-right"> <img src="/images/done.png"
                                                    style="width: 25px; height: auto">
                                                Terima Kasih Telah Melakukan Pembelian Di Mitzuko</h6>
                                            <div class="px-3">
                                                <hr class="m-0">
                                            </div>
                                            @forelse ($transaction->transaction_details as $detail)
                                                <a class="d-block" style="text-decoration: none"
                                                    href="{{ route('admin-dashboard-transaction-details', $detail->transaction->id) }}">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-3 col-md-1">
                                                                <img src="{{ Storage::url($detail->product->galleries->first()->photos ?? '') }}"
                                                                    alt="" style="width: 70px; height: auto" />
                                                            </div>
                                                            <div class="col-9 col-md-5 pl-0" style="line-height: 30px">
                                                                {{ $detail->product->name }}
                                                                {{-- Lakukan perulangan terhadap variant  --}}
                                                                @foreach ($variantData as $item)
                                                                    @if ($item->id == $detail->variant_type_id)
                                                                        <div class="text-muted" style="font-size: 15px">
                                                                            Variant : {{ $item->name }}
                                                                        </div>
                                                                    @endif
                                                                @endforeach
                                                                @if (empty($detail->variant_type_id))
                                                                @endif
                                                            </div>
                                                            <div class="col-3 col-md-2 text-muted">
                                                                by {{ $transaction->user->name }}
                                                            </div>
                                                            <div class="col-9 col-md-3">
                                                                {{ $transaction->created_at->format('d F Y') }}
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
                                                            <div style="font-size: 22px; color: #ff7158">
                                                                Rp.
                                                                {{ number_format($transaction->total, 0, ',', '.') }}
                                                            </div>
                                                        </h6>
                                                    </div>
                                                </div>
                                            </span>
                                        </div>
                                    @empty
                                        <img src="/images/order.png" alt="" class="no-order">
                                    @endforelse
                                </div>
                                <div class="tab-pane fade" id="pills-batal" role="tabpanel"
                                    aria-labelledby="pills-batal-tab">
                                    @forelse ($cancelTransactions as $transaction)
                                        <div class="card card-list d-block">
                                            <h6 class="text-muted py-3 px-3 m-0 text-right"> <img src="/images/cancel.png"
                                                    style="width: 25px; height: auto">
                                                Pesanan Anda Telah Dibatalkan</h6>
                                            <div class="px-3">
                                                <hr class="m-0">
                                            </div>
                                            @forelse ($transaction->transaction_details as $detail)
                                                <a class="d-block" style="text-decoration: none"
                                                    href="{{ route('admin-dashboard-transaction-details', $detail->transaction->id) }}">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-3 col-md-1">
                                                                <img src="{{ Storage::url($detail->product->galleries->first()->photos ?? '') }}"
                                                                    alt="" style="width: 70px; height: auto" />
                                                            </div>
                                                            <div class="col-9 col-md-5 pl-0" style="line-height: 30px">
                                                                {{ $detail->product->name }}
                                                                {{-- Lakukan perulangan terhadap variant  --}}
                                                                @foreach ($variantData as $item)
                                                                    @if ($item->id == $detail->variant_type_id)
                                                                        <div class="text-muted" style="font-size: 15px">
                                                                            Variant : {{ $item->name }}
                                                                        </div>
                                                                    @endif
                                                                @endforeach
                                                                @if (empty($detail->variant_type_id))
                                                                @endif
                                                            </div>
                                                            <div class="col-3 col-md-2 text-muted">
                                                                by {{ $transaction->user->name }}
                                                            </div>
                                                            <div class="col-9 col-md-3">
                                                                {{ $transaction->created_at->format('d F Y') }}
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
                                                            <div style="font-size: 22px; color: #ff7158">
                                                                Rp.
                                                                {{ number_format($transaction->total, 0, ',', '.') }}
                                                            </div>
                                                        </h6>
                                                    </div>
                                                </div>
                                            </span>
                                        </div>
                                    @empty
                                        <img src="/images/order.png" alt="" class="no-order">
                                    @endforelse
                                </div>

                                <div class="tab-pane fade" id="pills-cod" role="tabpanel"
                                    aria-labelledby="pills-cod-tab">
                                    @forelse ($codTransactions as $transaction)
                                        <div class="card card-list d-block">
                                            <h6 class="text-muted py-3 px-3 m-0 text-right"> <img src="/images/cancel.png"
                                                    style="width: 25px; height: auto">
                                                Pesanan Anda Telah Dibatalkan</h6>
                                            <div class="px-3">
                                                <hr class="m-0">
                                            </div>
                                            @forelse ($transaction->transaction_details as $detail)
                                                <a class="d-block" style="text-decoration: none"
                                                    href="{{ route('admin-dashboard-transaction-details', $detail->transaction->id) }}">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-3 col-md-1">
                                                                <img src="{{ Storage::url($detail->product->galleries->first()->photos ?? '') }}"
                                                                    alt="" style="width: 70px; height: auto" />
                                                            </div>
                                                            <div class="col-9 col-md-5 pl-0" style="line-height: 30px">
                                                                {{ $detail->product->name }}
                                                                {{-- Lakukan perulangan terhadap variant  --}}
                                                                @foreach ($variantData as $item)
                                                                    @if ($item->id == $detail->variant_type_id)
                                                                        <div class="text-muted" style="font-size: 15px">
                                                                            Variant : {{ $item->name }}
                                                                        </div>
                                                                    @endif
                                                                @endforeach
                                                                @if (empty($detail->variant_type_id))
                                                                @endif
                                                            </div>
                                                            <div class="col-3 col-md-2 text-muted">
                                                                by {{ $transaction->user->name }}
                                                            </div>
                                                            <div class="col-9 col-md-3">
                                                                {{ $transaction->created_at->format('d F Y') }}
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
                                                            <div style="font-size: 22px; color: #ff7158">
                                                                Rp.
                                                                {{ number_format($transaction->total, 0, ',', '.') }}
                                                            </div>
                                                        </h6>
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
            </div>
        </div>
    </div>
@endsection

@push('addon-script')
    @if (session()->has('alert'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Data transaksi berhasil diupdate',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @endif

    // Konfirmasi Pesanan Diterima
    <script>
        $(document).on('click', '.confirmBtn', function(e) {

            e.preventDefault();
            var link = $(this).attr('href');

            Swal.fire({
                title: 'Apakah kamu telah menerima pesanan?',
                html: '<span class="text-muted" style="font-size: 14px;">Konfirmasi Pesanan Ketika Pesanan Telah Diterima!</span>',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Pesanan Telah Diterima!'
            }).then((result) => {
                if (result.value) {
                    // Mengambil link dari href
                    window.location.href = link;
                }
            })
        });
    </script>
@endpush
