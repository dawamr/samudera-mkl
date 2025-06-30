<x-admin>
    @section('title','Data EMKL')
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Data EMKL</h3>
            <div class="card-tools">
                <a href="{{ route('admin.mkl.create') }}" class="btn btn-sm btn-info">Tambah EMKL</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="mklTable" style="width:100%">
                <thead>
                    <tr>
                        <th>NIK</th>
                        <th>Nama Pribadi</th>
                        <th>Nama EMKL</th>
                        <th>Nama PT EMKL</th>
                        <th>No. Telepon Pribadi</th>
                        <th>No. Telepon Kantor</th>
                        <th>Email Kantor</th>
                        <th>NPWP Kantor</th>
                        <th>MTKI Payment</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    @section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap4.min.css">
    @endsection

    @section('js')
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script>
        function confirmDelete(event) {
            event.preventDefault();
            if (confirm('Apakah Anda yakin ingin menghapus data EMKL ini?')) {
                event.target.closest('form').submit();
            }
        }

        $(function() {
            var table = $('#mklTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "{{ route('admin.mkl.index', [], true) }}",
                dom: 'Blfrtip',
                buttons: [
                    'copy',
                    'csv',
                    'excel',
                    {
                        extend: 'pdf',
                        orientation: 'landscape',
                        pageSize: 'LETTER',
                        title: 'Data EMKL',
                        exportOptions: {
                            columns: ':not(:last-child)' // Exclude action column
                        },
                        customize: function(doc) {
                            // Header styling
                            doc.styles.title = {
                                color: '#333',
                                fontSize: '12',
                                alignment: 'center',
                                margin: [0, 10, 10, 10]
                            };

                            // Table styling
                            doc.styles.tableHeader = {
                                bold: true,
                                fontSize: 8,
                                color: 'white',
                                fillColor: '#6c757d',
                                alignment: 'center'
                            };

                            doc.styles.tableBodyEven = {
                                fontSize: 7,
                                fillColor: '#f8f9fa'
                            };

                            doc.styles.tableBodyOdd = {
                                fontSize: 7
                            };

                            // Page margins
                            doc.pageMargins = [20, 40, 20, 30];

                            // Add export date in footer
                            doc.content.push({
                                text: 'Diekspor pada: ' + new Date().toLocaleDateString('id-ID', {
                                    year: 'numeric',
                                    month: 'long',
                                    day: 'numeric',
                                    hour: '2-digit',
                                    minute: '2-digit'
                                }),
                                style: 'footer',
                                alignment: 'right',
                                margin: [0, 10, 0, 0]
                            });

                            doc.styles.footer = {
                                fontSize: 7,
                                color: '#666'
                            };
                        }
                    },
                    {
                        extend: 'print',
                        title: 'Data EMKL',
                        exportOptions: {
                            columns: ':not(:last-child)' // Exclude action column
                        },
                        customize: function(win) {
                            $(win.document.body)
                                .css('font-size', '8pt')
                                .prepend(
                                    '<div style="text-align:center;"><h3>Data EMKL</h3><p>Dicetak pada: ' +
                                    new Date().toLocaleDateString('id-ID') + '</p></div>'
                                );

                            $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                        }
                    }
                ],
                pageLength: 10,
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                language: {
                    lengthMenu: "<br><b>Tampilkan _MENU_ data per halaman</b>",
                    search: "<b>Cari:</b>",
                    paginate: {
                        first: "<b>Pertama</b>",
                        last: "Terakhir",
                        next: "Selanjutnya",
                        previous: "Sebelumnya"
                    },
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                    infoFiltered: "(disaring dari _MAX_ total data)",
                    emptyTable: "Tidak ada data yang tersedia",
                    loadingRecords: "Memuat...",
                    processing: "Memproses...",
                    zeroRecords: "Tidak ada data yang cocok"
                },
                columns: [
                    {data: 'nik', name: 'nik'},
                    {data: 'nama_pribadi', name: 'nama_pribadi'},
                    {data: 'nama_mkl', name: 'nama_mkl'},
                    {data: 'nama_pt_mkl', name: 'nama_pt_mkl'},
                    {data: 'no_telepon_pribadi', name: 'no_telepon_pribadi'},
                    {data: 'no_telepon_kantor', name: 'no_telepon_kantor'},
                    {data: 'email_kantor', name: 'email_kantor'},
                    {data: 'npwp_kantor', name: 'npwp_kantor'},
                    {data: 'menggunakan_mtki_payment', name: 'menggunakan_mtki_payment'},
                    {data: 'status_aktif', name: 'status_aktif'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
        });
    </script>
    @endsection
</x-admin>
