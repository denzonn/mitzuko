<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>@yield('title')</title>

    @stack('prepend-style')
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <link href="/style/main.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.13.1/datatables.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.16/dist/sweetalert2.min.css">
    @stack('addon-style')
</head>

<body>
    <!-- Navbar -->
    <div class="page-dashboard">
        <div class="d-flex" id="wrapper" data-aos="fade-right">
            <!-- Sidebar -->
            <div class="border-right" id="sidebar-wrapper">
                <div class="sidebard-heading text-center">
                    <img src="/images/settings.png" alt="" class="my-4 w-50" style="max-width: 150px" />
                </div>
                <div class="list-group list-group-flush">
                    <a href="{{ route('admin-dashboard') }}"
                        class="list-group-item list-group-item-action {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('category.index') }}"
                        class="list-group-item list-group-item-action {{ request()->is('admin/category*') ? 'active' : '' }}">
                        Categories
                    </a>
                    <a href="{{ route('product.index') }}"
                        class="list-group-item list-group-item-action {{ request()->is('admin/product*') ? 'active' : '' }}">
                        Product
                    </a>
                    <a href="{{ route('admin-dashboard-transactions') }}"
                        class="list-group-item list-group-item-action {{ request()->is('admin/dashboard/transactions*') ? 'active' : '' }}">
                        Transaction
                    </a>
                    <a href="{{ route('user.index') }}"
                        class="list-group-item list-group-item-action {{ request()->is('admin/user*') ? 'active' : '' }}">
                        Users
                    </a>
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        class="list-group-item list-group-item-action">Sign Out</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>

            <!-- Page Content -->
            <div id="page-content-wrapper">
                <nav class="navbar navbar-expand-lg navbar-light navbar-store fixed-top" data-aos="fade-down">
                    <div class="container-fluid">
                        <button class="btn btn-secondary d-lg-none mr-auto mr-2" id="menu-toggle">
                            &laquo; Menu
                        </button>
                        <button class="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#navbarSupportedContent">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <!-- Desktop Menu -->
                            <ul class="navbar-nav d-none d-lg-flex ml-auto">
                                <li class="nav-item dropdown">
                                    <a href="{{ route('home') }}" class="nav-link" id="navbarDropdown" role="button"
                                        data-toggle="dropdown">
                                        <img src="/images/user_pc.png" alt=""
                                            class="rounded-circle mr-2 profile-picture" />Hi,
                                        {{ Auth::user()->name }}</a>

                                </li>
                            </ul>

                            <!-- Mobile Menu -->
                            <ul class="navbar-nav d-block d-lg-none">
                                <li class="nav-item">
                                    <a href="#" class="nav-link">Hi, {{ Auth::user()->name }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>

                <!--  Content -->
                @yield('content')
            </div>
        </div>
    </div>

    {{-- Chat --}}
    @include('includes.chat')

    <!-- Bootstrap core JavaScript -->
    @stack('prepend-script')
    <script src="/vendor/jquery/jquery.min.js"></script>
    <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.13.1/datatables.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.all.min.js"></script>
    <script>
        AOS.init();
    </script>
    <script>
        $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });
    </script>
    @stack('addon-script')
</body>

</html>
