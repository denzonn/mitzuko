@extends('layouts.app')

@section('title')
    Detail Pages - Store
@endsection

@push('addon-style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"
        integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css"
        integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        .stars input[type='radio'] {
            display: none;
        }

        .stars label {
            display: block;
            float: left;
            margin: 0;
            padding: 0 2px;
        }

        .stars label::before {
            content: '\f005';
            font-family: FontAwesome;
            font-size: 15px;
            /*color: #e6e6e6;*/
            color: #efce4a;
        }

        .stars input[type='radio']:checked~label::before {
            color: #e6e6e6;
        }

        .stars:hover label::before {
            color: #efce4a !important;
        }

        .stars label:hover~label::before {
            color: #e6e6e6 !important;
        }
    </style>
@endpush

@section('content')
    <div class="page-content page-details">
        <!-- BreadCrumbs -->
        <section class="store-breadcrumbs" data-aos="fade-down" data-aos-delay="100">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="index.html" style="text-decoration: none">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Product Details</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>

        <!-- Gallery -->
        <section class="store-gallery mb-3" id="gallery">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8" data-aos="zoom-in">
                        <transition name="slide-fade" mode="out-in">
                            <img :src="photos[activePhoto].url" :key="photos[activePhoto].id" class="main-image"
                                alt="" />
                        </transition>
                    </div>
                    <div class="col-lg-2">
                        <div class="row pl-2 pr-2">
                            <div class="col-3 col-lg-12 mt-2 mt-lg-0 mr-0 thumbnail" v-for="(photo, index) in photos"
                                :key="photo.id" data-aos="zoom-in" data-aos-delay="100">
                                <a href="#" @click="changeActive(index)">
                                    <img :src="photo.url" alt="" class="w-100 thumbnail-image"
                                        :class="{ active: index == activePhoto }" />
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Description -->
        <div class="store-details-container" data-aos="fade-up">
            <!-- Heading -->
            <section class="store-heading">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8">
                            <h1>{{ $product->name }}</h1>
                            <div class="brand">By {{ $product->brand }}</div>
                            @if ($variant->count() > 0)
                                <span class="text-muted">Variant :
                                    @foreach ($variant as $item)
                                        @if ($item->stock == 0)
                                            <button type="button" class="btn btn-variant ml-3" style="cursor: no-drop"
                                                disabled>
                                                {{ $item->name }}
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-variant ml-3"
                                                onclick="updatePrice({{ $item->price }}, {{ $item->id }}, {{ $item->stock }})">
                                                {{ $item->name }}
                                            </button>
                                        @endif
                                    @endforeach
                                    <div class="price mt-3" id="price">
                                        Rp. {{ number_format($variant->min('price'), 0, ',', '.') }} -
                                        Rp. {{ number_format($variant->max('price'), 0, ',', '.') }}
                                    </div>
                                </span>
                            @else
                                <div class="price mt-3">Rp. {{ number_format($product->price, 0, ',', '.') }}
                                </div>
                            @endif
                        </div>
                        <div class="col-lg-2" data-aos="zoom-in">
                            @auth
                                <form action="{{ route('detail-add', $product->id) }}" method="POST"
                                    enctype="multipart/form-data" id="add-cart">
                                    @csrf
                                    @if ($product->stock > 0)
                                        <input type="hidden" name="variant_id" id="variant_id">
                                        @if ($variant->count() > 0)
                                            @if ($variant->count() > 0)
                                                <div class="stock" id="stock">tersedia {{ $variant->sum('stock') }} pcs
                                                </div>
                                            @endif
                                        @else
                                            <div class="stock">tersedia {{ $product->stock }} pcs</div>
                                        @endif
                                        <button type="submit" class="btn btn-success px-4 text-white btn-block mb-3">
                                            Add to Cart
                                        </button>
                                    @else
                                        <button type="submit" class="btn btn-warning px-4 text-white btn-block mb-3" disabled>
                                            Add to Cart
                                        </button>
                                    @endif
                                </form>
                                <span class="wishlist-heart-group">
                                    {{-- Kondisi agar ketika di refresh tidak hilang --}}
                                    @php
                                        $count = 0;
                                    @endphp
                                    @if (Auth::check())
                                        @php
                                            $count = App\Models\Wishlist::countWishlist($product->id);
                                        @endphp
                                    @endif
                                    <input class="wishlist" name="product-333" id="product-333" data-product-id="333"
                                        type="checkbox" data-id="{{ $product->id }}"
                                        @if ($count > 0) checked @endif>
                                    <label for="product-333" data-hover-text="Wish List">
                                        <svg xmlns:dc="http://purl.org/dc/elements/1.1/"
                                            xmlns:cc="http://creativecommons.org/ns#"
                                            xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
                                            xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg"
                                            xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd"
                                            xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape" version="1.1"
                                            x="0px" y="0px" viewBox="0 0 100 100">
                                            <g transform="translate(0,-952.36218)">
                                                <path style="color:#000000;enable-background:accumulate;"
                                                    d="m 34.166665,972.36218 c -11.41955,0 -19.16666,8.91891 -19.16666,20.27029 0,19.45943 15,27.56753 35,39.72973 20.00001,-12.1622 34.99999,-20.2703 34.99999,-39.72973 0,-11.35137 -7.7471,-20.27029 -19.16665,-20.27029 -7.35014,0 -13.39148,4.05405 -15.83334,6.48647 -2.44185,-2.43241 -8.48319,-6.48647 -15.83334,-6.48647 z"
                                                    fill="transparent" id="heart-path" stroke="#737373" stroke-width="5"
                                                    marker="none" visibility="visible" display="inline"
                                                    overflow="visible" />
                                            </g>
                                        </svg>
                                    </label>
                                </span>
                                <span>Add to Wishlist</span>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-success px-4 text-white btn-block mb-3">
                                    Sign In to Add
                                </a>
                            @endauth
                            {!! $share !!}
                        </div>
                    </div>
                </div>
            </section>

            <!-- Desc -->
            <section class="store-description">
                <div class="container">
                    <div class="row ">
                        <div class="col-12 col-lg-8 mt-3">
                            <h5>Deskripsi Produk</h5>
                            <p>
                                {!! $product->description !!}
                            </p>
                        </div>
                        <div class="col-lg-4 d-lg-inline d-md-none d-sm-none">
                            <!-- Product sidebar Widget -->
                            <div class="sidebar-widget">
                                <div class="widget-header">
                                    <h5 class="widget-title">New Products</h5>
                                    <hr>
                                </div>
                                <div class="widget-body">
                                    @foreach ($newProduct as $item)
                                        <a href="{{ route('detail', $item->slug) }}">
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <img src="{{ Storage::url($item->galleries->first()->photos ?? '') }}"
                                                        alt="">
                                                </div>
                                                <div class="col-lg-9">
                                                    <h5>{{ \Illuminate\Support\Str::limit($item->name ?? '', 23, ' ...') }}
                                                    </h5>
                                                    <p class="price mb-0">Rp.
                                                        {{ number_format($item->price, 0, ',', '.') }}</p>
                                                    <span class="rate">
                                                        @foreach ($rating as $rate)
                                                            @if ($rate->products_id == $item->id)
                                                                @for ($i = 1; $i <= 5; $i++)
                                                                    @if ($rate->total_rating >= $i)
                                                                        <i class="fas fa-star" style="color: #efce4a"></i>
                                                                    @elseif ($rate->total_rating > $i - 1 && $rate->total_rating < $i)
                                                                        <i class="fas fa-star-half-alt"
                                                                            style="color: #efce4a"></i>
                                                                    @else
                                                                        <i class="far fa-star" style="color: #d7d7d7"></i>
                                                                    @endif
                                                                @endfor
                                                            @endif
                                                        @endforeach
                                                    </span>
                                                    <span style="font-style: italic; font-weight: 200; color: #c6c6c6">
                                                        @foreach ($totalBuying as $transaction)
                                                            @if ($transaction->products_id == $product->id)
                                                                {{ $transaction->total_quantity }} Terjual
                                                            @endif
                                                        @endforeach
                                                    </span>
                                                </div>
                                            </div>
                                        </a>
                                        <hr>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- Rekomended Product -->
        <section class="store-recomended-product">
            <div class="container">
                <div class="row" data-aos="fade-up" data-aos-delay="150">
                    <div class="col-12">
                        <hr />
                    </div>
                </div>
                <div class="row" data-aos="fade-up" data-aos-delay="150">
                    <h5 class="mt-4 mb-2" style="color: #ff7158">Produk Yang Mungkin Anda Sukai</h5>
                </div>
                <div class="row">
                    @php
                        $incrementProduct = 0;
                    @endphp
                    @forelse ($recomendationOne as $item)
                        <div class="col-6 col-md-4 col-lg-3">
                            <div data-aos="fade-up" data-aos-delay="{{ $incrementProduct += 100 }}">
                                <a href="{{ route('detail', $item->slug) }}" class="component-products d-block">
                                    <div class="product-thumbnail" style="height: 250px">
                                        <div class="products-image"
                                            style="
                            @if ($item->galleries->count()) background-image: url('{{ Storage::url($item->galleries->first()->photos) }}')
                                        @else 
                                        background-color: #eee @endif
                          ">
                                        </div>
                                    </div>
                                    <div class="products-text">{{ $item->name }}</div>
                                    <div class="products-price">Rp.
                                        {{ number_format($item->price, 0, ',', '.') }}
                                    </div>
                                </a>
                            </div>
                        </div>
                    @empty
                    @endforelse

                    @forelse ($recomendationTwo as $item)
                        <div class="col-6 col-md-4 col-lg-3">
                            <div data-aos="fade-up" data-aos-delay="{{ $incrementProduct += 100 }}">
                                <a href="{{ route('detail', $item->slug) }}" class="component-products d-block">
                                    <div class="product-thumbnail" style="height: 250px">
                                        <div class="products-image"
                                            style="
                            @if ($item->galleries->count()) background-image: url('{{ Storage::url($item->galleries->first()->photos) }}')
                                        @else 
                                        background-color: #eee @endif
                          ">
                                        </div>
                                    </div>
                                    <div class="products-text">{{ $item->name }}</div>
                                    <div class="products-price">Rp.
                                        {{ number_format($item->price, 0, ',', '.') }}
                                    </div>
                                </a>
                            </div>
                        </div>
                    @empty
                    @endforelse
                </div>
            </div>
        </section>

        {{-- Product Rating --}}
        <section class="store-product-rating">
            <div class="container">
                <div class="row" data-aos="fade-up">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="mt-4 mb-2" style="color: #ff7158">Rating Produk
                                    <span
                                        style="font-size: 15px; font-style: italic; color: #d3d3d3">({{ $productComment->count() }}
                                        review)</span>
                                </h5>
                                <div class="col-12">
                                    <hr />
                                </div>

                                @forelse ($productComment as $comment)
                                    <div class="row">
                                        <div class="col-1 pr-lg-0 text-center">
                                            {{-- Ambil foto dari relasi user jika tidak ada foto ambil dari images --}}
                                            <img src="{{ $comment->user->photo ? Storage::url($comment->user->photo) : url('images/user.png') }}"
                                                alt="" class="rounded-circle" width="50px" height="50px">
                                        </div>
                                        <div class="col-11">
                                            <div class="row">
                                                <div class="col-12">
                                                    <span>{{ substr($comment->user->name, 0, 1) . str_repeat('*', strlen($comment->user->name) - 2) . substr($comment->user->name, -2) }}</span>
                                                    <span style="color:#d3d3d3">|</span> <span
                                                        style="font-size: 12px; font-style: italic; color: #d3d3d3">{{ $comment->created_at->diffForHumans() }}</span>
                                                    {{-- Ambil ratingnya lalu tampilkan dengan icon --}}
                                                    <div>
                                                        @for ($i = 0; $i < $comment->rating; $i++)
                                                            <i class="fas fa-star" style="color: #efce4a">
                                                            </i>
                                                        @endfor
                                                    </div>
                                                    <span
                                                        style="font-size: 12px; font-style: italic; color: #d3d3d3">Variant
                                                        :
                                                        {{ $comment->variant->name }}</span>
                                                </div>
                                                <div class="col-9 col-md-5" style="line-height: 30px">
                                                    {!! $comment->comment !!}
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <hr />
                                        </div>
                                    </div>
                                @empty
                                    <div class="row">
                                        <div class="col-12">
                                            <p class="text-center">Belum ada review</p>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('addon-script')
    <script src="/vendor/vue/vue.js"></script>
    <script>
        var gallery = new Vue({
            el: "#gallery",
            mounted() {
                AOS.init();
            },
            data: {
                activePhoto: 0,
                photos: [
                    @foreach ($product->galleries as $gallery)
                        {
                            id: {{ $gallery->id }},
                            url: "{{ Storage::url($gallery->photos) }}",
                        },
                    @endforeach
                ],
            },
            methods: {
                changeActive(id) {
                    event.preventDefault();
                    this.activePhoto = id;
                },
            },
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.btn-variant').click(function() {
                $('.btn-variant').removeClass('clicked');
                $(this).toggleClass('clicked');
            });
        });
    </script>

    <script>
        function formatPrice(price) {
            const parts = price.toString().split(".");
            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            return 'Rp. ' + parts.join(",");
        }

        function updatePrice(price, id, stock) {
            console.log(stock);
            console.log(document.getElementById('price').innerHTML = formatPrice(price));
            document.getElementById('variant_id').value = id;
            document.getElementById('stock').innerHTML = 'tersisa ' + stock + ' pcs';
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.all.min.js"></script>
    <script>
        // Berhentikan dahulu formnya untuk mengecek ketika dia ada variant dan apakah sudah memilih
        $(document).ready(function() {
            $('#add-cart').submit(function(e) {
                e.preventDefault();
                // Cek apakah dia punya $product->variants
                if ($('.btn-variant').length) {
                    // Cek apakah dia sudah memilih variant
                    if ($('.btn-variant.clicked').length) {
                        // Sudah memilih variant
                        this.submit();
                    } else {
                        // Belum memilih variant
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Silahkan pilih varian terlebih dahulu!',
                        });
                    }
                } else {
                    // Tidak punya variant
                    this.submit();
                }

            });
        });
    </script>

    <script>
        var users_id = "{{ Auth::check() ? Auth::user()->id : 0 }}";
        $(document).ready(function() {
            $('.wishlist').click(function() {
                if (!users_id) {
                    // Tampilkan pesan untuk user untuk login terlebih dahulu
                    alert("Anda harus login terlebih dahulu untuk menambahkan produk ke wishlist");
                    return;
                }
                var currentPosition = $(window).scrollTop();
                var products_id = $(this).data('id');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: '/wishlist',
                    data: {
                        users_id: users_id,
                        products_id: products_id,
                    },
                    success: function(response) {
                        if (response.action == 'add') {
                            // Berikan alert keren untuk memberitahu bahwa produk berhasil ditambahkan ke wishlist
                            alert('Produk berhasil ditambahkan ke wishlist');
                        } else if (response.action == 'remove') {
                            alert('Produk berhasil dihapus dari wishlist');
                        }
                        $(window).scrollTop(currentPosition);
                    }
                });
            });
        });
    </script>
@endpush
