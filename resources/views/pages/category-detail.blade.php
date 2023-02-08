@extends('layouts.app')

@section('title')
    Category Detail Pages - Store
@endsection

@section('content')
    <div class="page-content page-home">
        <!-- Trend Categories -->
        <section class="store-trend-categories">
            <div class="container">
                <div class="row">
                    <div class="col-12" data-aos="fade-up">
                        <h5>All Product for Category : <span class="text-success">{{ $category->name }}</span> </h5>
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
                                    {{ \Illuminate\Support\Str::limit($product->name ?? '', 50, ' ...') }}</div>
                                <div class="products-price">Rp. {{ number_format($product->price, 0, ',', '.') }}</div>
                            </a>
                        </div>
                    @empty
                        <img src="/images/noProduct.png" alt="" class="no-product">
                    @endforelse
                </div>
            </div>
        </section>
    </div>
@endsection
