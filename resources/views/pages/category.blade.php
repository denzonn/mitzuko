@extends('layouts.app')

@section('title')
    Category Pages - Store
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
        <!-- Trend Categories -->
        <section class="store-trend-categories">
            <div class="container">
                <div class="row">
                    <div class="col-12" data-aos="fade-up">
                        <h5>Categories</h5>
                    </div>
                </div>
                <div class="row">
                    @php
                        $incrementCategory = 0;
                    @endphp
                    @forelse ($categories as $category)
                        <div class="col-4 col-md-4 col-lg-2" data-aos="fade-up"
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
                <div class="row">
                    <div class="col-12 mt-4">
                    </div>
                </div>
            </div>
        </section>

        <!-- New Products -->
        <section class="store-new-products">
            <div class="container">
                <div class="row">
                    <div class="col-12" data-aos="fade-up">
                        <h5>Popular Products</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 ">
                        <div class="owl-carousel owl-theme pt-1">
                            @php
                                $incrementProduct = 0;
                            @endphp
                            @forelse ($products as $product)
                                <div class="col-12 px-0 d-flex " data-aos="fade-up"
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
                                            {{ \Illuminate\Support\Str::limit($product->name ?? '', 50, ' ...') }}</div>
                                        <div class="products-price">Rp. {{ number_format($product->price, 0, ',', '.') }}
                                        </div>
                                    </a>
                                </div>
                            @empty
                                <div class="col-12 text-center py-5" data-aos="fade-up" data-aos-delay="100">
                                    No Products Found
                                </div>
                            @endforelse
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
                    items: 4,
                },
                1000: {
                    items: 4,
                },
            },
        });
    </script>
@endpush
