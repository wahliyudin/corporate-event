@extends('layouts.auth')

@section('content')
    <div class="card custom-card">
        <div class="card-body p-5">
            <p class="h5 fw-semibold mb-2 text-center">Reset Password</p>
            <p class="mb-4 text-muted op-7 fw-normal text-center">Enter your new password</p>
            {{-- password/reset --}}
            <form id="formReset">
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="row gy-3">
                    <div class="col-xl-12">
                        <label for="email" class="form-label text-default">Email</label>
                        <input id="email" type="email" class="form-control form-control-lg" name="email"
                            value="{{ $email }}" required autocomplete="email" autofocus>
                    </div>
                    <div class="col-xl-12">
                        <label for="password" class="form-label text-default d-block">New Password</label>
                        <div class="input-group">
                            <input id="password" type="password" class="form-control form-control-lg" name="password"
                                required autocomplete="new-password">

                            <button class="btn btn-light" type="button" onclick="createpassword('password', this)">
                                <i class="ri-eye-off-line align-middle"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <label for="password-confirm" class="form-label text-default d-block">Confirm Password</label>
                        <div class="input-group">
                            <input id="password-confirm" type="password" class="form-control form-control-lg"
                                name="password_confirmation" required autocomplete="new-password">

                            <button class="btn btn-light" type="button" onclick="createpassword('password-confirm', this)">
                                <i class="ri-eye-off-line align-middle"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-xl-12 d-grid mt-2">
                        <button type="button" id="btnSubmit" class="btn btn-lg btn-primary">
                            <span class="indicator-label">
                                <div class="d-flex align-items-center justify-content-center gap-2">
                                    <span>Reset Password</span>
                                </div>
                            </span>
                            <span class="indicator-progress">
                                <span class="spinner-border spinner-border-sm align-middle"></span>
                                <span class="ms-2">Please wait...</span>
                            </span>
                        </button>
                    </div>
                </div>
            </form>

            <div class="text-center">
                <p class="fs-12 text-muted mt-3">
                    Remember your password?
                    <a href="{{ route('login') }}" class="text-primary">Sign In</a>
                </p>
            </div>
        </div>
    </div>
@endsection

@push('js')
    @vite(['resources/js/pages/auth/reset.js'])
@endpush
