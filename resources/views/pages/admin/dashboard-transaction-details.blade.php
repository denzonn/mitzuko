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
                <div class="dashboard-title">#{{ $transaction->code }}</div>
                <p class="dashboard-subtitle">Transactions Details</p>
            </div>
            <div class="dashboard-content" id="transactionDetails">
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-md-4">
                                        <img src="{{ Storage::url($transaction->product->galleries->first()->photos ?? '') }}"
                                            alt="" class="w-100 mb-3 product-photo" />
                                    </div>
                                    <div class="col-12 col-md-8">
                                        <div class="row">
                                            <div class="col-6 col-md-6">
                                                <div class="product-title">Customer Name</div>
                                                <div class="product-subtitle">
                                                    {{ $transaction->transaction->user->name }}
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-6">
                                                <div class="product-title">Product Name</div>
                                                <div class="product-subtitle">{{ $transaction->product->name }}</div>
                                            </div>
                                            <div class="col-6 col-md-6">
                                                <div class="product-title">
                                                    Date of Transaction
                                                </div>
                                                <div class="product-subtitle">
                                                    {{ $transaction->created_at }}
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-6">
                                                <div class="product-title">Payment Status</div>
                                                <div class="product-subtitle text-danger">
                                                    {{ $transaction->transaction->transaction_status }}
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-6">
                                                <div class="product-title">Total Amount</div>
                                                <div class="product-subtitle">
                                                    Rp. {{ number_format($transaction->transaction->total, 0, ',', '.') }}
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-6">
                                                <div class="product-title">Mobile</div>
                                                <div class="product-subtitle">
                                                    {{ $transaction->transaction->user->phone_number }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <form action="{{ route('admin-dashboard-transaction-update', $transaction->id) }}"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12 mt-4">
                                            <h5>Shipping Information</h5>
                                        </div>
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-6 col-md-6">
                                                    <div class="product-title">Address I</div>
                                                    <div class="product-subtitle">
                                                        {{ $transaction->transaction->user->address_one }}
                                                    </div>
                                                </div>
                                                <div class="col-6 col-md-6">
                                                    <div class="product-title">Address II</div>
                                                    <div class="product-subtitle">
                                                        {{ $transaction->transaction->user->address_two }}
                                                    </div>
                                                </div>
                                                <div class="col-6 col-md-6">
                                                    <div class="product-title">Province</div>
                                                    <div class="product-subtitle">
                                                        {{ App\Models\Province::find($transaction->transaction->user->provinces_id)->name }}
                                                    </div>
                                                </div>
                                                <div class="col-6 col-md-6">
                                                    <div class="product-title">City</div>
                                                    <div class="product-subtitle">
                                                        {{ App\Models\Regency::find($transaction->transaction->user->regencies_id)->name }}
                                                    </div>
                                                </div>
                                                <div class="col-6 col-md-6">
                                                    <div class="product-title">Postal Code</div>
                                                    <div class="product-subtitle">
                                                        {{ $transaction->transaction->user->zip_code }}
                                                    </div>
                                                </div>
                                                <div class="col-6 col-md-6">
                                                    <div class="product-title">Country</div>
                                                    <div class="product-subtitle">
                                                        {{ $transaction->transaction->user->country }}
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-3">
                                                    <div class="product-title">Status</div>
                                                    <select name="shipping_status" id="status" class="form-control"
                                                        v-model="status">
                                                        <option value="PENDING">PENDING</option>
                                                        <option value="SHIPPING">SHIPPING</option>
                                                        <option value="SUCCESS">SUCCESS</option>
                                                    </select>
                                                </div>
                                                @if ($transaction->shipping_status == 'SUCCESS')
                                                @else
                                                    <template v-if="status == 'SHIPPING'">
                                                        <div class="col-md-3">
                                                            <div class="product-title">Input Resi</div>
                                                            <input type="text" name="resi" class="form-control"
                                                                v-model="resi" />
                                                        </div>
                                                        <div class="col-md-3">
                                                            <button type="submit" class="btn btn-success btn-block mt-4">
                                                                Update Resi
                                                            </button>
                                                        </div>
                                                    </template>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 text-right">
                                            @if ($transaction->shipping_status == 'SUCCESS')
                                                <h3 class="text-success mt-3 mt-md-0 mt-lg-0"><i
                                                        class="fa-sharp fa-solid fa-circle-check"></i>
                                                    <i>Transaction Success</i>
                                                </h3>
                                            @else
                                                <button type="submit" class="btn btn-success btn-lg mt-4">
                                                    Save Now
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
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
@endpush
