@extends('layouts.admin')

@section('title')
    Dashboard Transactions Detail Pages - Store
@endsection

@push('addon-style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@section('content')
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <div class="dashboard-title">
                    # @foreach ($transactions as $transaction)
                        {{ $transaction->code }}
                    @endforeach
                </div>
                <p class="dashboard-subtitle">Transactions Details</p>
            </div>
            <div class="dashboard-content" id="transactionDetails">
                <div class="row">
                    <div class="col-12">
                        @forelse ($transactions as $transaction)
                            <div class="card card-list d-block">
                                <a href="{{ route('admin-dashboard-transactions') }}"
                                    class="text-muted py-3 px-3 m-0 text-right"
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
                                    <a class="d-block" style="text-decoration: none"
                                        href="{{ route('detail', $detail->product->slug) }}">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col-2 col-lg-1 col-md-1">
                                                    <img src="{{ Storage::url($detail->product->galleries->first()->photos ?? '') }}"
                                                        alt="" style="width: 70px; height: auto" />
                                                </div>
                                                <div class="col-7 col-lg-8 col-md-8">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="col-12 subtitle-dashboard" style="font-size: 20px">
                                                                {{ $detail->product->name }}
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="col-12 text-muted subtitle-dashboard"
                                                                style="font-size: 15px">
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
                                                            <div class="col-12  subtitle-dashboard" style="font-size: 15px">
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
                                    <div class="row mb-lg-2">
                                        <div class="col-12 mb-2">
                                            <form
                                                action="{{ route('admin-dashboard-transaction-update', $transaction->id) }}"
                                                method="POST" enctype="multipart/form-data" id="mainForm"
                                                onsubmit="return false;">
                                                @csrf
                                                @if ($transaction->shipping_status == 'PENDING' && $transaction->transaction_status == 'SUCCESS')
                                                    <div class="row">
                                                        <div class="col-12 d-lg-flex">
                                                            <div class="col-12 col-lg-3 col-md-3">
                                                                <div class="product-title">Shipping Status</div>
                                                                <select name="shipping_status" id="status"
                                                                    class="form-control" v-model="status">
                                                                    <option value="PENDING">PENDING</option>
                                                                    <option value="SHIPPING">SHIPPING</option>
                                                                </select>
                                                            </div>
                                                            <template v-if="status == 'SHIPPING'">
                                                                <div class="col-12 col-lg-3 col-md-3">
                                                                    <div class="product-title">Input Resi</div>
                                                                    <input type="text" class="form-control"
                                                                        name="resi" v-model="resi" />
                                                                </div>
                                                                <div class="col-12 col-lg-2 col-md-2 ">
                                                                    <button type="submit" onclick="updateResi()"
                                                                        class="btn btn-success btn-block mt-4">
                                                                        Update Resi
                                                                    </button>
                                                                </div>
                                                            </template>
                                                        </div>
                                                    </div>
                                                @endif
                                            </form>
                                        </div>
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

@push('addon-script')
    <script src="/vendor/vue/vue.js"></script>
    <script>
        var transactionDetails = new Vue({
            el: "#transactionDetails",
            data: {
                status: "{{ $transaction->shipping_status }}",
                resi: "{{ $transaction->resi }}",
            },
        });
    </script>
    <script>
        // Function for showing SweetAlert on update resi button
        function updateResi() {
            Swal.fire({
                title: 'Update Resi',
                text: 'Are you sure want to update the shipping tracking number?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, update it!'
            }).then((result) => {
                if (result.value) {
                    // Submit the form if user confirms
                    document.getElementById('mainForm').submit();
                    // Redirect to transaction page after 2 seconds
                    setTimeout(function() {
                        window.location.href = "{{ route('admin-dashboard-transactions') }}";
                    }, 2000);
                }
            })
        }

        // Function for showing SweetAlert on save now button
        function saveNow() {
            Swal.fire({
                title: 'Save Changes',
                text: 'Are you sure want to save the changes?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, save it!'
            }).then((result) => {
                if (result.value) {
                    // Submit the form if user confirms
                    document.getElementById('mainForm').submit();
                }
            })
        }
    </script>
@endpush
