@extends('layouts.app')

@section('title')
    Mitzuko - Toko Online
@endsection

@section('content')
    <div class="page-content page-home">
        <!-- New Products -->
        <section class="store-new-products">
            <div class="container">
                <div class="row">
                    <div class="col-12" data-aos="fade-up">
                        <h5>Searching for <span class="text-success">{{ $searchKeyword }}</span>
                        </h5>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 ">
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist" data-aos="fade-up">
                            <li class="nav-item mr-5" role="presentation">
                                <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home"
                                    role="tab" aria-controls="pills-home" aria-selected="true">Terkait</a>
                            </li>
                            <li class="nav-item mr-5" role="presentation">
                                <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile"
                                    role="tab" aria-controls="pills-profile" aria-selected="false">Terbaru</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact"
                                    role="tab" aria-controls="pills-contact" aria-selected="false">Terlaris</a>
                            </li>
                        </ul>
                        @php
                            $incrementProduct = 0;
                        @endphp
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                aria-labelledby="pills-home-tab">
                                <div class="row ">
                                    @forelse ($search as $product)
                                        <div class="col-6 col-md-4 col-lg-3 d-flex" data-aos="fade-up"
                                            data-aos-delay="{{ $incrementProduct += 100 }}">
                                            <a href="{{ route('detail', $product->slug) }}"
                                                class="component-products d-block">
                                                <div class="product-thumbnail">
                                                    <div class="products-image"
                                                        style="@if ($product->galleries->count()) background-image: url('{{ Storage::url($product->galleries->first()->photos) }}')
                                        @else 
                                        background-color: #eee @endif
                                        ">
                                                    </div>
                                                </div>
                                                <div class="products-text">
                                                    {{ \Illuminate\Support\Str::limit($product->name ?? '', 50, ' ...') }}
                                                </div>
                                                <div class="products-price">Rp.
                                                    {{ number_format($product->price, 0, ',', '.') }}
                                                </div>
                                            </a>
                                        </div>
                                    @empty
                                        <img src="/images/noProduct.png" alt="" class="no-product"
                                            data-aos="fade-up">
                                    @endforelse
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                                aria-labelledby="pills-profile-tab">
                                <div class="row">
                                    @forelse ($fresh as $product)
                                        <div class="col-6 col-md-4 col-lg-3 d-flex" data-aos="fade-up"
                                            data-aos-delay="{{ $incrementProduct += 100 }}">
                                            <a href="{{ route('detail', $product->slug) }}"
                                                class="component-products d-block">
                                                <div class="product-thumbnail">
                                                    <div class="products-image"
                                                        style="@if ($product->galleries->count()) background-image: url('{{ Storage::url($product->galleries->first()->photos) }}')
                                        @else 
                                        background-color: #eee @endif
                                        ">
                                                    </div>
                                                </div>
                                                <div class="products-text">
                                                    {{ \Illuminate\Support\Str::limit($product->name ?? '', 50, ' ...') }}
                                                </div>
                                                <div class="products-price">Rp.
                                                    {{ number_format($product->price, 0, ',', '.') }}
                                                </div>
                                            </a>
                                        </div>
                                    @empty
                                        <img src="/images/noProduct.png" alt="" class="no-product"
                                            data-aos="fade-up">
                                    @endforelse
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                                aria-labelledby="pills-contact-tab">
                                <div class="row">
                                    @forelse ($popular as $product)
                                        <div class="col-6 col-md-4 col-lg-3 d-flex" data-aos="fade-up"
                                            data-aos-delay="{{ $incrementProduct += 100 }}">
                                            <a href="{{ route('detail', $product->slug) }}"
                                                class="component-products d-block">
                                                <div class="product-thumbnail">
                                                    <div class="products-image"
                                                        style="@if ($product->galleries->count()) background-image: url('{{ Storage::url($product->galleries->first()->photos) }}')
                                        @else 
                                        background-color: #eee @endif
                                        ">
                                                    </div>
                                                </div>
                                                <div class="products-text">
                                                    {{ \Illuminate\Support\Str::limit($product->name ?? '', 50, ' ...') }}
                                                </div>
                                                <div class="products-price">Rp.
                                                    {{ number_format($product->price, 0, ',', '.') }}
                                                </div>
                                            </a>
                                        </div>
                                    @empty
                                        <img src="/images/noProduct.png" alt="" class="no-product"
                                            data-aos="fade-up">
                                    @endforelse
                                </div>
                            </div>

                            {{-- Filter Price --}}
                            {{-- <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                                aria-labelledby="pills-contact-tab">
                                <div class="row">
                                    @forelse ($popular as $product)
                                        <div class="col-6 col-md-4 col-lg-3 d-flex" data-aos="fade-up"
                                            data-aos-delay="{{ $incrementProduct += 100 }}">
                                            <a href="{{ route('detail', $product->slug) }}"
                                                class="component-products d-block">
                                                <div class="product-thumbnail">
                                                    <div class="products-image"
                                                        style="@if ($product->galleries->count()) background-image: url('{{ Storage::url($product->galleries->first()->photos) }}')
                                        @else 
                                        background-color: #eee @endif
                                        ">
                                                    </div>
                                                </div>
                                                <div class="products-text">
                                                    {{ \Illuminate\Support\Str::limit($product->name ?? '', 50, ' ...') }}
                                                </div>
                                                <div class="products-price">Rp.
                                                    {{ number_format($product->price, 0, ',', '.') }}
                                                </div>
                                            </a>
                                        </div>
                                    @empty
                                        <div class="col-12 text-center py-5" data-aos="fade-up" data-aos-delay="100">
                                            No Products Found
                                        </div>
                                    @endforelse
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
