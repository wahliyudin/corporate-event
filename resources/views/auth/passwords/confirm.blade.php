@extends('layouts.auth')

@section('content')
    <div class="card custom-card">
        <div class="card-body p-5">
            <p class="h5 fw-semibold mb-2 text-center">Confirm Password</p>
            <p class="mb-4 text-muted op-7 fw-normal text-center">
                Please confirm your password before continuing.
            </p>
            {{-- password/confirm --}}
            <form id="formConfirmPassword">
                <div class="row gy-3">
                    <div class="col-xl-12">
                        <label for="password" class="form-label text-default d-block">
                            Password
                            @if (Route::has('password.request'))
                                <a class="float-end text-danger" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                        </label>

                        <div class="input-group">
                            <input id="password" type="password" class="form-control form-control-lg" name="password"
                                required autocomplete="current-password">
                            <button class="btn btn-light" type="button" onclick="createpassword('password',this)"
                                id="button-addon2"><i class="ri-eye-off-line align-middle"></i></button>
                        </div>
                    </div>
                    <div class="col-xl-12 d-grid mt-2">
                        <button type="button" id="btnSubmit" class="btn btn-lg btn-primary">
                            <span class="indicator-label">
                                <div class="d-flex align-items-center justify-content-center gap-2">
                                    <span>Confirm Password</span>
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
        </div>
    </div>
@endsection

@push('js')
    @vite(['resources/js/pages/auth/confirm.js'])
@endpush
