@extends('Layouts.admin')

@section('title')
    لوحة التحكم
@endsection

@section('content')
    <main role="main" class="main-content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="row align-items-center mb-2">
                        <div class="col">
                            <h2 class="h5 page-title">مرحبا بك !</h2>
                        </div>
                        <div class="col-auto">
                            <form class="form-inline">
                                <div class="form-group d-none d-lg-inline">
                                    <label for="reportrange" class="sr-only">Date Ranges</label>
                                    <div id="reportrange" class="px-2 py-2 text-muted">
                                        <span class="small"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-sm"><span
                                            class="fe fe-refresh-ccw fe-16 text-muted"></span></button>
                                    <button type="button" class="btn btn-sm mr-2"><span
                                            class="fe fe-filter fe-16 text-muted"></span></button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- widgets -->
                    <div class="row my-4">

                        <div class="col-md-3">
                            <div class="card shadow mb-4">
                                <div class="card-body bg-danger">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <small class="text-muted mb-1">معاملات المدربين</small>
                                            <h3 class="card-title mb-0">{{App\Models\Absence::count()}}</h3>

                                        </div>
                                        <div class="col-4 text-right">
                                            <span class="sparkline inlineline"></span>
                                        </div>
                                    </div> <!-- /. row -->
                                </div> <!-- /. card-body -->
                            </div> <!-- /. card -->
                        </div> <!-- /. col -->

                        <div class="col-md-3">
                            <div class="card shadow mb-4">
                                <div class="card-body bg-warning">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <small class="mb-1">معاملات الإداريين</small>
                                            <h3 class="card-title mb-0">{{App\Models\EmployeeAbsence::count()}}</h3>

                                        </div>
                                        <div class="col-4 text-right">
                                            <span class="sparkline inlinepie"></span>
                                        </div>
                                    </div> <!-- /. row -->
                                </div> <!-- /. card-body -->
                            </div> <!-- /. card -->
                        </div> <!-- /. col -->

                        <div class="col-md-3">
                            <div class="card shadow mb-4">
                                <div class="card-body bg-primary-light">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <small class="mb-1"> اشعارات الحسم</small>
                                            <h3 class="card-title mb-0">{{App\Models\Messages::where('type', 'notification')->count()}}</h3>

                                        </div>
                                        <div class="col-4 text-right">
                                            <span class="sparkline inlinebar"></span>
                                        </div>
                                    </div> <!-- /. row -->
                                </div> <!-- /. card-body -->
                            </div> <!-- /. card -->
                        </div> <!-- /. col -->

                        <div class="col-md-3">
                            <div class="card shadow mb-4">
                                <div class="card-body bg-info">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <small class="mb-1"> قرارات الحسم</small>
                                            <h3 class="card-title mb-0">{{App\Models\Messages::where('type', 'decision')->count()}}</h3>

                                        </div>
                                        <div class="col-4 text-right">
                                            <span class="sparkline inlinebar"></span>
                                        </div>
                                    </div> <!-- /. row -->
                                </div> <!-- /. card-body -->
                            </div> <!-- /. card -->
                        </div> <!-- /. col -->
                    </div> <!-- end section -->




                    <div class="my-3 p-3 card shadow">
                        <h3 class="my-3">أحدث الاحصائيات</h3>

                        <div class="row my-4">
                            <div class="col-md-6 mb-4">
                                <div class="card shadow">
                                    <div class="card-header">
                                        <strong class="card-title mb-0">إحصائيات معاملات المدربين</strong>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="pieChartjs" width="400" height="300"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="card shadow">
                                    <div class="card-header">
                                        <strong class="card-title mb-0">إحصائيات معاملات الاداريين</strong>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="areaChartjs" width="400" height="300"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>









                    <!-- linechart -->
                    <div class="my-4">
                        <div id="lineChart"></div>
                    </div>

                </div> <!-- /.col -->
            </div> <!-- .row -->

            <footer>
                <div class="container bg-secondary-dark p-2">
                    <div class="row d-flex justify-content-center">
                        <div class="align-items-center">
                            <h5> جميع الحقوق محفوظة &copy; 2024</h5>
                        </div>
                    </div>
                </div>
            </footer>

        </div> <!-- .container-fluid -->
    </main> <!-- main -->
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <script>
        // Function to fetch data from the backend and update the chart
        function updateChart(chartId, url) {
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    const chart = new Chart(document.getElementById(chartId), {
                        type: 'pie', // Change chart type as per your requirement
                        data: {
                            labels: data.labels,
                            datasets: [{
                                label: 'Absence',
                                data: data.values,
                                backgroundColor: data.colors,
                            }]
                        },
                        options: {
                            responsive: true,
                        }
                    });
                })
                .catch(error => console.error('Error fetching data:', error));
        }

        function updateChartLine(chartId, url) {
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    const chartData = {
                        labels: data.labels,
                        datasets: data.datasets.map(dataset => ({
                            label: dataset.label,
                            data: dataset.data,
                            backgroundColor: dataset.backgroundColor,
                            borderColor: dataset.borderColor,
                            borderWidth: dataset.borderWidth,
                            fill: dataset.fill,
                        }))
                    };

                    const chartOptions = {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    };

                    const chart = new Chart(document.getElementById(chartId), {
                        type: 'line', // Change chart type as per your requirement
                        data: chartData,
                        options: chartOptions
                    });
                })
                .catch(error => console.error('Error fetching data:', error));
        }

        // Call the function to update the charts
        updateChart('pieChartjs', 'admin/absence/teachers');
        updateChartLine('lineChart', 'admin/absence/employees');
    </script>
@endsection
