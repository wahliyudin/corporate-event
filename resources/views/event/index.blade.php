@extends('layouts.app')

@section('content')
    <div class="row mt-4">
        <div class="col-xl-3">
            <div class="card custom-card">
                <div class="card-header d-grid">
                    <button id="btnCreateEvent" class="btn btn-primary-light btn-wave">
                        <i class="ri-add-line align-middle me-1 fw-semibold d-inline-block"></i>
                        <span>Create New Event</span>
                    </button>
                </div>
                <div class="card-body p-0">
                    <div id="event-categories" class="border-bottom p-3">
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
            <div class="card custom-card">
                <div class="card-body">
                    <h5 class="card-title mb-3">Upcoming Events</h5>

                    <ul class="list-unstyled" id="eventList">
                        <!-- Event Item 1 -->
                        <li class="border rounded p-3 mb-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="fw-semibold">Annual Townhall</div>
                                    <div class="text-muted small">
                                        Mar 20, 2025 — Jakarta Convention Center — PIC: CorpCom / HR
                                    </div>
                                    <div class="small mt-2">
                                        Townhall Q1 — company update and awards. Status:
                                        <span class="fw-semibold">Confirmed</span>
                                    </div>
                                </div>

                                <div class="text-end ">
                                    <div class="text-muted small">Holding</div>

                                    <div class="mt-2">
                                        <button class="btn btn-link btn-sm p-0 me-2">Edit</button>
                                        <button class="btn btn-link text-danger btn-sm p-0">Delete</button>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <!-- Event Item 2 -->
                        <li class="border rounded p-3 mb-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="fw-semibold">CSR Beach Cleanup</div>
                                    <div class="text-muted small">
                                        Apr 5, 2025 — Anyer Beach — PIC: Sustainability Team
                                    </div>
                                    <div class="small mt-2">
                                        CSR activity with local community. Status:
                                        <span class="fw-semibold">Planned</span>
                                    </div>
                                </div>

                                <div class="text-end">
                                    <div class="text-muted small">Subsidiary A</div>

                                    <div class="mt-2">
                                        <button class="btn btn-link btn-sm p-0 me-2">Edit</button>
                                        <button class="btn btn-link text-danger btn-sm p-0">Delete</button>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div class="text-center mt-2">
                        <a href="#" class="btn btn-link small">
                            View All
                            <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
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
                        <input type="hidden" name="id">
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="title" class="form-label">Event Title</label>
                                <input name="title" required placeholder="Event title" class="form-control" />
                            </div>

                            <div class="col-md-6 start-date-container">
                                <label for="start_date" class="form-label">Start Date</label>
                                <div class="input-group ">
                                    <input name="start_date" type="text" class="form-control"
                                        placeholder="Start Date" />
                                    <span class="input-group-text">WIB</span>
                                </div>
                            </div>

                            <div class="col-md-6 end-date-container">
                                <label for="end_date" class="form-label">End Date</label>
                                <div class="input-group">
                                    <input name="end_date" type="text" class="form-control"
                                        placeholder="Start Date" />
                                    <span class="input-group-text">WIB</span>
                                </div>
                            </div>

                            <div class="col-md-6 company-container">
                                <label for="company" class="form-label">Company</label>
                                <select name="company" class="form-select"></select>
                            </div>

                            <div class="col-md-6 category-container">
                                <label for="category" class="form-label">Category</label>
                                <select name="category" class="form-select"></select>
                            </div>

                            <div class="col-12">
                                <label for="location" class="form-label">Location</label>
                                <div id="location_toolbar"></div>
                                <div id="location" class="border border-2" style="min-height: 80px;"></div>
                            </div>

                            <div class="col-md-6">
                                <label for="pic" class="form-label">PIC / Penanggung Jawab</label>
                                <input name="pic" placeholder="PIC / Penanggung Jawab" class="form-control" />
                            </div>

                            <div class="col-md-6 status-container">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="" selected disabled>- Select -</option>
                                    @foreach (App\Enums\Event\Status::cases() as $status)
                                        <option value="{{ $status->value }}">
                                            {{ $status->label() }}
                                        </option>
                                    @endforeach
                                </select>
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
    <div class="modal fade" id="modalDetailEvent" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content shadow-lg border-0 rounded-4">
                <div class="modal-header border-0 pb-0">
                    <div>
                        <h5 class="modal-title fw-bold" id="detailEventTitle"></h5>
                        <small class="text-muted">Detail Event</small>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body pt-2">
                    <input type="hidden" name="id" id="detailEventId">
                    <div class="p-3 rounded-4 border bg-light">
                        <div class="d-flex align-items-start mb-3">
                            <div class="me-3 text-primary">
                                <i class="fa-regular fa-calendar-days fa-xl"></i>
                            </div>
                            <div>
                                <div class="fw-semibold text-muted mb-1">Date & Time</div>
                                <div class="fw-bold" id="detailEventDate">10 Nov 2025, 08:00 - 10:00 WIB</div>
                            </div>
                        </div>

                        <div class="d-flex align-items-start mb-3">
                            <div class="me-3 text-success">
                                <i class="fa-solid fa-building fa-xl"></i>
                            </div>
                            <div>
                                <div class="fw-semibold text-muted mb-1">Company</div>
                                <div class="fw-bold" id="detailEventCompany">Tech Corp</div>
                            </div>
                        </div>

                        <div class="d-flex align-items-start mb-3">
                            <div class="me-3 text-warning">
                                <i class="fa-solid fa-tags fa-xl"></i>
                            </div>
                            <div>
                                <div class="fw-semibold text-muted mb-1">Category</div>
                                <div class="fw-bold" id="detailEventCategory">Meeting</div>
                            </div>
                        </div>

                        <div class="d-flex align-items-start mb-3">
                            <div class="me-3 text-info">
                                <i class="fa-solid fa-user-tie fa-xl"></i>
                            </div>
                            <div>
                                <div class="fw-semibold text-muted mb-1">PIC</div>
                                <div class="fw-bold" id="detailEventPIC">John Doe</div>
                            </div>
                        </div>

                        <div class="d-flex align-items-start mb-3">
                            <div class="me-3 text-secondary">
                                <i class="fa-solid fa-circle-check fa-xl"></i>
                            </div>
                            <div>
                                <div class="fw-semibold text-muted mb-1">Status</div>
                                <div class="fw-bold" id="detailEventStatus">Approved</div>
                            </div>
                        </div>

                        <div class="d-flex align-items-start">
                            <div class="me-3 text-dark">
                                <i class="fa-solid fa-align-left fa-xl"></i>
                            </div>
                            <div>
                                <div class="fw-semibold text-muted mb-1">Description</div>
                                <div class="fw-bold" id="detailEventDescription"></div>
                            </div>
                        </div>

                        <div class="d-flex align-items-start mb-3">
                            <div class="me-3 text-danger">
                                <i class="fa-solid fa-location-dot fa-xl"></i>
                            </div>
                            <div>
                                <div class="fw-semibold text-muted mb-1">Location</div>
                                <div class="fw-bold" id="detailEventLocation"></div>
                            </div>
                        </div>

                    </div>

                </div>

                <!-- FOOTER -->
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-danger" id="btnDelete">Delete</button>
                    <button type="button" class="btn btn-primary" id="btnEdit">Edit</button>
                    <button class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>
@endpush

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/fullcalendar/main.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/select2/select2.min.css') }}">
    <style>
        #event-categories .fc-event {
            cursor: move;
            margin: 0 0 0.4rem 0;
            padding: 0.375rem 0.75rem;
            font-size: 0.75rem;
            border-radius: 0.35rem;
        }

        .modal {
            transform: none !important;
        }

        #full-calendar-activity {
            min-height: 34rem !important;
            max-height: 34rem !important;
        }
    </style>
@endpush

@push('js')
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/libs/jquery-validate/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/libs/moment/moment.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.43/moment-timezone-with-data.min.js"></script>
    <script src="{{ asset('assets/libs/fullcalendar/main.min.js') }}"></script>
    <script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('assets/libs/ckeditor/ckeditor-document.bundle.js') }}"></script>
    @vite(['resources/js/pages/event/index.js'])
@endpush
