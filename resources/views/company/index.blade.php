@extends('layouts.app')

@section('title', 'Company')

@section('page-header')
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <h1 class="page-title fw-semibold fs-18 mb-0">Company</h1>
        <div class="ms-md-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Master</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Company</li>
                </ol>
            </nav>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Data Company
                    </div>
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <button class="btn btn-primary label-btn" data-bs-toggle="modal" data-bs-target="#formModal">
                            <i class="ri-add-line label-btn-icon me-2"></i>
                            Add Data
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-bordered text-nowrap w-100">
                            <thead>
                                <tr>
                                    <th style="max-width: 5rem;">Actions</th>
                                    <th>Company Name</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('modal')
    <div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="formModalLabel1">Form Company</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form">
                        <input type="hidden" name="id">
                        <div class="row gap-2">
                            <div class="col-12">
                                <label for="name" class="form-label">Company Name</label>
                                <input type="text" required class="form-control" id="name" name="name">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="btn-save" class="btn btn-primary">
                        <span class="indicator-label">
                            <div class="d-flex align-items-center gap-2">
                                <i class="ri-edit-line"></i>
                                <span>Save changes</span>
                            </div>
                        </span>
                        <span class="indicator-progress">
                            <span class="spinner-border spinner-border-sm align-middle"></span>
                            <span class="ms-2">Please wait...</span>
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/libs/datatable/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/datatable/css/responsive.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">
@endpush

@push('js')
    @vite(['resources/js/pages/company/index.js'])
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/libs/jquery-validate/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatable/js/dataTables.responsive.min.js') }}"></script>
@endpush
