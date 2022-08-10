@extends('layouts.main')

@section('content')
<div class="auth-wrapper align-items-stretch aut-bg-img">
    <div class="flex-grow-1">
        <div class="h-100 d-md-flex align-items-center auth-side-img">
            <div class="col-sm-10 auth-content w-auto">
                <img src="{{ asset('assets/images/auth/auth-logo.png') }}" alt="" class="img-fluid">
                <h1 class="text-white my-4">Welcome Back!</h1>
                <h4 class="text-white font-weight-normal">Signin to your account and get explore the<br>Alatan's Working Support Application.</h4>
            </div>
        </div>
        <div class="auth-side-form">
            <form method="post" action="{{ route('login') }}" class="auth-content">
                @csrf
                <input type="hidden" id="latitude" name="latitude">
                <input type="hidden" id="longitude" name="longitude">
                <img src="{{ asset('assets/images/auth/auth-logo-dark.png') }}" alt="" class="img-fluid mb-4 d-block d-xl-none d-lg-none">
                <h3 class="mb-3 f-w-400">Signin</h3>
                @if(Session::has('errors'))
                <span class="mb-3 text-white badge badge-danger">
                    {{ Session::get('errors')->first('email') }}
                </span>
                @endif
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="feather icon-mail"></i></span>
                    </div>
                    <input type="email" name="email" class="form-control has-error" placeholder="Email address" value="{{ old('email') }}">
                </div>
                <div class="input-group mb-4">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="feather icon-lock"></i></span>
                    </div>
                    <input type="password" name="password" class="form-control" placeholder="Password">
                </div>
                <div class="form-group text-left mt-2">
                    <div class="checkbox checkbox-primary d-inline">
                        <input type="checkbox" name="remember" id="checkbox-p-1" checked="">
                        <label for="checkbox-p-1" class="cr">Save credentials</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-block btn-primary mb-0">Signin</button>
                <!-- <div class="text-center">
                    <p class="mb-2 mt-4 text-muted">Forgot password? <a href="#" class="f-w-400">Reset</a></p>
                    <p class="mb-0 text-muted">Don’t have an account? <a href="{{ route('register') }}" class="f-w-400">Signup</a></p>
                </div> -->
            </form>
        </div>
    </div>
</div>
@endsection

@section('custom-script')
<script>
    if (localStorage.getItem('latitude') == null || localStorage.getItem('longitude') == null) {
        Swal.fire('Lokasi tidak ditemukan', 'Mohon aktifkan pelacakan lokasi untuk menggunakan aplikasi', 'error').then(function() {
            window.location.reload();
        });
    } else {
        let latitude = localStorage.getItem('latitude');
        let longitude = localStorage.getItem('longitude');
        $('#latitude').val(latitude);
        $('#longitude').val(longitude);
    }
</script>
@endsection