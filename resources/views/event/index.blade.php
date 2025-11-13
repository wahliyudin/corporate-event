@extends('layouts.app')

@section('content')
    <div class="row mt-4">
        <div class="col-xl-3">
            <div class="card custom-card">
                <div class="card-header d-grid">
                    <button class="btn btn-primary-light btn-wave">
                        <i class="ri-add-line align-middle me-1 fw-semibold d-inline-block"></i>
                        <span>Create New Event</span>
                    </button>
                </div>
                <div class="card-body p-0">
                    <div id="external-events" class="border-bottom p-3">
                        <div
                            class="fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event bg-primary border border-primary">
                            <div class="fc-event-main">Calendar Events</div>
                        </div>
                        <div class="fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event bg-secondary border border-secondary"
                            data-class="bg-secondary">
                            <div class="fc-event-main">Birthday EVents</div>
                        </div>
                        <div class="fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event bg-success border border-success"
                            data-class="bg-success">
                            <div class="fc-event-main">Holiday Calendar</div>
                        </div>
                        <div class="fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event bg-info border border-info"
                            data-class="bg-info">
                            <div class="fc-event-main">Office Events</div>
                        </div>
                        <div class="fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event bg-warning border border-warning"
                            data-class="bg-warning">
                            <div class="fc-event-main">Other Events</div>
                        </div>
                        <div class="fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event bg-danger border border-danger"
                            data-class="bg-danger">
                            <div class="fc-event-main">Festival Events</div>
                        </div>
                        <div class="fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event bg-teal border border-teal"
                            data-class="bg-danger">
                            <div class="fc-event-main">Timeline Events</div>
                        </div>
                    </div>
                    <div class="p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <h6 class="fw-semibold">
                                Activity :
                            </h6>
                            <button class="btn btn-primary-light btn-sm btn-wave">View All</button>
                        </div>
                    </div>
                    <div class="p-3 border-bottom" id="full-calendar-activity">
                        <ul class="list-unstyled mb-0 fullcalendar-events-activity">
                            <li>
                                <div class="d-flex align-items-center justify-content-between flex-wrap">
                                    <p class="mb-1 fw-semibold">
                                        Monday, Jan 1,2023
                                    </p>
                                    <span class="badge bg-light text-default mb-1">12:00PM - 1:00PM</span>
                                </div>
                                <p class="mb-0 text-muted fs-12">
                                    Meeting with a client about new project requirement.
                                </p>
                            </li>
                            <li>
                                <div class="d-flex align-items-center justify-content-between flex-wrap">
                                    <p class="mb-1 fw-semibold">
                                        Thursday, Dec 29,2022
                                    </p>
                                    <span class="badge bg-success mb-1">Completed</span>
                                </div>
                                <p class="mb-0 text-muted fs-12">
                                    Birthday party of niha suka
                                </p>
                            </li>
                            <li>
                                <div class="d-flex align-items-center justify-content-between flex-wrap">
                                    <p class="mb-1 fw-semibold">
                                        Wednesday, Jan 3,2023
                                    </p>
                                    <span class="badge bg-warning-transparent mb-1">Reminder</span>
                                </div>
                                <p class="mb-0 text-muted fs-12">
                                    WOrk taget for new project is completing
                                </p>
                            </li>
                            <li>
                                <div class="d-flex align-items-center justify-content-between flex-wrap">
                                    <p class="mb-1 fw-semibold">
                                        Friday, Jan 20,2023
                                    </p>
                                    <span class="badge bg-light text-default mb-1">06:00PM -
                                        09:00PM</span>
                                </div>
                                <p class="mb-0 text-muted fs-12">
                                    Watch new movie with family
                                </p>
                            </li>
                            <li>
                                <div class="d-flex align-items-center justify-content-between flex-wrap">
                                    <p class="mb-1 fw-semibold">
                                        Saturday, Jan 07,2023
                                    </p>
                                    <span class="badge bg-danger-transparent mb-1">Due Date</span>
                                </div>
                                <p class="mb-0 text-muted fs-12">
                                    Last day to pay the electricity bill and water bill.need to check the
                                    bank details.
                                </p>
                            </li>
                        </ul>
                    </div>
                    <div class="p-3">
                        <img src="../assets/images/media/media-83.svg" alt="">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-9">
            <div class="card custom-card">
                <div class="card-body">
                    <div id='calendar-events'></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('modal')
    <div class="modal fade" id="modalFormEvent" tabindex="-1" aria-labelledby="modalFormEventLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="modalFormEventLabel">Add / Edit Event</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form id="eventForm">
                        <div class="row g-3">
                            <div class="col-12">
                                <input name="title" required placeholder="Event title" class="form-control" />
                            </div>

                            <div class="col-md-6 company-container">
                                <select name="company" class="form-select">
                                    <option value="holding">Holding</option>
                                    <option value="sub-a">Subsidiary A</option>
                                    <option value="sub-b">Subsidiary B</option>
                                    <option value="sub-c">Subsidiary C</option>
                                    <option value="sub-d">Subsidiary D</option>
                                </select>
                            </div>

                            <div class="col-md-6 category-container">
                                <select name="category" class="form-select">
                                    <option value="branding">Corporate Branding</option>
                                    <option value="csr">CSR & Community</option>
                                    <option value="internal">Internal Engagement</option>
                                    <option value="forum">Business & Innovation</option>
                                    <option value="training">Training & Leadership</option>
                                    <option value="religious">Religious / Holiday</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <input name="start_date" type="text" class="form-control" placeholder="Start Date" />
                            </div>

                            <div class="col-md-6">
                                <input name="end_date" type="text" class="form-control" placeholder="End Date" />
                            </div>

                            <div class="col-12">
                                <input name="location" placeholder="Location" class="form-control" />
                            </div>

                            <div class="col-md-6">
                                <input name="pic" placeholder="PIC / Penanggung Jawab" class="form-control" />
                            </div>

                            <div class="col-md-6 status-container">
                                <select name="status" class="form-select">
                                    <option>Planned</option>
                                    <option>Confirmed</option>
                                    <option>Tentative</option>
                                </select>
                            </div>

                            <div class="col-12">
                                <textarea name="description" placeholder="Description" rows="3" class="form-control"></textarea>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" id="btnCancel" class="btn btn-outline-secondary"
                        data-bs-dismiss="modal">Cancel</button>
                    <button type="button" id="btnSave" class="btn btn-primary">
                        <span class="indicator-label">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fa-regular fa-floppy-disk fs-16"></i>
                                <span>Save</span>
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
    <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/fullcalendar/main.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/select2/select2.min.css') }}">
@endpush

@push('js')
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/libs/jquery-validate/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/libs/fullcalendar/main.min.js') }}"></script>
    <script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
    @vite(['resources/js/pages/event/index.js'])
@endpush
