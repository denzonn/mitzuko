<nav class="navbar navbar-expand-lg navbar-light navbar-store fixed-top navbar-fixed-top" data-aos="fade-down">
    <div class="container">
        <a href="{{ route('home') }}" class="navbar-brand" style="max-width: 200px">
            <img src="/images/logo.png" alt="Logo" class="w-75" />
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto ">
                <li class="nav-item {{ request()->is('/*') ? 'active' : '' }}">
                    <a href="{{ route('home') }}" class="nav-link">Home</a>
                </li>
                <li class="nav-item {{ request()->is('/categories') ? 'active' : '' }}">
                    <a href="{{ route('categories') }}" class="nav-link">Categories</a>
                </li>
                <li class="nav-item">
                    <form action="/product" method="GET" enctype="multipart/form-data">
                        <div class="search-bar">
                            <input type="text" placeholder="Search" class="wide" name="search"
                                value="{{ request('search') }}">
                            <input type="hidden" value="submit">
                        </div>
                    </form>
                </li>
                @guest
                    <li class="nav-item">
                        <a href="{{ route('register') }}" class="nav-link">Sign Up</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="btn btn-success nav-link px-4 text-white">Sign In</a>
                    </li>
                @endguest
            </ul>

            @auth
                <!-- Desktop Menu -->
                <ul class="navbar-nav d-none d-lg-flex">
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link" id="navbarDropdown" role="button" data-toggle="dropdown">
                            <img src="{{ Storage::url(Auth::user()->photo ?? '../images/user.png') }}" alt=""
                                class="rounded-circle mr-2 profile-picture" />Hi,
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu">
                            @if (Auth::user()->roles == 'ADMIN')
                                <a href="{{ route('admin-dashboard') }}" class="dropdown-item">Dashboard</a>
                            @else
                            @endif
                            <a href="{{ route('dashboard-settings-account') }}" class="dropdown-item">Settings</a>
                            <div class="dropdown-divider"></div>
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                class="dropdown-item">{{ __('Logout') }}</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>

                    </li>
                    <li class="nav-item">
                        @php
                            $wishlists = \App\Models\Wishlist::where('users_id', Auth::user()->id)->count();
                        @endphp
                        @if ($wishlists > 0)
                            <a href="{{ route('myWishlist') }}" class="mt-2" style="text-decoration: none">
                                <i class="far fa-heart mt-3" style="color: #383838; font-size: 25px; ">
                                </i>
                                <div class="cart-badge-wishlist mt-0">{{ $wishlists }}</div>
                            </a>
                        @else
                            <a href="{{ route('myWishlist') }}" class="mt-2" style="text-decoration: none">
                                <i class="far fa-heart mt-3" style="color: #ff7158; font-size: 25px; ">
                                </i>
                            </a>
                        @endif
                    </li>
                    <li class="nav-item">
                        <div class="nav-link d-inline-block mt-2">
                            <a href="{{ route('cart') }}">
                                @php
                                    $carts = \App\Models\Cart::where('users_id', Auth::user()->id)->count();
                                @endphp
                                @if ($carts > 0)
                                    {{-- Wishlist --}}
                                    <img src="/images/cart_filled.svg" alt="" />
                                    <div class="cart-badge">{{ $carts }}</div>
                                @else
                                    <img src="/images/cart-empty.svg" alt="" />
                                @endif

                                <div class="cart-show">
                                    @php
                                        $carts = \App\Models\Cart::with(['product.galleries'])
                                            ->where('users_id', Auth::user()->id)
                                            ->take(5)
                                            ->get();
                                        
                                        $variantTypeIds = [];
                                        foreach ($carts as $cart) {
                                            // Ambil variant type id berdasarkan cart
                                            $variantTypeIds[] = $cart->variant_type_id;
                                        }
                                        $variantData = \App\Models\VariantType::whereIn('id', $variantTypeIds)->get();
                                    @endphp
                                    @forelse ($carts as $cart)
                                        <div class="col-12 d-flex align-items-center mb-3 px-0">
                                            <div class="col-2">
                                                <img src="{{ Storage::url($cart->product->galleries->first()->photos) }}"
                                                    alt="">
                                            </div>
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-12" style="font-size: 14px; color:#383838">
                                                        {{ \Illuminate\Support\Str::limit($cart->product->name ?? '', 35, ' ...') }}
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6" style="font-size: 14px; color: #c3c3c3">
                                                        @foreach ($variantData as $item)
                                                            @if ($item->id == $cart->variant_type_id)
                                                                Variant : {{ $item->name }}
                                                            @endif
                                                        @endforeach
                                                        @if (empty($cart->variant_type_id))
                                                            Variant : -
                                                        @endif
                                                    </div>
                                                    <div class="col-4 px-1" style="font-size: 14px; color: #ff7158">Rp.
                                                        {{ number_format($cart->product->price, 0, ',', '.') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="d-flex align-items-center text-center">
                                            <div class="col-12" style="color: #ff0004">
                                                No item in cart <img src="/images/cancel.png" alt=""
                                                    style="width: 30px; height: auto">
                                            </div>
                                        </div>
                                    @endforelse
                                    @if ($carts->count() > 0)
                                        <div class="col-12  text-right another">
                                            <a href="{{ route('cart') }}">Lihat
                                                lainnya</a>
                                        </div>
                                    @else
                                    @endif
                                </div>
                            </a>
                        </div>
                    </li>
                </ul>

                <!-- Mobile Menu -->
                <ul class="navbar-nav d-block d-lg-none">
                    <li class="nav-item">
                        <a href="#" class="nav-link">Hi, {{ Auth::user()->name }}</a>
                        <a href="{{ route('myWishlist') }}" class="nav-link ">Wishlist</a>
                        <a href="{{ route('cart') }}" class="nav-link d-inline-block">Cart</a>
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            class="dropdown-item">{{ __('Logout') }}</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            @endauth
        </div>
    </div>
</nav>
