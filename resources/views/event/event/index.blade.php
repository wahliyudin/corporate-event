@extends('layouts.app')

@section('title', 'Event')

@section('page-header')
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <h1 class="page-title fw-semibold fs-18 mb-0">Event</h1>
        <div class="ms-md-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item active" aria-current="page">Event</li>
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
                        Data Event
                    </div>
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <button class="btn btn-primary label-btn" data-bs-toggle="modal" data-bs-target="#formModal">
                            <i class="ri-add-line label-btn-icon me-2"></i>
                            Add Event
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-bordered text-nowrap w-100">
                            <thead>
                                <tr>
                                    <th style="max-width: 5rem;">Actions</th>
                                    <th>Number</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Company</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th style="min-width: 27rem;">Location</th>
                                    <th>Created At</th>
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
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="formModalLabel1">Form Event</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form">
                        <input type="hidden" name="id">
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="title" class="form-label">Event Title</label>
                                <input name="title" required placeholder="Event title" class="form-control" />
                            </div>

                            <div class="col-md-6 start-date-container">
                                <label for="start_date" class="form-label">Start Date</label>
                                <div class="input-group ">
                                    <input name="start_date" type="text" class="form-control" placeholder="Start Date" />
                                    <span class="input-group-text">WIB</span>
                                </div>
                            </div>

                            <div class="col-md-6 end-date-container">
                                <label for="end_date" class="form-label">End Date</label>
                                <div class="input-group">
                                    <input name="end_date" type="text" class="form-control" placeholder="Start Date" />
                                    <span class="input-group-text">WIB</span>
                                </div>
                            </div>

                            <div class="col-md-6 category-container">
                                <label for="category" class="form-label">Category</label>
                                <select name="category" class="form-select"></select>
                            </div>

                            <div class="col-md-6">
                                <label for="pic" class="form-label">PIC / Penanggung Jawab</label>
                                <input name="pic" placeholder="PIC / Penanggung Jawab" class="form-control" />
                            </div>

                            <div class="col-12">
                                <label for="location" class="form-label">Location</label>
                                <div id="location_toolbar"></div>
                                <div id="location" class="border border-2" style="min-height: 80px;"></div>
                            </div>

                            <div class="col-12">
                                <label for="description" class="form-label">Description</label>
                                <div id="description_toolbar"></div>
                                <div id="description" class="border border-2" style="min-height: 150px;"></div>
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
    <link rel="stylesheet" href="{{ asset('assets/libs/select2/select2.min.css') }}">
@endpush

@push('js')
    @vite(['resources/js/pages/event/event/index.js'])
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/libs/jquery-validate/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/libs/ckeditor/ckeditor-document.bundle.js') }}"></script>
    <script src="{{ asset('assets/libs/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
@endpush
