<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Event Detail</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        .timeline li {
            border-left: 2px solid #e9ecef;
            padding-left: .75rem;
            margin-bottom: .75rem;
        }
    </style>
</head>

<body class="bg-light">

    <div class="container py-5">
        <div class="row g-4">

            <!-- MAIN CONTENT -->
            <div class="col-lg-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-body p-4">

                        <!-- Header -->
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h1 class="h4 mb-1">Annual Townhall Meeting</h1>

                                <div class="d-flex flex-wrap align-items-center gap-2">
                                    <span class="badge bg-light text-dark border">Holding Company</span>
                                    <span class="badge" style="background:#4f46e5;">Internal Engagement</span>
                                    <span class="badge bg-success">Confirmed</span>
                                </div>

                                <div class="text-muted small mt-2">
                                    Annual gathering for corporate updates and employee awards.
                                </div>
                            </div>

                            <div class="text-end small text-muted">
                                Event ID: <strong>EVT-2025-001</strong>
                            </div>
                        </div>

                        <hr>

                        <!-- Info -->
                        <div class="row gy-3">
                            <div class="col-md-6">
                                <div class="small text-muted">Date & Time</div>
                                <div class="fw-semibold">Thu, 20 Mar 2025 • 09:00 - 16:00</div>
                            </div>

                            <div class="col-md-6">
                                <div class="small text-muted">Location</div>
                                <div class="fw-semibold">Jakarta Convention Center</div>
                            </div>

                            <div class="col-md-6">
                                <div class="small text-muted">PIC</div>
                                <div class="fw-semibold">CorpCom / HR</div>
                            </div>

                            <div class="col-md-6">
                                <div class="small text-muted">Created</div>
                                <div class="small text-muted">3 days ago</div>
                            </div>
                        </div>

                        <hr>

                        <!-- Description -->
                        <h6>Description</h6>
                        <p class="text-muted">
                            This townhall provides company-wide updates, performance highlights,
                            leadership messages, and employee award recognitions.
                        </p>

                        <!-- Attachments -->
                        <h6 class="mt-4">Attachments</h6>
                        <ul class="list-unstyled">
                            <li><a href="#" class="link-primary"><i class="bi bi-paperclip"></i> Agenda.pdf</a>
                            </li>
                            <li><a href="#" class="link-primary"><i class="bi bi-paperclip"></i> Floor
                                    Layout.png</a></li>
                        </ul>

                        <hr>

                        <!-- Activity -->
                        <h6>Activity</h6>
                        <ul class="timeline list-unstyled">
                            <li>
                                <div class="fw-semibold">Admin</div>
                                <div class="small text-muted">Updated event schedule</div>
                                <div class="small text-muted">2 hours ago</div>
                            </li>
                            <li>
                                <div class="fw-semibold">HR Team</div>
                                <div class="small text-muted">Added new attachments</div>
                                <div class="small text-muted">Yesterday</div>
                            </li>
                        </ul>

                    </div>
                </div>
            </div>

            <!-- RIGHT PANEL -->
            <div class="col-lg-4">

                <!-- Action buttons -->
                <div class="card shadow-sm mb-4">
                    <div class="card-body p-3">
                        <div class="d-grid gap-2 mb-3">
                            <button class="btn btn-primary">
                                <i class="bi bi-pencil me-1"></i> Edit Event
                            </button>

                            <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modalDelete">
                                <i class="bi bi-trash me-1"></i> Delete
                            </button>

                            <div class="btn-group">
                                <button class="btn btn-outline-secondary"><i class="bi bi-google"></i></button>
                                <button class="btn btn-outline-secondary"><i class="bi bi-microsoft"></i></button>
                                <button class="btn btn-outline-secondary"><i class="bi bi-download"></i></button>
                            </div>

                            <button class="btn btn-outline-secondary">
                                <i class="bi bi-link-45deg me-1"></i> Copy Link
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Attendees -->
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h6>Attendees</h6>
                        <ul class="list-unstyled mb-0">
                            <li class="d-flex align-items-center mb-2">
                                <img src="https://ui-avatars.com/api/?name=John+Doe" class="rounded-circle me-2"
                                    width="40">
                                <div>
                                    <div class="fw-semibold">John Doe</div>
                                    <div class="text-muted small">john@example.com</div>
                                </div>
                                <div class="ms-auto small text-muted">Confirmed</div>
                            </li>

                            <li class="d-flex align-items-center mb-2">
                                <img src="https://ui-avatars.com/api/?name=Sarah+Tan" class="rounded-circle me-2"
                                    width="40">
                                <div>
                                    <div class="fw-semibold">Sarah Tan</div>
                                    <div class="text-muted small">sarah@example.com</div>
                                </div>
                                <div class="ms-auto small text-muted">Invited</div>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Map -->
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h6>Location Map</h6>
                        <iframe
                            src="https://maps.google.com/maps?q=jakarta%20convention%20center&t=&z=13&ie=UTF8&iwloc=&output=embed"
                            width="100%" height="200" style="border:0;" allowfullscreen="">
                        </iframe>
                    </div>
                </div>

            </div>

        </div>
    </div>


    <!-- Delete Modal -->
    <div class="modal fade" id="modalDelete" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this event? This action cannot be undone.
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
