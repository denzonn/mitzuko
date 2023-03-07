@extends('layouts.auth')


@section('content')
    <div class="page-content page-auth">
        <div class="section-store-auth mt-4" data-aos="fade-up">
            <div class="container">
                <div class="row align-item-center row-login">
                    <div class="col-lg-6 d-none d-lg-block text-center pagee login-part">
                        <img src="/images/login.svg" alt="" class="w-100 mb-4 mb-lg-none" />
                    </div>
                    <div class="col-lg-5 pagee">
                        <h2>
                            Belanja kebutuhan utama, <br />
                            menjadi lebih mudah
                        </h2>
                        <form method="POST" action="{{ route('login') }}" class="mt-3">
                            @csrf
                            <div class="form-group">
                                <label>Email Address</label>
                                <input id="email" type="email"
                                    class="form-control w-75 @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input id="password" type="password"
                                    class="form-control w-75 @error('password') is-invalid @enderror" name="password"
                                    required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-success btn-block w-75 mt-4">Sign In to My
                                Account</button>
                            <a href="{{ route('register') }}" class="btn btn-signup btn-block w-75 mt-2">Sign Up</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('addon-script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"
        integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $('form').submit(function(e) {
            e.preventDefault();
            var form = $(this);

            $.ajax({
                url: form.attr('action'),
                method: form.attr('method'),
                data: new FormData(form[0]),
                contentType: false,
                processData: false,
                success: function() {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Login Berhasil',
                        icon: 'success',
                    });
                    setTimeout(() => {
                        window.location.href = "{{ route('home') }}";
                    }, 2000); // 2000 ms = 2 detik
                },
                error: function(xhr) {
                    Swal.fire({
                        title: 'Gagal!',
                        text: 'Login Gagal',
                        icon: 'error',
                    });
                }
            });
        });
    </script>
@endpush
