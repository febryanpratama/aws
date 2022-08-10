@extends('layouts.main')

@section('content')
<div class="auth-wrapper align-items-stretch aut-bg-img">
    <div class="flex-grow-1">
        <div class="h-100 d-md-flex align-items-center auth-side-img">
            <div class="col-sm-10 auth-content w-auto">
                <img src="{{ asset('assets/images/auth/auth-logo.png') }}" alt="" class="img-fluid">
                <h1 class="text-white my-4">Hi!</h1>
                <h4 class="text-white font-weight-normal">Register to get your account so you can explore the<br>Alatan's Working Support Application.</h4>
            </div>
        </div>
        <div class="auth-side-form">
            <form method="post" action="{{ route('register') }}" class="auth-content">
                @csrf
                <input type="hidden" id="latitude" name="latitude">
                <input type="hidden" id="longitude" name="longitude">
                <img src="{{ asset('assets/images/auth/auth-logo-dark.png') }}" alt="" class="img-fluid mb-4 d-block d-xl-none d-lg-none">
                <h3 class="mb-3 f-w-400">Register</h3>
                @if(Session::has('errors'))
                <span class="mb-3 text-white badge badge-danger">
                    {{ Session::get('errors')->first('email') }}
                </span>
                @endif
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="feather icon-user"></i></span>
                    </div>
                    <input type="text" name="name" class="form-control has-error" placeholder="Full Name" value="{{ old('name') }}">
                </div>
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
                <div class="input-group mb-4">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="feather icon-lock"></i></span>
                    </div>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password">
                </div>
                <button type="submit" class="btn btn-block btn-primary mb-0">Register</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('custom-scripts')
<script>
    if(localStorage.getItem('latitude') == null || localStorage.getItem('longitude') == null){
        Swal.fire('Lokasi tidak ditemukan','Mohon aktifkan pelacakan lokasi untuk menggunakan aplikasi','error').then(function(){
            window.location.reload();
        });
    }else{
        let latitude = localStorage.getItem('latitude');
        let longitude = localStorage.getItem('longitude');
        $('#latitude').val(latitude);
        $('#longitude').val(longitude);
    }
</script>
@endsection