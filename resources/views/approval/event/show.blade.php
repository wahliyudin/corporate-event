@extends('layouts.app')

@section('title', 'Event')

@section('page-header')
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <h1 class="page-title fw-semibold fs-18 mb-0">Event</h1>
        <div class="ms-md-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('events.index') }}">Event</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detail</li>
                </ol>
            </nav>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h5 class="mb-1">{{ $event->title }}</h5>

                            <div class="d-flex flex-wrap align-items-center gap-2">
                                <span class="badge bg-light text-dark border">{{ $event->company }}</span>
                                <span class="badge"
                                    style="background: {{ $event->category_color }};">{{ $event->category }}</span>
                                {!! $event->status->badge() !!}
                            </div>
                        </div>
                        <div class="text-end small text-muted">
                            Event ID: <strong>{{ $event->number }}</strong>
                        </div>
                    </div>
                    <hr>
                    <div class="row gy-3">
                        <div class="col-md-4">
                            <div class="small text-muted">Date & Time</div>
                            <div class="fw-semibold">{{ $event->date }}</div>
                        </div>

                        <div class="col-md-4">
                            <div class="small text-muted">PIC</div>
                            <div class="fw-semibold">{{ $event->pic }}</div>
                        </div>

                        <div class="col-md-4">
                            <div class="small text-muted">Created</div>
                            <div class="fw-semibold">{{ $event->created_at }}</div>
                        </div>
                    </div>

                    <hr>

                    <h6><u>Location</u></h6>
                    {!! $event->location !!}

                    <hr>

                    <h6><u>Description</u></h6>
                    {!! $event->description !!}
                </div>
            </div>
            <div class="d-flex justify-content-end align-items-center btn-sm gap-2">
                <button type="button" id="btn-reject" data-key="{{ $event->key }}" class="btn btn-danger">
                    <span class="indicator-label">
                        <div class="d-flex align-items-center gap-2">
                            <i class="ri-close-circle-fill fs-6"></i>
                            <span>Reject</span>
                        </div>
                    </span>
                    <span class="indicator-progress">
                        <span class="spinner-border spinner-border-sm align-middle"></span>
                        <span class="ms-2">Please wait...</span>
                    </span>
                </button>
                <button type="button" id="btn-approve" data-key="{{ $event->key }}" class="btn btn-success">
                    <span class="indicator-label">
                        <div class="d-flex align-items-center gap-2">
                            <i class="ri-checkbox-circle-fill fs-6"></i>
                            <span>Approve</span>
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
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">
@endpush

@push('js')
    @vite(['resources/js/pages/approval/event/show.js'])
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
@endpush
