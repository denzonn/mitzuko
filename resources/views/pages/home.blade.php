@extends('layouts.app')

@section('title')
    Mitzuko - Toko Online
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
    <div class="page-content page-home">
        <!-- Carousel -->
        <section class="store-carousel">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12" data-aos="zoom-in">
                        <div id="storeCarousel" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li class="active" data-target="#storeCarousel" data-slide-to="0"></li>
                                <li data-target="#storeCarousel" data-slide-to="1"></li>
                                <li data-target="#storeCarousel" data-slide-to="2"></li>
                            </ol>
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="/images/carousel1.png" alt="Carousel Image" class="d-block w-100" />
                                </div>
                                <div class="carousel-item">
                                    <img src="/images/carousel2.png" alt="Carousel Image" class="d-block w-100" />
                                </div>
                                <div class="carousel-item">
                                    <img src="/images/carousel3.png" alt="Carousel Image" class="d-block w-100" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Trend Categories -->
        <section class="store-trend-categories" id="store-trend-categories">
            <div class="container">
                <div class="row">
                    <div class="col-12" data-aos="fade-up">
                        <h5>Trend Categories</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 ">
                        <div class="owl-carousel owl-theme pt-1">
                            @php
                                $incrementCategory = 0;
                            @endphp
                            @forelse ($categories as $category)
                                <div class="col-12 px-0 pt-2" data-aos="fade-up"
                                    data-aos-delay="{{ $incrementCategory += 100 }}">
                                    <a href="{{ route('categories-detail', $category->slug) }}"
                                        class="component-categories d-block">
                                        <div class="categories-image">
                                            <img src="{{ Storage::url($category->photo) }}" alt="" class="w-100" />
                                            <p class="categories-text">{{ $category->name }}</p>
                                        </div>
                                    </a>
                                </div>
                            @empty
                                <div class="col-12 text-center py-5" data-aos="fade-up" data-aos-delay="100">
                                    No Categories Found
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- New Products -->
        <section class="store-new-products mb-3" id="store-new-products">
            <div class="container">
                <div class="row">
                    <div class="col-12" data-aos="fade-up">
                        <h5 style="font-weight: 600"><span style="color: #ff7158; ">New</span> Products</h5>
                    </div>
                </div>
                <div class="row">
                    @php
                        $incrementProduct = 0;
                    @endphp
                    @forelse ($products as $product)
                        <div class="col-6 col-md-4 col-lg-3" data-aos="fade-up"
                            data-aos-delay="{{ $incrementProduct += 100 }}">
                            <a href="{{ route('detail', $product->slug) }}" class="component-products d-block">
                                <div class="product-thumbnail">
                                    <div class="products-image"
                                        style="@if ($product->galleries->count()) background-image: url('{{ Storage::url($product->galleries->first()->photos) }}')
                                        @else 
                                        background-color: #eee @endif
                                        ">
                                    </div>
                                </div>
                                <div class="products-text">
                                    {{ \Illuminate\Support\Str::limit($product->name ?? '', 45, ' ...') }}
                                </div>
                                {{-- Buatkan price dan total product di beli --}}
                                <span class="products-price px-0 col-6">Rp.
                                    {{ number_format($product->price, 0, ',', '.') }}
                                </span>
                                <div class="products-price mt-0">
                                    <span>
                                        @foreach ($rating as $rate)
                                            @if ($rate->products_id == $product->id)
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($rate->total_rating >= $i)
                                                        <i class="fas fa-star" style="color: #efce4a"></i>
                                                    @elseif ($rate->total_rating > $i - 1 && $rate->total_rating < $i)
                                                        <i class="fas fa-star-half-alt" style="color: #efce4a"></i>
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
                            </a>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5" data-aos="fade-up" data-aos-delay="100">
                            No Products Found
                        </div>
                    @endforelse
                </div>
                <div id="pagination">
                    @include('layouts.pagination', ['paginator' => $products])
                </div>
            </div>
        </section>

        {{-- Offers --}}
        <section class="store-offers mt-4">
            <div class="container">
                <div class="row d-flex">
                    <div class="col-4">
                        <div class="offers-image" data-aos="fade-up" data-aos-delay="100">
                            <img src="/images/iklan1.jpg" />
                            <div class="image-caption">
                                <h6>Smart Offer</h6>
                                <p>Buy 1 <br> Get 1 Free</p>
                                <button class="shopNow btn p-0" id="shopNow">
                                    <span>Shop Now <i class="fas fa-arrow-right"></i> </span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="offers-image" data-aos="fade-up" data-aos-delay="100">
                            <img src="/images/iklan2.jpg" />
                            <div class="image-caption">
                                <h6>Great Category</h6>
                                <p>Find Your <br> Favorite</p>
                                <button class="shopNow btn p-0" id="shopNow2">
                                    <span>Lets Find <i class="fas fa-arrow-right"></i> </span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="offers-image" data-aos="fade-up" data-aos-delay="100">
                            <img src="/images/iklan3.jpg" />
                            <div class="image-caption">
                                <h6>Sale Off</h6>
                                <p>With Best <br> Discount</p>
                                <button class="shopNow btn p-0" id="shopNow3">
                                    <span>Buy It <i class="fas fa-arrow-right"></i> </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Popular Product --}}
        <section class="store-popular-products mt-4" id="store-popular-products">
            <div class="container">
                <div class="row">
                    <div class="col-12" data-aos="fade-up">
                        <h5 style="font-weight: 600"><span style="color:#ff7158">Popular</span> Products</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 ">
                        <div class="owl-carousel owl-theme pt-1">
                            @php
                                $incrementProducts = 0;
                            @endphp
                            @forelse ($popularProducts as $item)
                                <div class="col-12 px-0 pt-2" data-aos="fade-up"
                                    data-aos-delay="{{ $incrementProducts += 100 }}">
                                    <a href="{{ route('categories-detail', $item->slug) }}"
                                        class="component-product-popular d-block">
                                        <div class="product-popular-image">
                                            <img src="{{ Storage::url($item->galleries->first()->photos) }}"
                                                alt="" class="w-100" />
                                        </div>
                                        <p class="product-popular-text mb-0">
                                            {{ \Illuminate\Support\Str::limit($item->name ?? '', 32, ' ...') }}</p>
                                        <div class="product-popular-price ">
                                            Rp. {{ number_format($item->price, 0, ',', '.') }}
                                        </div>
                                        <div class="product-popular-rating">
                                            <span>
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
                                            <span
                                                style="font-style: italic; font-weight: 200; color: #c6c6c6; font-size: 12px">
                                                @foreach ($totalBuying as $transaction)
                                                    @if ($transaction->products_id == $item->id)
                                                        {{ $transaction->total_quantity }} Terjual
                                                    @endif
                                                @endforeach
                                            </span>
                                        </div>
                                    </a>
                                </div>
                            @empty
                                <div class="col-12 text-center py-5" data-aos="fade-up" data-aos-delay="100">
                                    No Popular Products Found
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Brand Support --}}
        <section class="store-brand-support mt-4" id="store-brand-support">
            <div class="container">
                <div class="row">
                    <div class="col-12" data-aos="fade-up">
                        <h5 style="font-weight: 600"><span style="color:#ff7158">Brand</span> Supports</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 ">
                        <div class="owl-carousel owl-theme pt-1 align-items-center">
                            <div class="col-12 px-0 pt-2" data-aos="fade-up" data-aos-delay="100">
                                <img src="/images/brand/makeover.png" alt="">
                            </div>
                            <div class="col-12 px-0 pt-2" data-aos="fade-up" data-aos-delay="200">
                                <img src="/images/brand/azarine.png" alt="">
                            </div>
                            <div class="col-12 px-0 pt-2" data-aos="fade-up" data-aos-delay="300">
                                <img src="/images/brand/khaf.png" alt="">
                            </div>
                            <div class="col-12 px-0 pt-2" data-aos="fade-up" data-aos-delay="400">
                                <img src="/images/brand/loreal.png" alt="">
                            </div>
                            <div class="col-12 px-0 pt-2" data-aos="fade-up" data-aos-delay="500">
                                <img src="/images/brand/maybeline.png" alt="">
                            </div>
                            <div class="col-12 px-0 pt-2" data-aos="fade-up" data-aos-delay="600">
                                <img src="/images/brand/pixy.png" alt="">
                            </div>
                            <div class="col-12 px-0 pt-2" data-aos="fade-up" data-aos-delay="700">
                                <img src="/images/brand/safi.png" alt="">
                            </div>
                            <div class="col-12 px-0 pt-2" data-aos="fade-up" data-aos-delay="800">
                                <img src="/images/brand/scarlet.png" alt="">
                            </div>
                            <div class="col-12 px-0 pt-2" data-aos="fade-up" data-aos-delay="900">
                                <img src="/images/brand/wardah.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('addon-script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"
        integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(".owl-carousel").owlCarousel({
            loop: true,
            autoplay: true,
            autoplayTimeout: 5000,
            autoplaySpeed: 1000,
            margin: 20,
            dots: false,
            items: 3,
            responsive: {
                0: {
                    items: 3,
                },
                767: {
                    items: 4,
                },
                990: {
                    items: 6,
                },
                1000: {
                    items: 6,
                },
            },
        });
    </script>

    <script>
        const shopNow = document.querySelector('#shopNow')
        shopNow.addEventListener('click', function() {
            let store = document.getElementById('store-new-products')
            window.scrollTo({
                top: store.offsetTop - 70,
                behavior: 'smooth',
            })
        })

        const shopNow2 = document.querySelector('#shopNow2')
        shopNow2.addEventListener('click', function() {
            let stores = document.getElementById('store-trend-categories')
            console.log(stores);
            window.scrollTo({
                top: stores.offsetTop - 70,
                behavior: 'smooth',
            })
        })
    </script>
@endpush
