<?php

namespace App\Http\Controllers;

use App\Models\PenjualanModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Models\BarangModel;

class PenjualanController extends Controller
{
    public function index()
    {
        $activeMenu = 'penjualan';
        $breadcrumb = (object) [
            'title' => 'Data Penjualan',
            'list' => ['Home', 'Penjualan']
        ];

        $user = UserModel::select('user_id', 'nama')->get();
    $barang = BarangModel::select('barang_id', 'barang_nama')->orderBy('barang_nama')->get();

    return view('penjualan.index', compact('activeMenu', 'breadcrumb', 'user', 'barang'));
    }

    public function list(Request $request)
    {
        $penjualan = PenjualanModel::with('user')
            ->select('penjualan_id', 'user_id', 'pembeli', 'penjualan_kode', 'penjualan_tanggal', 'created_at', 'updated_at');

        if ($request->filled('filter_user')) {
            $penjualan->where('user_id', $request->filter_user);
        }

        return DataTables::of($penjualan)
            ->addIndexColumn()
            ->addColumn('user_nama', function ($penjualan) {
                return $penjualan->user->nama;
            })
            ->addColumn('penjualan_tanggal', function ($penjualan) {
                return date('d-m-Y', strtotime($penjualan->penjualan_tanggal));
            })
            ->addColumn('aksi', function ($penjualan) {
                $btn = '<button onclick="modalAction(\''.url('/penjualan/'.$penjualan->penjualan_id.'/show_ajax').'\')" 
                        class="btn btn-info btn-sm mr-1">
                        <i class="fas fa-eye"></i>
                    </button>';
                $btn .= '<button onclick="modalAction(\''.url('/penjualan/'.$penjualan->penjualan_id.'/edit_ajax').'\')" 
                        class="btn btn-warning btn-sm mr-1">
                        <i class="fas fa-edit"></i>
                    </button>';
                $btn .= '<button onclick="modalAction(\''.url('/penjualan/'.$penjualan->penjualan_id.'/delete_ajax').'\')" 
                        class="btn btn-danger btn-sm">
                        <i class="fas fa-trash"></i>
                    </button>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create_ajax()
    {
        $barang = BarangModel::select('barang_id', 'barang_nama')->orderBy('barang_nama')->get();
        $user = UserModel::select('user_id', 'nama')->orderBy('nama')->get();
    
        return view('penjualan.form', compact('barang', 'user'));
    }

    public function store_ajax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:m_user,user_id',
            'pembeli' => 'required|string|max:255',
            'penjualan_kode' => 'required|string|max:255|unique:t_penjualan,penjualan_kode',
            'penjualan_tanggal' => 'required|date',
            'barang_id' => 'required|integer|exists:t_barang,barang_id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
                'message' => 'Validasi gagal'
            ], 422);
        }

        PenjualanModel::create([
            'user_id' => $request->user_id,
            'pembeli' => $request->pembeli,
            'penjualan_kode' => $request->penjualan_kode,
            'penjualan_tanggal' => $request->penjualan_tanggal
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Data penjualan berhasil disimpan'
        ]);
    }

    public function edit_ajax($id)
    {
        $penjualan = PenjualanModel::findOrFail($id);
        $user = UserModel::all(['user_id', 'nama']);
        return view('penjualan.edit_ajax', compact('penjualan', 'user'));
    }

    public function update_ajax(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:m_user,user_id',
            'pembeli' => 'required|string|max:255',
            'penjualan_kode' => 'required|string|max:255|unique:t_penjualan,penjualan_kode,' . $id . ',penjualan_id',
            'penjualan_tanggal' => 'required|date'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
                'message' => 'Validasi gagal'
            ], 422);
        }

        $penjualan = PenjualanModel::findOrFail($id);
        $penjualan->update([
            'user_id' => $request->user_id,
            'pembeli' => $request->pembeli,
            'penjualan_kode' => $request->penjualan_kode,
            'penjualan_tanggal' => $request->penjualan_tanggal
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Data penjualan berhasil diperbarui'
        ]);
    }

    public function confirm_ajax($id)
    {
        $penjualan = PenjualanModel::findOrFail($id);
        return view('penjualan.confirm_ajax', compact('penjualan'));
    }

    public function delete_ajax(Request $request, $id)
    {
        $penjualan = PenjualanModel::findOrFail($id);
        $penjualan->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data penjualan berhasil dihapus'
        ]);
    }
}
