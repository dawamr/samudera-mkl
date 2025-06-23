<div class="row">
    @role('admin')
        <div class="col-lg-4 col-4">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $user }}</h3>
                    <p>Total Users</p>
                </div>
                <div class="icon">
                    <i class="fa fa-users"></i>
                </div>
                <a href="{{ route('admin.user.index') }}" class="small-box-footer">View <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-4 col-4">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $category }}</h3>
                    <p>Total Data MKL</p>
                </div>
                <div class="icon">
                    <i class="fas fa-list-alt"></i>
                </div>
                <a href="{{ route('admin.mkl.index') }}" class="small-box-footer">View <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-4 col-4">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $category }}</h3>
                    <p>Total Pengguna MTKI<p>
                </div>
                <div class="icon">
                    <i class="fas fa-list-alt"></i>
                </div>
                <a href="{{ route('admin.mkl.index') }}" class="small-box-footer">View <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

            <div class="col-md-6 col-12">
                <div class="card" style="max-height: 400px;height: 400px;">
                    <div class="card-header">
                        <h3 class="card-title">Penggunaan MTKI Payment</h3>
                    </div>
                    <div class="card-body d-flex justify-content-center align-items-center">
                        <canvas id="mtkiPaymentChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="card" style="max-height: 400px;height: 400px;">
                    <div class="card-header">
                        <h3 class="card-title">Alasan Tidak Menggunakan MTKI Payment</h3>
                    </div>
                    <div class="card-body d-flex justify-content-center align-items-center">
                        <canvas id="mtkiReasonChart"></canvas>
                    </div>
                </div>
            </div>

        @section('js')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // MTKI Payment Usage Chart
            fetch('{{ route("admin.mkl.payment.stats") }}')
                .then(response => response.json())
                .then(data => {
                    const ctx = document.getElementById('mtkiPaymentChart');
                    new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: ['Menggunakan MTKI', 'Tidak Menggunakan MTKI'],
                            datasets: [{
                                data: [data.using_mtki, data.not_using_mtki],
                                backgroundColor: ['#28a745', '#dc3545']
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'bottom'
                                }
                            }
                        }
                    });
                });

            // MTKI Reason Chart
            fetch('{{ route("admin.mkl.reason.stats") }}')
                .then(response => response.json())
                .then(data => {
                    const ctx = document.getElementById('mtkiReasonChart');
                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: data.map(item => item.alasan_tidak_menggunakan_mtki_payment),
                            datasets: [{
                                label: 'Jumlah',
                                data: data.map(item => item.count),
                                backgroundColor: '#17a2b8'
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    display: false
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        stepSize: 1
                                    }
                                }
                            }
                        }
                    });
                });
        </script>
        @endsection
    @endrole
</div>
