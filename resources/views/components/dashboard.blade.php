<div class="row">
    @role('admin')
        <div class="col-lg-3 col-6">
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
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $totalMKL }}</h3>
                    <p>Total Data EMKL</p>
                </div>
                <div class="icon">
                    <i class="fas fa-list-alt"></i>
                </div>
                <a href="{{ route('admin.mkl.index') }}" class="small-box-footer">View <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $menggunakanMTKI }}</h3>
                    <p>Menggunakan MTKI</p>
                </div>
                <div class="icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <a href="#" class="small-box-footer" data-toggle="modal" data-target="#modalMenggunakanMTKI">View <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $tidakMenggunakanMTKI }}</h3>
                    <p>Tidak Menggunakan MTKI</p>
                </div>
                <div class="icon">
                    <i class="fas fa-times-circle"></i>
                </div>
                <a href="#" class="small-box-footer" data-toggle="modal" data-target="#modalTidakMenggunakanMTKI">View <i
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

        <!-- Modal Menggunakan MTKI -->
        <div class="modal fade" id="modalMenggunakanMTKI" tabindex="-1" role="dialog" aria-labelledby="modalMenggunakanMTKILabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h4 class="modal-title" id="modalMenggunakanMTKILabel">
                            <i class="fas fa-check-circle"></i> Data MKL - Menggunakan MTKI Payment
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table id="tableMenggunakanMTKI" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>NIK</th>
                                        <th>Nama Pribadi</th>
                                        <th>Nama MKL</th>
                                        <th>Nama PT</th>
                                        <th>Email Kantor</th>
                                        <th>No. Telepon</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody id="dataMenggunakanMTKI">
                                    <!-- Data akan dimuat via AJAX -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <a href="{{ route('admin.mkl.index') }}" class="btn btn-warning">Lihat Semua Data</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Tidak Menggunakan MTKI -->
        <div class="modal fade" id="modalTidakMenggunakanMTKI" tabindex="-1" role="dialog" aria-labelledby="modalTidakMenggunakanMTKILabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h4 class="modal-title" id="modalTidakMenggunakanMTKILabel">
                            <i class="fas fa-times-circle"></i> Data MKL - Tidak Menggunakan MTKI Payment
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table id="tableTidakMenggunakanMTKI" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>NIK</th>
                                        <th>Nama Pribadi</th>
                                        <th>Nama MKL</th>
                                        <th>Nama PT</th>
                                        <th>Email Kantor</th>
                                        <th>No. Telepon</th>
                                        <th>Alasan Tidak Menggunakan</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody id="dataTidakMenggunakanMTKI">
                                    <!-- Data akan dimuat via AJAX -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <a href="{{ route('admin.mkl.index') }}" class="btn btn-danger">Lihat Semua Data</a>
                    </div>
                </div>
            </div>
        </div>

                        @push('scripts')
        <script>
            $(document).ready(function() {
                let tableMenggunakanMTKI, tableTidakMenggunakanMTKI;

                // Load data ketika modal dibuka
                $('#modalMenggunakanMTKI').on('show.bs.modal', function () {
                    if (!tableMenggunakanMTKI) {
                        loadMTKIDataTable('Ya');
                    }
                });

                $('#modalTidakMenggunakanMTKI').on('show.bs.modal', function () {
                    if (!tableTidakMenggunakanMTKI) {
                        loadMTKIDataTable('Tidak');
                    }
                });

                // Destroy DataTable ketika modal ditutup untuk refresh data
                $('#modalMenggunakanMTKI').on('hidden.bs.modal', function () {
                    if (tableMenggunakanMTKI) {
                        tableMenggunakanMTKI.destroy();
                        tableMenggunakanMTKI = null;
                    }
                });

                $('#modalTidakMenggunakanMTKI').on('hidden.bs.modal', function () {
                    if (tableTidakMenggunakanMTKI) {
                        tableTidakMenggunakanMTKI.destroy();
                        tableTidakMenggunakanMTKI = null;
                    }
                });

                function loadMTKIDataTable(jenisMTKI) {
                    const tableId = jenisMTKI === 'Ya' ? '#tableMenggunakanMTKI' : '#tableTidakMenggunakanMTKI';
                    const columns = jenisMTKI === 'Ya' ? [
                        { data: 'nik', name: 'nik' },
                        { data: 'nama_pribadi', name: 'nama_pribadi' },
                        { data: 'nama_mkl', name: 'nama_mkl' },
                        { data: 'nama_pt_mkl', name: 'nama_pt_mkl' },
                        { data: 'email_kantor', name: 'email_kantor' },
                        { data: 'no_telepon_kantor', name: 'no_telepon_kantor' },
                        {
                            data: 'status_aktif',
                            name: 'status_aktif',
                            render: function(data) {
                                return data === 'Ya'
                                    ? '<span class="badge badge-success">Aktif</span>'
                                    : '<span class="badge badge-secondary">Tidak Aktif</span>';
                            }
                        }
                    ] : [
                        { data: 'nik', name: 'nik' },
                        { data: 'nama_pribadi', name: 'nama_pribadi' },
                        { data: 'nama_mkl', name: 'nama_mkl' },
                        { data: 'nama_pt_mkl', name: 'nama_pt_mkl' },
                        { data: 'email_kantor', name: 'email_kantor' },
                        { data: 'no_telepon_kantor', name: 'no_telepon_kantor' },
                        {
                            data: 'alasan_tidak_menggunakan_mtki_payment',
                            name: 'alasan_tidak_menggunakan_mtki_payment',
                            render: function(data) {
                                return data || '-';
                            }
                        },
                        {
                            data: 'status_aktif',
                            name: 'status_aktif',
                            render: function(data) {
                                return data === 'Ya'
                                    ? '<span class="badge badge-success">Aktif</span>'
                                    : '<span class="badge badge-secondary">Tidak Aktif</span>';
                            }
                        }
                    ];

                    const dataTable = $(tableId).DataTable({
                        processing: true,
                        serverSide: false,
                        ajax: {
                            url: '{{ route("admin.mkl.filter.data") }}',
                            method: 'GET',
                            data: {
                                menggunakan_mtki: jenisMTKI,
                                _token: '{{ csrf_token() }}'
                            },
                            dataSrc: function(json) {
                                return json.data;
                            }
                        },
                        columns: columns,
                        language: {
                            processing: '<i class="fas fa-spinner fa-spin"></i> Memuat data...',
                            search: 'Pencarian:',
                            lengthMenu: 'Tampilkan _MENU_ data per halaman',
                            info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                            infoEmpty: 'Menampilkan 0 sampai 0 dari 0 data',
                            infoFiltered: '(disaring dari _MAX_ total data)',
                            loadingRecords: 'Memuat...',
                            zeroRecords: 'Tidak ada data yang cocok',
                            emptyTable: 'Tidak ada data tersedia',
                            paginate: {
                                first: 'Pertama',
                                last: 'Terakhir',
                                next: 'Selanjutnya',
                                previous: 'Sebelumnya'
                            }
                        },
                        pageLength: 10,
                        lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Semua"]],
                        order: [[1, 'asc']], // Sort by nama_pribadi
                        responsive: true,
                        scrollX: true,
                        dom: '<"row"<"col-sm-6"l><"col-sm-6"f>>rtip',
                        drawCallback: function() {
                            // Reinitialize tooltips or any other UI elements if needed
                        }
                    });

                    if (jenisMTKI === 'Ya') {
                        tableMenggunakanMTKI = dataTable;
                    } else {
                        tableTidakMenggunakanMTKI = dataTable;
                    }
                }
            });
        </script>
        @endpush

    @endrole
</div>
