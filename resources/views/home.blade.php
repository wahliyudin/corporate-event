@extends('layouts.app')

@section('content')
    <!-- Stats Section -->
    <section class="row g-4 mb-4 mt-2">
        <div class="col-12 col-md-{{ $hasAdmin ? 3 : 4 }}">
            <div class="bg-white rounded p-3 d-flex justify-content-between align-items-center">
                <div class="d-flex flex-column">
                    <div class="text-muted small">Total Events</div>
                    <div class="fs-3 fw-semibold text-primary">{{ $stats['total_events'] }}</div>
                </div>
                <div>
                    <span class="avatar bg-primary">
                        <i class="bi bi-calendar-event fs-18"></i>
                    </span>
                </div>
            </div>
        </div>

        @if (!$hasAdmin)
            <div class="col-12 col-md-4">
                <div class="bg-white rounded p-3 d-flex justify-content-between align-items-center">
                    <div class="d-flex flex-column">
                        <div class="text-muted small">Upcoming This Month</div>
                        <div class="fs-3 fw-semibold text-success">{{ $stats['upcoming_events'] }}</div>
                    </div>
                    <div>
                        <span class="avatar bg-success">
                            <i class="bi bi-calendar-event fs-18"></i>
                        </span>
                    </div>
                </div>
            </div>
        @endif

        <div class="col-12 col-md-{{ $hasAdmin ? 3 : 4 }}">
            <div class="bg-white rounded p-3 d-flex justify-content-between align-items-center">
                <div class="d-flex flex-column">
                    <div class="text-muted small">Total Users</div>
                    <div class="fs-3 fw-semibold text-secondary">{{ $stats['total_users'] }}</div>
                </div>
                <div>
                    <span class="avatar bg-secondary">
                        <i class="bi bi-people-fill fs-18"></i>
                    </span>
                </div>
            </div>
        </div>

        @if ($hasAdmin)
            <div class="col-12 col-md-3">
                <div class="bg-white rounded p-3 d-flex justify-content-between align-items-center">
                    <div class="d-flex flex-column">
                        <div class="text-muted small">Pending Event Approvals</div>
                        <div class="fs-3 fw-semibold text-danger">{{ $stats['pending_event_approvals'] }}</div>
                    </div>
                    <div>
                        <span class="avatar bg-danger">
                            <i class="bi bi-hourglass-split fs-18"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="bg-white rounded p-3 d-flex justify-content-between align-items-center">
                    <div class="d-flex flex-column">
                        <div class="text-muted small">Pending User Approvals</div>
                        <div class="fs-3 fw-semibold text-success">{{ $stats['pending_user_approvals'] }}</div>
                    </div>
                    <div>
                        <span class="avatar bg-success">
                            <i class="bi bi-calendar-event fs-18"></i>
                        </span>
                    </div>
                </div>
            </div>
        @endif
    </section>

    <!-- Charts Section -->
    <section class="row g-4 mb-4">
        <div class="col-12 col-md-6">
            <div class="bg-white rounded p-3">
                <h6 class="fw-semibold mb-3">Event Categories</h6>
                <div id="eventCategoriesChart"></div>
            </div>
        </div>

        <div class="col-12 col-md-6">
            <div class="bg-white rounded p-3">
                <h6 class="fw-semibold mb-3">Events per Company</h6>
                <div id="eventsCompanyChart"></div>
            </div>
        </div>
    </section>

    <!-- Table Section -->
    {{-- <section class="bg-white rounded p-3">
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
    </section> --}}
@endsection


@push('js')
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            // SAMPLE DATA - Bisa diganti dengan data dari DB
            const eventCategories = {
                labels: ["Seminar", "Workshop", "Training", "CSR", "Webinar"],
                values: [12, 7, 15, 9, 5]
            };

            const eventsPerCompany = {
                labels: ["Company A", "Company B", "Company C", "Company D"],
                values: [20, 12, 18, 9]
            };

            // Tinggi chart seragam
            const chartHeight = 320;


            // -------------------------------------------------
            // 1. EVENT CATEGORIES (Bar Chart)
            // -------------------------------------------------
            var optionsBar = {
                chart: {
                    type: 'bar',
                    height: 275,
                    toolbar: {
                        show: false
                    }
                },
                series: [{
                    name: 'Total Events',
                    data: eventCategories.values
                }],
                xaxis: {
                    categories: eventCategories.labels
                },
                plotOptions: {
                    bar: {
                        columnWidth: '45%',
                        borderRadius: 4
                    }
                },
                dataLabels: {
                    enabled: true
                }
            };

            var chartBar = new ApexCharts(document.querySelector("#eventCategoriesChart"), optionsBar);
            chartBar.render();


            // -------------------------------------------------
            // 2. EVENTS PER COMPANY (Donut Chart)
            // -------------------------------------------------
            var optionsDonut = {
                chart: {
                    type: 'donut',
                    height: chartHeight,
                    toolbar: {
                        show: false
                    } // <-- DISAMAKAN
                },
                series: eventsPerCompany.values,
                labels: eventsPerCompany.labels,
                legend: {
                    position: 'bottom'
                }
            };

            var chartDonut = new ApexCharts(document.querySelector("#eventsCompanyChart"), optionsDonut);
            chartDonut.render();

        });
    </script>
@endpush
