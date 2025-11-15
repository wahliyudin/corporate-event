@extends('layouts.auth')

@section('content')
    <div class="card custom-card">
        <div class="card-body p-5">

            <p class="h5 fw-semibold mb-2 text-center">Verify Your Email</p>
            <p class="mb-4 text-muted op-7 fw-normal text-center">
                Before proceeding, please check your email for a verification link.
            </p>

            {{-- SUCCESS MESSAGE --}}
            @if (session('resent'))
                <div class="alert alert-success text-center" role="alert">
                    A fresh verification link has been sent to your email address.
                </div>
            @endif

            <p class="text-center text-muted mb-4">
                If you did not receive the email, you can request another link below.
            </p>

            {{-- RESEND BUTTON --}}
            <form method="POST" action="{{ route('verification.resend') }}" class="text-center">
                @csrf

                <button type="submit" class="btn btn-primary btn-lg w-100">
                    <span class="indicator-label">
                        <div class="d-flex align-items-center justify-content-center gap-2">
                            <span>Resend Verification Email</span>
                        </div>
                    </span>
                    <span class="indicator-progress">
                        <span class="spinner-border spinner-border-sm align-middle"></span>
                        <span class="ms-2">Please wait...</span>
                    </span>
                </button>
            </form>

            <div class="text-center mt-3">
                <a href="{{ route('login') }}" class="text-primary fs-12">
                    Back to Sign In
                </a>
            </div>

        </div>
    </div>
@endsection
