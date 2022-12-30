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
                                    <a href="index.html">Home</a>
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
                        <div class="row">
                            <div class="col-3 col-lg-12 mt-2 mt-lg-0" v-for="(photo, index) in photos"
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
                            <div class="price mt-3">Rp. {{ number_format($product->price, 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="col-lg-2" data-aos="zoom-in">
                            @auth
                                <form action="{{ route('detail-add', $product->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <button type="submit" class="btn btn-success px-4 text-white btn-block mb-3">
                                        Add to Cart
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-success px-4 text-white btn-block mb-3">
                                    Sign In to Add
                                </a>
                            @endauth
                        </div>
                    </div>
            </section>

            <!-- Desc -->
            <section class="store-description">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-lg-8">
                            <p>
                                {!! $product->description !!}
                            </p>
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
                <div class="row">
                    <h5 class="mt-4 mb-2">Produk Yang Mungkin Anda Sukai</h5>
                </div>
                <div class="row">
                    <div class="col-12 col-xl-8 col-lg-8 col-md-12 col-sm-12 items">
                        <div id="owl-carousel" class="owl-carousel owl-theme">
                            <div class="item">
                                <div data-aos="fade-up" data-aos-delay="100">
                                    <a href="details.html" class="component-products d-block">
                                        <div class="product-thumbnail">
                                            <div class="products-image"
                                                style="
                            background-image: url('/images/product-sepatu.jpg');
                          ">
                                            </div>
                                        </div>
                                        <div class="products-text">Apple Watch 4</div>
                                        <div class="products-price">Rp. 100.000</div>
                                    </a>
                                </div>
                            </div>
                            <div class="item">
                                <div data-aos="fade-up" data-aos-delay="100">
                                    <a href="details.html" class="component-products d-block">
                                        <div class="product-thumbnail">
                                            <div class="products-image"
                                                style="
                            background-image: url('/images/product-sepatu.jpg');
                          ">
                                            </div>
                                        </div>
                                        <div class="products-text">Apple Watch 4</div>
                                        <div class="products-price">Rp. 100.000</div>
                                    </a>
                                </div>
                            </div>
                            <div class="item">
                                <div data-aos="fade-up" data-aos-delay="100">
                                    <a href="details.html" class="component-products d-block">
                                        <div class="product-thumbnail">
                                            <div class="products-image"
                                                style="
                            background-image: url('/images/product-sepatu.jpg');
                          ">
                                            </div>
                                        </div>
                                        <div class="products-text">Apple Watch 4</div>
                                        <div class="products-price">Rp. 100.000</div>
                                    </a>
                                </div>
                            </div>
                            <div class="item">
                                <div data-aos="fade-up" data-aos-delay="100">
                                    <a href="details.html" class="component-products d-block">
                                        <div class="product-thumbnail">
                                            <div class="products-image"
                                                style="
                            background-image: url('/images/product-sepatu.jpg');
                          ">
                                            </div>
                                        </div>
                                        <div class="products-text">Apple Watch 4</div>
                                        <div class="products-price">Rp. 100.000</div>
                                    </a>
                                </div>
                            </div>
                            <div class="item">
                                <div data-aos="fade-up" data-aos-delay="100">
                                    <a href="details.html" class="component-products d-block">
                                        <div class="product-thumbnail">
                                            <div class="products-image"
                                                style="
                            background-image: url('/images/product-sepatu.jpg');
                          ">
                                            </div>
                                        </div>
                                        <div class="products-text">Apple Watch 4</div>
                                        <div class="products-price">Rp. 100.000</div>
                                    </a>
                                </div>
                            </div>
                            <div class="item">
                                <div data-aos="fade-up" data-aos-delay="100">
                                    <a href="details.html" class="component-products d-block">
                                        <div class="product-thumbnail">
                                            <div class="products-image"
                                                style="
                            background-image: url('/images/product-sepatu.jpg');
                          ">
                                            </div>
                                        </div>
                                        <div class="products-text">Apple Watch 4</div>
                                        <div class="products-price">Rp. 100.000</div>
                                    </a>
                                </div>
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
                    this.activePhoto = id;
                },
            },
        });
    </script>
    <script src="/script/navbar-scroll.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.2/jquery.min.js"
        integrity="sha512-tWHlutFnuG0C6nQRlpvrEhE4QpkG1nn2MOUMWmUeRePl4e3Aki0VB6W1v3oLjFtd0hVOtRQ9PHpSfN6u6/QXkQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"
        integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $("#owl-carousel").owlCarousel({
            loop: false,
            margin: 20,
            dots: false,
            items: 3,
            responsive: {
                0: {
                    items: 3,
                },
                767: {
                    items: 3,
                },
                990: {
                    items: 4,
                },
                1000: {
                    items: 4,
                },
            },
        });
    </script>
@endpush
