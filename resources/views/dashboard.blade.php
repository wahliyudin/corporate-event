<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Result Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-light">
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Event Result Dashboard</h1>
            <div>
                <button class="btn btn-primary me-2">Download Summary PDF</button>
                <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#eventDetailModal">View
                    Sample Event</button>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted">Total Events (YTD)</h6>
                        <h3 class="card-title text-primary">128</h3>
                        <p class="text-muted mb-0">Completed: 110</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted">Participants (YTD)</h6>
                        <h3 class="card-title text-success">7,540</h3>
                        <p class="text-muted mb-0">Avg / event: 68</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted">Avg Satisfaction</h6>
                        <h3 class="card-title text-warning">4.5 / 5</h3>
                        <p class="text-muted mb-0">Based on feedback forms</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted">Reports Pending</h6>
                        <h3 class="card-title text-danger">7</h3>
                        <p class="text-muted mb-0">Awaiting photos or summary</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts -->
        <div class="row g-4 mb-5">
            <div class="col-lg-8">
                <div class="card shadow-sm p-3">
                    <h6>Participants per Month</h6>
                    <canvas id="lineChart"></canvas>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card shadow-sm p-3">
                    <h6>Events by Category</h6>
                    <canvas id="barChart"></canvas>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card shadow-sm p-3">
                    <h6>Share by Company</h6>
                    <canvas id="pieChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Completed Events List -->
        <div class="card shadow-sm mb-5">
            <div class="card-body">
                <h5 class="card-title">Completed Events</h5>
                <p class="text-muted">Showing last 12 completed events</p>
                <div class="list-group">
                    <a href="#" class="list-group-item list-group-item-action" data-bs-toggle="modal"
                        data-bs-target="#eventDetailModal">
                        Leadership Development Workshop - 12 Oct 2025 • Subsidiary 2 • Training & Leadership
                    </a>
                </div>
            </div>
        </div>

        <!-- Event Detail Modal -->
        <div class="modal fade" id="eventDetailModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Leadership Development Workshop — Report</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <img src="/placeholder-poster.jpg" class="img-fluid rounded mb-3" alt="Poster">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Summary</h6>
                                <p>This workshop aimed to develop mid-level leaders through experiential learning, case
                                    studies, and role-play.</p>
                                <h6>Files</h6>
                                <ul>
                                    <li>Event Photos (ZIP) — 42 files</li>
                                    <li>Post-event Report (PDF) — 12 pages</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h6>Key Metrics</h6>
                                <ul>
                                    <li>Participants: 96</li>
                                    <li>Avg Satisfaction: 4.7</li>
                                    <li>Follow-up Actions: Mentoring program</li>
                                </ul>
                                <h6>Gallery Preview</h6>
                                <div class="row g-2">
                                    <div class="col-4"><img src="/photo1.jpg" class="img-fluid rounded"></div>
                                    <div class="col-4"><img src="/photo2.jpg" class="img-fluid rounded"></div>
                                    <div class="col-4"><img src="/photo3.jpg" class="img-fluid rounded"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success">Save Changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Charts.js sample initialization
        const lineCtx = document.getElementById('lineChart').getContext('2d');
        new Chart(lineCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Participants',
                    data: [120, 95, 210, 180, 230, 150, 190, 240, 200, 220, 160, 140],
                    borderColor: '#4F46E5',
                    fill: false,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top'
                    }
                }
            }
        });

        const barCtx = document.getElementById('barChart').getContext('2d');
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: ['Branding', 'CSR', 'Internal', 'Forum', 'Training', 'Religious'],
                datasets: [{
                    label: 'Events',
                    data: [18, 14, 32, 8, 22, 12],
                    backgroundColor: '#059669'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        const pieCtx = document.getElementById('pieChart').getContext('2d');
        new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: ['Holding', 'Sub A', 'Sub B', 'Sub C', 'Sub D'],
                datasets: [{
                    data: [45, 20, 15, 12, 8],
                    backgroundColor: ['#4F46E5', '#059669', '#F59E0B', '#FB7185', '#6B7280']
                }]
            },
            options: {
                responsive: true
            }
        });
    </script>
</body>

</html>
