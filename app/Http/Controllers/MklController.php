<?php

namespace App\Http\Controllers;

use App\Models\mkl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

/**
 * MklController - Controller untuk mengelola data MKL (Multimoda Kemasan Logistik)
 *
 * Controller ini mengatur semua operasi CRUD untuk data MKL termasuk:
 * - Dashboard statistics (chart data)
 * - CRUD operations (Create, Read, Update, Delete)
 * - File management (upload KTP & NPWP)
 * - API endpoints untuk DataTables dan modal
 *
 * @author Your Team
 * @version 1.0
 */
class MklController extends Controller
{
    /**
     * Mendapatkan statistik penggunaan MTKI Payment untuk dashboard
     *
     * Method ini menghitung total MKL yang menggunakan dan tidak menggunakan MTKI Payment
     * Digunakan untuk pie chart di dashboard
     *
     * @return \Illuminate\Http\JsonResponse
     * @route GET /admin/mkl/payment-stats
     */
    public function getMTKIPaymentStats()
    {
        // Menghitung jumlah MKL berdasarkan penggunaan MTKI Payment
        $stats = [
            'using_mtki' => mkl::where('menggunakan_mtki_payment', 'YA')->count(),
            'not_using_mtki' => mkl::where('menggunakan_mtki_payment', 'TIDAK')->count(),
        ];

        // Mengembalikan data dalam format JSON untuk Chart.js
        return response()->json($stats);
    }

    /**
     * Mendapatkan statistik alasan tidak menggunakan MTKI Payment
     *
     * Method ini mengelompokkan dan menghitung alasan-alasan mengapa MKL
     * tidak menggunakan MTKI Payment untuk bar chart di dashboard
     *
     * @return \Illuminate\Http\JsonResponse
     * @route GET /admin/mkl/reason-stats
     */
    public function getMTKIReasonStats()
    {
        // Query untuk mendapatkan alasan dan jumlahnya
        $reasons = mkl::where('menggunakan_mtki_payment', 'TIDAK')
            ->select('alasan_tidak_menggunakan_mtki_payment')
            ->selectRaw('COUNT(*) as count') // Menghitung jumlah per alasan
            ->groupBy('alasan_tidak_menggunakan_mtki_payment') // Mengelompokkan berdasarkan alasan
            ->get();

        return response()->json($reasons);
    }

    /**
     * Mendapatkan data MKL yang difilter berdasarkan penggunaan MTKI
     *
     * Method ini digunakan untuk modal di dashboard yang menampilkan
     * data MKL berdasarkan filter "Ya" atau "Tidak" menggunakan MTKI
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @route GET /admin/mkl/filter-data
     */
    public function getFilteredData(Request $request)
    {
        // Mendapatkan parameter filter dari request
        $menggunakanMTKI = $request->input('menggunakan_mtki');

        // Query data berdasarkan filter dengan kolom yang diperlukan
        $data = mkl::where('menggunakan_mtki_payment', $menggunakanMTKI)
                   ->select([
                       'nik', 'nama_pribadi', 'nama_mkl', 'nama_pt_mkl',
                       'email_kantor', 'no_telepon_kantor', 'status_aktif',
                       'alasan_tidak_menggunakan_mtki_payment'
                   ])
                   ->orderBy('nama_pribadi') // Mengurutkan berdasarkan nama
                   ->get();

        // Mengembalikan data dalam format yang sesuai untuk DataTables
        return response()->json([
            'data' => $data,
            'total' => $data->count()
        ]);
    }

    /**
     * Mendapatkan total jumlah semua data MKL
     *
     * @return \Illuminate\Http\JsonResponse
     * @route GET /admin/mkl/total
     */
    public function getTotalMKL()
    {
        $total = mkl::count();
        return response()->json($total);
    }

    /**
     * Mendapatkan total MKL berdasarkan penggunaan MTKI Payment
     *
     * @param bool $isPenggunaan - true untuk yang menggunakan, false untuk yang tidak
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTotalPenggunaanMTKI($isPenggunaan = true)
    {
        $total = mkl::where('menggunakan_mtki_payment', $isPenggunaan ? 'YA' : 'TIDAK')->count();
        return response()->json($total);
    }

    /**
     * Mendapatkan data MKL berdasarkan alasan tidak menggunakan MTKI
     *
     * Method ini digunakan untuk modal yang menampilkan data MKL
     * berdasarkan alasan tertentu yang diklik dari bar chart
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @route GET /admin/mkl/data-by-reason
     */
    public function getDataByReason(Request $request)
    {
        // Mendapatkan parameter alasan dari request
        $alasan = $request->input('alasan');

        // Query data berdasarkan alasan tertentu
        $data = mkl::where('menggunakan_mtki_payment', 'TIDAK')
                   ->where('alasan_tidak_menggunakan_mtki_payment', $alasan)
                   ->select([
                       'nik', 'nama_pribadi', 'nama_mkl', 'nama_pt_mkl',
                       'email_kantor', 'no_telepon_kantor', 'status_aktif',
                       'alasan_tidak_menggunakan_mtki_payment'
                   ])
                   ->orderBy('nama_pribadi') // Mengurutkan berdasarkan nama
                   ->get();

        // Mengembalikan data dalam format yang sesuai untuk DataTables
        return response()->json([
            'data' => $data,
            'total' => $data->count(),
            'alasan' => $alasan
        ]);
    }

    /**
     * Menampilkan daftar semua data MKL dalam DataTables
     *
     * Method ini menangani 2 jenis request:
     * 1. AJAX request: Mengembalikan data untuk DataTables
     * 2. Normal request: Menampilkan halaman index
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     * @route GET /admin/mkl
     */
    public function index()
    {
        // Jika request berasal dari AJAX (DataTables)
        if (request()->ajax()) {
            // Membuat query untuk semua data MKL
            $query = mkl::query();

            // Menggunakan Yajra DataTables untuk server-side processing
            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    // Membuat dropdown action button untuk setiap row
                    return '
                        <div class="btn-group">
                            <button type="button" class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown" aria-expanded="false">
                                Action
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="' . route('admin.mkl.edit', $item->nik) . '">Edit</a>
                                <form action="' . route('admin.mkl.destroy', $item->nik) . '" method="POST">
                                    ' . method_field('delete') . csrf_field() . '
                                    <button type="submit" class="dropdown-item text-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                    ';
                })
                ->rawColumns(['action']) // Kolom yang berisi HTML raw
                ->make(true); // Generate response untuk DataTables
        }

        // Jika request normal, tampilkan halaman index
        return view('admin.mkl.index');
    }

    /**
     * Menampilkan form untuk membuat data MKL baru
     *
     * @return \Illuminate\Http\Response
     * @route GET /admin/mkl/create
     */
    public function create()
    {
        return view('admin.mkl.create');
    }

    /**
     * Menyimpan data MKL baru ke database
     *
     * Method ini menangani:
     * 1. Validasi input data
     * 2. Upload file KTP dan NPWP
     * 3. Penyimpanan data ke database
     * 4. Error handling
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @route POST /admin/mkl
     */
    public function store(Request $request)
    {
        try {
            // Validasi input dengan aturan yang ketat
            $validatedData = $request->validate([
                'nik' => 'required|string|size:16|unique:mkls,nik', // NIK harus 16 digit dan unik
                'nama_pribadi' => 'required|string|max:255',
                'nama_mkl' => 'nullable|string|max:255',
                'nama_pt_mkl' => 'nullable|string|max:255',
                'no_telepon_pribadi' => 'nullable|string|max:20|regex:/^[0-9\-\+\(\)\s]+$/',
                'no_telepon_kantor' => 'nullable|string|max:20|regex:/^[0-9\-\+\(\)\s]+$/',
                'email_kantor' => 'nullable|email|max:255',
                'npwp_kantor' => 'nullable|string|size:15|regex:/^[0-9\.\-]+$/', // Format NPWP
                'menggunakan_mtki_payment' => 'required|in:YA,TIDAK',
                'alasan_tidak_menggunakan_mtki_payment' => 'required_if:menggunakan_mtki_payment,TIDAK|nullable|string', // Wajib jika tidak menggunakan MTKI
                'status_aktif' => 'required|in:0,1',
                'file_ktp' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048', // File KTP max 2MB
                'file_npwp' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048', // File NPWP max 2MB
            ]);

            // Handle upload file KTP
            if ($request->hasFile('file_ktp')) {
                // Simpan file ke storage/app/public/mkl/ktp/
                $ktpPath = $request->file('file_ktp')->store('mkl/ktp', 'public');
                $validatedData['file_ktp'] = $ktpPath;
            }

            // Handle upload file NPWP
            if ($request->hasFile('file_npwp')) {
                // Simpan file ke storage/app/public/mkl/npwp/
                $npwpPath = $request->file('file_npwp')->store('mkl/npwp', 'public');
                $validatedData['file_npwp'] = $npwpPath;
            }

            // Simpan data ke database menggunakan Mass Assignment
            mkl::create($validatedData);

            // Redirect dengan pesan sukses
            return redirect()->route('admin.mkl.index')
                ->with('success', 'MKL berhasil ditambahkan');

        } catch (\Exception $e) {
            // Tangani error dan redirect dengan pesan error
            return redirect()->route('admin.mkl.index')
                ->with('error', 'Gagal menambahkan MKL: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan detail data MKL tertentu
     *
     * Method ini belum diimplementasi karena tidak ada view detail
     * Bisa digunakan untuk menampilkan halaman detail MKL di masa depan
     *
     * @param \App\Models\mkl $mkl - Model MKL yang di-inject otomatis berdasarkan route parameter
     * @return \Illuminate\Http\Response
     * @route GET /admin/mkl/{mkl}
     */
    public function show(mkl $mkl)
    {
        // TODO: Implementasi halaman detail MKL
        // return view('admin.mkl.show', compact('mkl'));
    }

    /**
     * Menampilkan form untuk mengedit data MKL
     *
     * Laravel Route Model Binding otomatis akan mencari MKL berdasarkan NIK
     * dan meng-inject model ke parameter $mkl
     *
     * @param \App\Models\mkl $mkl - Model MKL yang akan diedit
     * @return \Illuminate\Http\Response
     * @route GET /admin/mkl/{mkl}/edit
     */
    public function edit(mkl $mkl)
    {
        // Mengirim data MKL ke view edit form
        return view('admin.mkl.edit', compact('mkl'));
    }

    /**
     * Memperbarui data MKL yang sudah ada
     *
     * Method ini menangani:
     * 1. Validasi input (dengan pengecualian untuk data yang sedang diedit)
     * 2. Update file KTP dan NPWP (optional)
     * 3. Hapus file lama jika ada file baru
     * 4. Update data di database
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\mkl $mkl - Model MKL yang akan diupdate
     * @return \Illuminate\Http\RedirectResponse
     * @route PUT /admin/mkl/{mkl}
     */
    public function update(Request $request, mkl $mkl)
    {
        try {
            // Validasi input dengan pengecualian untuk data yang sedang diedit
            $validatedData = $request->validate([
                'nama_pribadi' => 'required|string|max:255',
                'nama_mkl' => 'nullable|string|max:255',
                'nama_pt_mkl' => 'nullable|string|max:255',
                'no_telepon_pribadi' => 'nullable|string|max:20|regex:/^[0-9\-\+\(\)\s]+$/',
                'no_telepon_kantor' => 'nullable|string|max:20|regex:/^[0-9\-\+\(\)\s]+$/',
                'email_kantor' => 'nullable|email|max:255',
                'npwp_kantor' => 'nullable|string|size:15|regex:/^[0-9\.\-]+$/', // Format NPWP
                'menggunakan_mtki_payment' => 'required|in:YA,TIDAK',
                'alasan_tidak_menggunakan_mtki_payment' => 'required_if:menggunakan_mtki_payment,TIDAK|nullable|string',
                'status_aktif' => 'required|in:0,1',
                // File bersifat optional saat update
                'file_ktp' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
                'file_npwp' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            ]);

            // Handle update file KTP jika ada file baru
            if ($request->hasFile('file_ktp')) {
                // Hapus file lama jika ada
                Storage::disk('public')->delete($mkl->file_ktp);
                // Upload file baru
                $ktpPath = $request->file('file_ktp')->store('mkl/ktp', 'public');
                $validatedData['file_ktp'] = $ktpPath;
            }

            // Handle update file NPWP jika ada file baru
            if ($request->hasFile('file_npwp')) {
                // Hapus file lama jika ada
                Storage::disk('public')->delete($mkl->file_npwp);
                // Upload file baru
                $npwpPath = $request->file('file_npwp')->store('mkl/npwp', 'public');
                $validatedData['file_npwp'] = $npwpPath;
            }

            // Update data menggunakan Mass Assignment
            $mkl->update($validatedData);

            // Redirect dengan pesan sukses
            return redirect()->route('admin.mkl.index')
                ->with('success', 'MKL berhasil diperbarui');

        } catch (\Exception $e) {
            // Tangani error dan redirect dengan pesan error
            return redirect()->route('admin.mkl.index')
                ->with('error', 'Gagal memperbarui MKL: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus data MKL dari database dan file terkait
     *
     * Method ini menangani:
     * 1. Hapus file KTP dan NPWP dari storage
     * 2. Hapus data dari database
     * 3. Error handling jika gagal
     *
     * @param \App\Models\mkl $mkl - Model MKL yang akan dihapus
     * @return \Illuminate\Http\RedirectResponse
     * @route DELETE /admin/mkl/{mkl}
     */
    public function destroy(mkl $mkl)
    {
        try {
            // Hapus file KTP dan NPWP dari storage/app/public/
            Storage::disk('public')->delete([$mkl->file_ktp, $mkl->file_npwp]);

            // Hapus data dari database
            $mkl->delete();

            // Redirect dengan pesan sukses
            return redirect()->route('admin.mkl.index')
                ->with('success', 'MKL berhasil dihapus');

        } catch (\Exception $e) {
            // Tangani error dan redirect dengan pesan error
            return redirect()->route('admin.mkl.index')
                ->with('error', 'Gagal menghapus MKL: ' . $e->getMessage());
        }
    }
}
