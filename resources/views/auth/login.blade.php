@extends('layouts.auth')

@section('content')
    <div class="card custom-card">
        <div class="card-body p-5">
            <p class="h5 fw-semibold mb-2 text-center">Sign In</p>
            <p class="mb-4 text-muted op-7 fw-normal text-center">Welcome back Jhon !</p>
            <div class="row gy-3">
                <div class="col-xl-12">
                    <label for="email" class="form-label text-default">Email</label>
                    <input type="email" class="form-control form-control-lg" id="email" autocomplete="email" autofocus>
                </div>
                <div class="col-xl-12 mb-2">
                    <label for="password" class="form-label text-default d-block">Password
                        @if (Route::has('password.request'))
                            <a class="float-end text-danger" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        @endif
                    </label>
                    <div class="input-group">
                        <input type="password" class="form-control form-control-lg" id="password" placeholder="password">
                        <button class="btn btn-light" type="button" onclick="createpassword('password',this)"
                            id="button-addon2"><i class="ri-eye-off-line align-middle"></i></button>
                    </div>
                </div>
                <div class="col-xl-12 d-grid mt-2">
                    <button class="btn btn-lg btn-primary">Sign In</button>
                </div>
            </div>
            <div class="text-center">
                <p class="fs-12 text-muted mt-3">Dont have an account? <a href="{{ route('register') }}"
                        class="text-primary">Sign Up</a></p>
            </div>
        </div>
    </div>
@endsection
