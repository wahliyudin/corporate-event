@extends('layouts.auth')

@section('content')
    <div class="card custom-card mt-3">
        <div class="card-body">
            <p class="h5 fw-semibold mb-2 text-center">Sign Up</p>
            <p class="mb-4 text-muted op-7 fw-normal text-center">Create your account</p>

            <form id="formRegister">
                <div class="row gy-3">
                    <div class="col-xl-12">
                        <label for="name" class="form-label text-default">Name</label>
                        <input id="name" type="text" value="User" class="form-control form-control-lg"
                            name="name" required autocomplete="name" autofocus>
                    </div>
                    <div class="col-xl-12">
                        <label for="email" class="form-label text-default">Email</label>
                        <input id="email" type="email" value="user@gmail.com" class="form-control form-control-lg"
                            name="email" required autocomplete="email">
                    </div>
                    <div class="col-xl-12">
                        <label for="password" class="form-label text-default">Password</label>
                        <div class="input-group">
                            <input id="password" type="password" value="1234567890" class="form-control form-control-lg"
                                name="password" required autocomplete="new-password">
                            <button class="btn btn-light" type="button" onclick="createpassword('password',this)"
                                id="button-addon2"><i class="ri-eye-off-line align-middle"></i></button>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <label for="password-confirm" class="form-label text-default">Confirm Password</label>
                        <div class="input-group">
                            <input id="password-confirm" type="password" value="1234567890"
                                class="form-control form-control-lg" name="password_confirmation" required
                                autocomplete="new-password">
                            <button class="btn btn-light" type="button" onclick="createpassword('password-confirm',this)"
                                id="button-addon2"><i class="ri-eye-off-line align-middle"></i></button>
                        </div>
                    </div>
                    <div class="col-xl-12 d-grid mt-2">
                        <button type="button" id="btnSubmit" class="btn btn-lg btn-primary">
                            <span class="indicator-label">
                                <div class="d-flex align-items-center justify-content-center gap-2">
                                    <span>Sign Up</span>
                                </div>
                            </span>
                            <span class="indicator-progress">
                                <span class="spinner-border spinner-border-sm align-middle"></span>
                                <span class="ms-2">Please wait...</span>
                            </span>
                        </button>
                    </div>
                </div>
                <div class="text-center">
                    <p class="fs-12 text-muted mt-3">
                        Already have an account?
                        <a href="{{ route('login') }}" class="text-primary">Sign In</a>
                    </p>
                </div>
            </form>

        </div>
    </div>
@endsection

@push('js')
    @vite(['resources/js/pages/auth/register.js'])
@endpush
