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
        <!-- New Products -->
        <section class="store-new-products">
            <div class="container">
                <div class="row">
                    <div class="col-12" data-aos="fade-up">
                        <h5>My Products Wishlist</h5>
                    </div>
                </div>
                <div class="row">
                    @php
                        $incrementProduct = 0;
                    @endphp
                    @forelse ($wishlist as $product)
                        <div class="col-6 col-md-4 col-lg-3" data-aos="fade-up"
                            data-aos-delay="{{ $incrementProduct += 100 }}">
                            <div class="component-products d-block">
                                <div class="product-thumbnail">
                                    <a href="{{ route('detail', $product->product->slug) }}">
                                        <div class="products-image"
                                            style="@if ($product->product->galleries->count()) background-image: url('{{ Storage::url($product->product->galleries->first()->photos) }}')
                                        @else 
                                        background-color: #eee @endif
                                        ">

                                        </div>
                                    </a>
                                    <div class="product-hover">
                                        @php
                                            $count = 0;
                                        @endphp
                                        @if (Auth::check())
                                            @php
                                                $count = App\Models\Wishlist::countWishlist($product->id);
                                            @endphp
                                        @endif
                                        <a class="wishlist" data-id="{{ $product->product->id }}"
                                            @if ($count > 0) checked @endif>
                                            <div class="d-inline-block">
                                                <div class="caption mb-1">Remove To Wishlist</div>
                                                <i class="far fa-heart">
                                                </i>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="products-text">
                                    {{ \Illuminate\Support\Str::limit($product->product->name ?? '', 45, ' ...') }}
                                </div>
                                {{-- Buatkan price dan total product di beli --}}
                                <span class="products-price px-0 col-6">Rp.
                                    {{ number_format($product->product->price, 0, ',', '.') }}
                                </span>
                                <div class="products-price mt-0">
                                    <span class="">
                                        @foreach ($rating as $rate)
                                            @if ($rate->products_id == $product->product->id)
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
                                            @if ($transaction->products_id == $product->product->id)
                                                {{ $transaction->total_quantity }} Terjual
                                            @endif
                                        @endforeach
                                    </span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5" data-aos="fade-up" data-aos-delay="100">
                            No Products Wishlist
                        </div>
                    @endforelse
                </div>
            </div>
        </section>
    </div>
@endsection

@push('addon-script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"
        integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        var users_id = "{{ Auth::user()->id }}";
        $(document).ready(function() {
            $('.wishlist').click(function() {
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
