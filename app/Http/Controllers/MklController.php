<?php

namespace App\Http\Controllers;

use App\Models\mkl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class MklController extends Controller
{
    public function getMTKIPaymentStats()
    {
        $stats = [
            'using_mtki' => mkl::where('menggunakan_mtki_payment', true)->count(),
            'not_using_mtki' => mkl::where('menggunakan_mtki_payment', false)->count(),
        ];

        return response()->json($stats);
    }

    public function getMTKIReasonStats()
    {
        $reasons = mkl::where('menggunakan_mtki_payment', false)
            ->select('alasan_tidak_menggunakan_mtki_payment')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('alasan_tidak_menggunakan_mtki_payment')
            ->get();

        return response()->json($reasons);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = mkl::query();

            return DataTables::of($query)
                ->addColumn('action', function($item) {
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
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.mkl.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.mkl.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
            'nik' => 'required|unique:mkls,nik',
            'nama_pribadi' => 'required',
            'nama_mkl' => 'required',
            'nama_pt_mkl' => 'required',
            'no_telepon_pribadi' => 'required',
            'no_telepon_kantor' => 'required',
            'email_kantor' => 'required|email|unique:mkls,email_kantor',
            'npwp_kantor' => 'required|unique:mkls,npwp_kantor',
            'menggunakan_mtki_payment' => 'required|boolean',
            'alasan_tidak_menggunakan_mtki_payment' => 'required_if:menggunakan_mtki_payment,0',
            'status_aktif' => 'required|boolean',
            'file_ktp' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_npwp' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('file_ktp')) {
            $ktpPath = $request->file('file_ktp')->store('mkl/ktp', 'public');
            $validatedData['file_ktp'] = $ktpPath;
        }

        if ($request->hasFile('file_npwp')) {
            $npwpPath = $request->file('file_npwp')->store('mkl/npwp', 'public');
            $validatedData['file_npwp'] = $npwpPath;
        }

            mkl::create($validatedData);

            return redirect()->route('admin.mkl.index')
                ->with('success', 'MKL berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->route('admin.mkl.index')
                ->with('error', 'Gagal menambahkan MKL: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(mkl $mkl)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(mkl $mkl)
    {
        return view('admin.mkl.edit', compact('mkl'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, mkl $mkl)
    {
        try {
            $validatedData = $request->validate([
            'nama_pribadi' => 'required',
            'nama_mkl' => 'required',
            'nama_pt_mkl' => 'required',
            'no_telepon_pribadi' => 'required',
            'no_telepon_kantor' => 'required',
            'email_kantor' => 'required|email|unique:mkls,email_kantor,' . $mkl->nik . ',nik',
            'npwp_kantor' => 'required|unique:mkls,npwp_kantor,' . $mkl->nik . ',nik',
            'menggunakan_mtki_payment' => 'required|boolean',
            'alasan_tidak_menggunakan_mtki_payment' => 'required_if:menggunakan_mtki_payment,0',
            'status_aktif' => 'required|boolean',
            'file_ktp' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_npwp' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('file_ktp')) {
            Storage::disk('public')->delete($mkl->file_ktp);
            $ktpPath = $request->file('file_ktp')->store('mkl/ktp', 'public');
            $validatedData['file_ktp'] = $ktpPath;
        }

        if ($request->hasFile('file_npwp')) {
            Storage::disk('public')->delete($mkl->file_npwp);
            $npwpPath = $request->file('file_npwp')->store('mkl/npwp', 'public');
            $validatedData['file_npwp'] = $npwpPath;
        }

            $mkl->update($validatedData);

            return redirect()->route('admin.mkl.index')
                ->with('success', 'MKL berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->route('admin.mkl.index')
                ->with('error', 'Gagal memperbarui MKL: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(mkl $mkl)
    {
        try {
            Storage::disk('public')->delete([$mkl->file_ktp, $mkl->file_npwp]);
            $mkl->delete();

            return redirect()->route('admin.mkl.index')
                ->with('success', 'MKL berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('admin.mkl.index')
                ->with('error', 'Gagal menghapus MKL: ' . $e->getMessage());
        }
    }
}
