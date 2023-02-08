@extends('layouts.auth')

@section('content')
    <div class="page-content page-auth" id="register">
        <div class="section-store-auth " data-aos="fade-up">
            <div class="container">
                <div class="row align-item-center justify-content-center row-login">
                    <div class="col-lg-4">
                        <h2>
                            Memulai untuk jual beli
                            <br />
                            dengan cara terbaru
                        </h2>
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="form-group">
                                <label>UserName</label>
                                <input id="name" type="text"
                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                    value="{{ old('name') }}" v-model="name" required autocomplete="name" maxlength="12"
                                    autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Phone Number</label>
                                <input id="phone-number" type="number"
                                    class="form-control @error('phone_number') is-invalid @enderror" name="phone_number"
                                    v-model="phone_number" required maxlength="12">

                                @error('phone_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Email Address</label>
                                <input v-model="email" @change="checkForEmailAvailability()" id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    :class="{ 'is-invalid': this.email_unavailable }" name="email"
                                    value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Password</label>
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password" required
                                    autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Confirmation Password</label>
                                <input id="password-confirm" type="password"
                                    class="form-control @error('password_confirmation') is-invalid @enderror"
                                    name="password_confirmation" required autocomplete="new-password">
                                @error('password_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-success btn-block mt-4"
                                :disabled="this.email_unavailable">Sign Up Now</button>
                            <a href="{{ route('login') }}" class="btn btn-signup btn-block mt-2">Back to Sign In</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('addon-script')
    <script src="/vendor/vue/vue.js"></script>
    <script src="https://unpkg.com/vue-toasted"></script>
    <script src="https://unpkg.com/axios@1.1.2/dist/axios.min.js"></script>
    <script>
        Vue.use(Toasted);

        var register = new Vue({
            el: "#register",
            mounted() {
                AOS.init();

            },
            methods: {
                checkForEmailAvailability: function() {
                    var self = this;
                    axios.get('{{ route('api-register-check') }}', {
                            params: {
                                email: this.email
                            }
                        })
                        .then(function(response) {
                            if (response.data == 'Available') {
                                self.$toasted.show(
                                    "Email anda tersedia! Silahkan lanjut langkah selanjutnya!", {
                                        position: "top-center",
                                        className: "rounded",
                                        duration: 1000,
                                    }
                                );
                                self.email_unavailable = false;
                            } else {
                                self.$toasted.error(
                                    "Maaf, tampaknya email sudah terdaftar pada sistem kami.", {
                                        position: "top-center",
                                        className: "rounded",
                                        duration: 1000,
                                    }
                                );
                                self.email_unavailable = true;
                            }
                            // handle success
                            console.log(response.data);
                        })
                }
            },
            data() {
                return {
                    name: "",
                    phone_number: "",
                    email: "",
                    password: "",
                    email_unavailable: false
                }
            },
        });
    </script>
    <script src="/script/navbar-scroll.js"></script>
@endpush
