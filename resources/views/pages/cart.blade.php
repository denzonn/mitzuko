@extends('layouts.app')

@section('title')
    Cart Pages - Store
@endsection

@push('prepend-style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css"
        integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

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
        <section class="store-cart " id="carts">
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
                                @php
                                    $totalPrice = 0;
                                @endphp
                                @foreach ($carts as $cart)
                                    <tr>
                                        <td style="width: 15%">
                                            @if ($cart->product->galleries)
                                                <img src="{{ Storage::url($cart->product->galleries->first()->photos) }}"
                                                    alt="" class="cart-image" />
                                            @endif
                                        </td>
                                        <td style="width: 30%">
                                            <div class="product-title">{{ $cart->product->name }}</div>
                                            <div class="product-subtitle">by {{ $cart->product->brand }}</div>
                                        </td>
                                        <td style="width: 20%">
                                            <div class="product-title d-flex ">
                                                <button type="button" @click="GetMin({{ $cart->id }})"
                                                    class="btn btn-sm btn-danger"><i class="fa fa-minus"
                                                        aria-hidden="true"></i></button>
                                                <div class="mx-3">
                                                    {{ $cart->quantity }}
                                                </div>
                                                <button type="button" @click="GetPlush({{ $cart->id }})"
                                                    class="btn btn-sm btn-primary"><i class="fa fa-plus"
                                                        aria-hidden="true"></i></button>
                                            </div>
                                            <div class="product-subtitle">Quantity</div>
                                        </td>
                                        <td style="width: 25%">
                                            <div class="product-title">Rp.
                                                {{ number_format($cart->product->price, 0, ',', '.') }}
                                            </div>
                                            <div class="product-subtitle">Rupiah</div>
                                        </td>
                                        <td style="width: 20%">
                                            <form action="{{ route('cart-delete', $cart->id) }}" method="post">
                                                @method('delete')
                                                @csrf
                                                <button type="submit" class="btn btn-remove-cart">Remove</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @php
                                        $totalPrice += $cart->product->price * $cart->quantity;
                                    @endphp
                                @endforeach
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
                <form action="">
                    <!-- Form -->
                    <div class="row mb-2" data-aos="fade-up" data-aos-delay="200">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="address_one">Address 1</label>
                                <input type="text" class="form-control" id="address_one" name="address_one"
                                    placeholder="Address" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="address_two">Address 2</label>
                                <input type="text" class="form-control" id="address_two" name="address_two"
                                    placeholder="Address" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="provinces_id">Province</label>
                                <select name="provinces_id" id="provinces_id" class="form-control" v-if="provinces"
                                    v-model="provinces_id">
                                    <option v-for="province in provinces" :value="province.id">@{{ province.name }}
                                    </option>
                                </select>
                                <select v-else class="form-control"></select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="regencies_id">City</label>
                                <select name="regencies_id" id="regencies_id" class="form-control" v-if="regencies"
                                    v-model="regencies_id">
                                    <option value="PROVINSI" v-for="regency in regencies" :value="regency.id">
                                        @{{ regency.name }}
                                    </option>
                                </select>
                                <select v-else class="form-control"></select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="zip_code">Postal</label>
                                <input type="text" class="form-control" id="zip_code" name="zip_code"
                                    placeholder="00000" />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="country">Country</label>
                                <input type="text" class="form-control" id="country" name="country"
                                    placeholder="Indonesia" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone_number">Phone Number</label>
                                <input type="number" class="form-control" id="phone_number" name="phone_number"
                                    placeholder="0800000000000" />
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
                            <div class="product-title">Rp. {{ number_format($totalPrice ?? 0, 0, ',', '.') }}</div>
                            <div class="product-subtitle">Product Price</div>
                        </div>
                        <div class="col-4 col-md-3">
                            <div class="product-title">Rp. 20.000</div>
                            <div class="product-subtitle">Product Discount</div>
                        </div>
                        <div class="col-4 col-md-3">
                            <div class="product-title text-success">Rp. {{ number_format($totalPrice ?? 0, 0, ',', '.') }}
                            </div>
                            <div class="product-subtitle">Total</div>
                        </div>
                        <div class="col-12 col-lg-3 col-md-3">
                            <a href="success.html" class="btn btn-success mt-3 px-4 btn-block">Checkout Now</a>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection


@push('addon-script')
    <script src="/vendor/vue/vue.js"></script>
    <script src="https://unpkg.com/vue-toasted"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

    <script>
        var carts = new Vue({
            el: "#carts",
            mounted() {
                AOS.init();
                this.getProvincesData();
            },
            data: {
                provinces: null,
                regencies: null,
                provinces_id: null,
                regencies_id: null,
            },
            methods: {
                GetPlush(id) {
                    var element = document.querySelector("#carts" + id);
                    axios.post("{{ route('api-cart-increment') }}", {
                            cart_id: id,
                        })
                        .then((response) => {
                            window.location.reload();
                        })
                },
                GetMin(id) {
                    axios.post("{{ route('api-cart-decrement') }}", {
                            cart_id: id,
                        })
                        .then((response) => {
                            window.location.reload();
                        })
                },
                getProvincesData() {
                    var self = this;
                    axios.get('{{ route('api-provinces') }}')
                        .then(function(response) {
                            self.provinces = response.data;
                        })
                },
                getRegenciesData() {
                    var self = this;
                    axios.get('{{ url('api/regencies') }}/' + self.provinces_id)
                        .then(function(response) {
                            self.regencies = response.data;
                        })
                },

            },
            watch: {
                provinces_id: function(val, oldVal) {
                    this.regencies_id = null;
                    this.getRegenciesData();
                }
            }
        });
    </script>
@endpush
