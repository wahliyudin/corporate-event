@extends('layouts.app')

@section('content')
    <!-- Stats Section -->
    <section class="row g-4 mb-4 mt-2">
        <div class="col-12 col-md-3">
            <div class="bg-white rounded p-3 d-flex justify-content-between align-items-center">
                <div class="d-flex flex-column">
                    <div class="text-muted small">Total Events</div>
                    <div class="fs-3 fw-semibold text-primary">128</div>
                </div>
                <div>
                    <span class="avatar bg-primary">
                        <i class="bi bi-droplet fs-18"></i>
                    </span>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-3">
            <div class="bg-white rounded p-3 d-flex justify-content-between align-items-center">
                <div class="d-flex flex-column">
                    <div class="text-muted small">Upcoming This Month</div>
                    <div class="fs-3 fw-semibold text-success">22</div>
                </div>
                <div>
                    <span class="avatar bg-success">
                        <i class="bi bi-droplet fs-18"></i>
                    </span>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-3">
            <div class="bg-white rounded p-3 d-flex justify-content-between align-items-center">
                <div class="d-flex flex-column">
                    <div class="text-muted small">CSR Activities</div>
                    <div class="fs-3 fw-semibold text-primary">14</div>
                </div>
                <div>
                    <span class="avatar bg-primary">
                        <i class="bi bi-droplet fs-18"></i>
                    </span>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-3">
            <div class="bg-white rounded p-3 d-flex justify-content-between align-items-center">
                <div class="d-flex flex-column">
                    <div class="text-muted small">Pending Approvals</div>
                    <div class="fs-3 fw-semibold text-danger">3</div>
                </div>
                <div>
                    <span class="avatar bg-danger">
                        <i class="bi bi-droplet fs-18"></i>
                    </span>
                </div>
            </div>
        </div>
    </section>

    <!-- Charts Section -->
    <section class="row g-4 mb-4">
        <div class="col-12 col-md-6">
            <div class="bg-white rounded p-3">
                <h6 class="fw-semibold mb-3">Event Categories</h6>
                <img src="https://via.placeholder.com/400x200?text=Category+Chart" class="img-fluid rounded"
                    alt="Category Chart">
            </div>
        </div>

        <div class="col-12 col-md-6">
            <div class="bg-white rounded p-3">
                <h6 class="fw-semibold mb-3">Events per Company</h6>
                <img src="https://via.placeholder.com/400x200?text=Company+Chart" class="img-fluid rounded"
                    alt="Company Chart">
            </div>
        </div>
    </section>

    <!-- Table Section -->
    <section class="bg-white rounded p-3">
        <h6 class="fw-semibold mb-3">Upcoming Events</h6>

        <div class="table-responsive">
            <table class="table table-bordered table-sm align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Date</th>
                        <th>Event</th>
                        <th>Company</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>20 Mar 2025</td>
                        <td>Annual Townhall</td>
                        <td>Holding</td>
                        <td>Internal Engagement</td>
                        <td class="text-success">Confirmed</td>
                        <td class="text-center">
                            <button class="btn btn-link text-primary btn-sm p-0 me-2">Edit</button>
                            <button class="btn btn-link text-danger btn-sm p-0">Delete</button>
                        </td>
                    </tr>

                    <tr>
                        <td>5 Apr 2025</td>
                        <td>CSR Beach Cleanup</td>
                        <td>Subsidiary A</td>
                        <td>CSR & Community</td>
                        <td class="text-warning">Planned</td>
                        <td class="text-center">
                            <button class="btn btn-link text-primary btn-sm p-0 me-2">Edit</button>
                            <button class="btn btn-link text-danger btn-sm p-0">Delete</button>
                        </td>
                    </tr>

                    <tr>
                        <td>12 Apr 2025</td>
                        <td>Leadership Training</td>
                        <td>Subsidiary C</td>
                        <td>Training & Leadership</td>
                        <td class="text-success">Confirmed</td>
                        <td class="text-center">
                            <button class="btn btn-link text-primary btn-sm p-0 me-2">Edit</button>
                            <button class="btn btn-link text-danger btn-sm p-0">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
@endsection
