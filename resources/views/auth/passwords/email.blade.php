@extends('layouts.auth')

@section('content')
    <div class="card custom-card">
        <div class="card-body p-5">
            <p class="h5 fw-semibold mb-2 text-center">Forgot Password</p>
            <p class="mb-4 text-muted op-7 fw-normal text-center">Enter your email to receive reset instructions</p>
            {{-- password/email --}}
            <form id="formForgotPassword">
                <div class="row gy-3">
                    <div class="col-xl-12">
                        <label for="email" class="form-label text-default">Email</label>
                        <input id="email" type="email" class="form-control form-control-lg" name="email"
                            value="user@gmail.com" required autocomplete="email" autofocus>
                    </div>
                    <div class="col-xl-12 d-grid mt-2">
                        <button type="button" id="btnSubmit" class="btn btn-lg btn-primary">
                            <span class="indicator-label">
                                <div class="d-flex align-items-center justify-content-center gap-2">
                                    <span>Send Password Reset Link</span>
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
    @vite(['resources/js/pages/auth/email.js'])
@endpush
