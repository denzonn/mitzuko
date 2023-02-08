@extends('layouts.app')

@section('title')
    Cart Pages - Store
@endsection

@push('prepend-style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css"
        integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.16/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.16/dist/sweetalert2.min.css">
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
                                    <a href="{{ route('home') }}">Home</a>
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
                                    <th></th>
                                    <th>Image</th>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Menu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($carts as $cart)
                                    <tr>
                                        <td style="width: 5%; line-height:90px" class="text-center">
                                            <input type="checkbox" style="text-size-adjust: 20px" onchange="updateChecked()"
                                                value="{{ $cart->id }}">
                                        </td>
                                        <td style="width: 15%">
                                            @if ($cart->product->galleries)
                                                <img src="{{ Storage::url($cart->product->galleries->first()->photos) }}"
                                                    alt="" class="cart-image" />
                                            @endif
                                        </td>
                                        <td style="width: 45%">
                                            <div class="product-title">{{ $cart->product->name }}</div>
                                            <span class="product-subtitle">
                                                @foreach ($variantData as $item)
                                                    @if ($item->id == $cart->variant_type_id)
                                                        Variant : {{ $item->name }}
                                                    @endif
                                                @endforeach
                                                @if (empty($cart->variant_type_id))
                                                    Variant : -
                                                @endif
                                            </span>
                                        </td>
                                        <td style="width: 15%">
                                            <div class="product-title d-flex">
                                                <button type="button" id="minus" class="btn btn-sm btn-danger"
                                                    data-id="{{ $cart->id }}"><i class="fa fa-minus"
                                                        aria-hidden="true"></i></button>
                                                <div class="mx-3" id="quantities-{{ $cart->id }}">
                                                    {{ $cart->quantity }}
                                                </div>
                                                <button type="button" id="plus" class="btn btn-sm btn-primary"
                                                    data-id="{{ $cart->id }}"><i class="fa fa-plus"
                                                        aria-hidden="true"></i></button>
                                            </div>
                                            <div class="product-subtitle">Quantity</div>
                                        </td>
                                        <td style="width: 15%">
                                            <div class="product-title price">
                                                @foreach ($variantData as $item)
                                                    @if ($item->id == $cart->variant_type_id)
                                                        Rp. {{ number_format($item->price, 0, ',', '.') }}
                                                    @endif
                                                @endforeach
                                                @if (empty($cart->variant_type_id))
                                                    Rp. {{ number_format($cart->product->price, 0, ',', '.') }}
                                                @endif
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
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center p-5">
                                            <img src="/images/order.png" alt="" style="height: 100px; width: auto">
                                        </td>
                                    </tr>
                                @endforelse
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
                <form action="{{ route('checkout') }}" enctype="multipart/form-data" method="get" id="checkout">
                    @csrf
                    <input type="hidden" name="id[]" value="">
                    <input type="hidden" id="total_price" name="total_price" class="total" value="">
                    <!-- Form -->
                    <div class="row mb-2" data-aos="fade-up" data-aos-delay="200">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="address_one">Address 1</label>
                                <input type="text" class="form-control" id="address_one" name="address_one"
                                    value="{{ Auth::user()->address_one }}" placeholder="Address 1" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="address_two">Address 2</label>
                                <input type="text" class="form-control" id="address_two" name="address_two"
                                    value="{{ Auth::user()->address_two }}" placeholder="Address 2" required />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="provinces_id">Province</label>
                                <select name="provinces_id" id="provinces_id" class="form-control"
                                    v-model="provinces_id" v-if="provinces">
                                    <option v-for="province in provinces" :value="province.id">@{{ province.name }}
                                    </option>
                                </select>
                                <select v-else class="form-control"></select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="regencies_id">City</label>
                                <select name="regencies_id" id="regencies_id" class="form-control"
                                    v-model="regencies_id" v-if="regencies">
                                    <option v-for="regency in regencies" :value="regency.id">@{{ regency.name }}
                                    </option>
                                </select>
                                <select v-else class="form-control"></select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="zip_code">Postal</label>
                                <input type="text" class="form-control" id="zip_code" name="zip_code"
                                    placeholder="00000" value="{{ Auth::user()->zip_code }}" />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="country">Country</label>
                                <input type="text" class="form-control" id="country" name="country"
                                    placeholder="Indonesia" value="{{ Auth::user()->country }}" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone_number">Phone Number</label>
                                <input type="number" class="form-control" id="phone_number" name="phone_number"
                                    placeholder="0800000000000" value="{{ Auth::user()->phone_number }}" />
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
                            <div class="product-title totalPrice">Rp. 0</div>
                            <div class="product-subtitle">Product Price</div>
                        </div>
                        <div class="col-4 col-md-3">
                            <div class="product-title">Rp. 0</div>
                            <div class="product-subtitle">Product Discount</div>
                        </div>
                        <div class="col-4 col-md-3">
                            <div class="product-title totalPrice">Rp. 0</div>
                            <div class="product-subtitle">Total</div>
                        </div>
                        <div class="col-12 col-lg-3 col-md-3">
                            <button type="button" id="checkbox" class="btn btn-success mt-3 px-4 btn-block"
                                onclick="checkout()">
                                Checkout Now
                            </button>
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
    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.all.min.js"></script>

    <script>
        function updateChecked() {

            let checkboxes = document.querySelectorAll('input[type="checkbox"]');
            let checkedValues = [];

            for (let i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].checked) {
                    checkedValues.push(checkboxes[i].value);
                }
            }

            let ids = document.querySelector('input[name="id[]"]');
            ids.value = checkedValues;

            $.ajax({
                url: '/cart/pricing',
                type: 'get',
                data: {
                    id: checkedValues,
                },
                success: function(response) {
                    let totalPrice = response.totalPrice;
                    $('.totalPrice').html('Rp. ' + totalPrice.toLocaleString('de-DE', {
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 0
                    }));
                    let total_price = document.getElementById("total_price");
                    total_price.value = totalPrice;
                    console.log(totalPrice);
                },
                error: function(response) {
                    console.log(response);
                }
            });
        }

        function checkout() {
            let checkboxes = document.querySelectorAll('input[type="checkbox"]');
            let checkedValues = [];

            for (let i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].checked) {
                    checkedValues.push(checkboxes[i].value);
                }
            }

            // Cek apakah ada yang dichecklist klau tidak ada maka akan muncul alert
            if (checkedValues.length == 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please select product to checkout!',
                })
            } else {
                // Jika ada submit form
                document.getElementById("checkout").submit();
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Checkout Berhasil! Silahkan Lakukan Pembayaran',
                    icon: 'success',
                });
                setTimeout(() => {}, 3000);
            }
        }
    </script>
    <script>
        var carts = new Vue({
            el: "#carts",
            mounted() {
                AOS.init();
                this.getProvincesData();
                this.getDefaultData();
            },
            data: {
                provinces: null,
                regencies: null,
                provinces_id: null,
                regencies_id: null,
            },
            methods: {
                getDefaultData() {
                    //query ke database untuk mengambil data default 

                    var self = this;
                    axios.get('{{ url('api/default/' . Auth::id()) }}')
                        .then(function(response) {
                            console.log(response.data);
                            self.provinces_id = response.data.provinces.id;
                            self.regencies_id = response.data.regencies.id;
                            console.log(self.regencies_id);
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
                    // this.regencies_id = null;
                    this.getRegenciesData();
                },
            }
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.querySelectorAll("#plus").forEach(function(button) {
            let cart_id = button.getAttribute("data-id");
            button.addEventListener('click', function() {
                $.ajax({
                    type: "get",
                    url: 'api/increment-quantity',
                    data: {
                        cart_id: cart_id,
                    },
                    success: function(data) {
                        document.getElementById(`quantities-${cart_id}`).innerHTML = data
                            .quantity;
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });
        });

        document.querySelectorAll("#minus").forEach(function(button) {
            let cart_id = button.getAttribute("data-id");
            button.addEventListener('click', function() {
                $.ajax({
                    type: "get",
                    url: 'api/decrement-quantity',
                    data: {
                        cart_id: cart_id,
                    },
                    success: function(data) {
                        console.log(data);
                        document.getElementById(`quantities-${cart_id}`).innerHTML = data
                            .quantity;
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });
        });
    </script>
@endpush
