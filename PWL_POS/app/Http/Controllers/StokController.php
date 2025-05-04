<?php

namespace App\Http\Controllers;

use App\Models\StokModel;
use App\Models\BarangModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class StokController extends Controller
{
    public function index()
    {
        $activeMenu = 'stok';
        $breadcrumb = (object) [
            'title' => 'Data Stok',
            'list' => ['Home', 'Stok']
        ];

        $barang = BarangModel::select('barang_id', 'barang_nama')->get();
        $user = UserModel::select('user_id', 'nama')->get();

        return view('stok.index', compact('activeMenu', 'breadcrumb', 'barang', 'user'));
    }

    public function list(Request $request)
    {
        $stok = StokModel::with(['barang', 'user'])
            ->select('stok_id', 'barang_id', 'user_id', 'stok_tanggal', 'stok_jumlah', 'created_at', 'updated_at');

        if ($request->filled('filter_barang')) {
            $stok->where('barang_id', $request->filter_barang);
        }

        if ($request->filled('filter_user')) {
            $stok->where('user_id', $request->filter_user);
        }

        return DataTables::of($stok)
            ->addIndexColumn()
            ->addColumn('barang_nama', function ($stok) {
                return $stok->barang->barang_nama;
            })
            ->addColumn('user_nama', function ($stok) {
                return $stok->user->nama;
            })
            ->addColumn('stok_tanggal', function ($stok) {
                return date('d-m-Y', strtotime($stok->stok_tanggal));
            })
            ->addColumn('aksi', function ($stok) {
                $btn = '<button onclick="modalAction(\''.url('/stok/'.$stok->stok_id.'/show_ajax').'\')" 
                        class="btn btn-info btn-sm mr-1">
                        <i class="fas fa-eye"></i>
                    </button>';
                $btn .= '<button onclick="modalAction(\''.url('/stok/'.$stok->stok_id.'/edit_ajax').'\')" 
                        class="btn btn-warning btn-sm mr-1">
                        <i class="fas fa-edit"></i>
                    </button>';
                $btn .= '<button onclick="modalAction(\''.url('/stok/'.$stok->stok_id.'/delete_ajax').'\')" 
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
        $barang = BarangModel::all(['barang_id', 'barang_nama']);
        $user = UserModel::all(['user_id', 'nama']);
        return view('stok.create_ajax', compact('barang', 'user'));
    }

    public function store_ajax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'barang_id' => 'required|integer|exists:m_barang,barang_id',
            'user_id' => 'required|integer|exists:m_user,user_id',
            'stok_tanggal' => 'required|date',
            'stok_jumlah' => 'required|integer|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
                'message' => 'Validasi gagal'
            ], 422);
        }

        StokModel::create([
            'barang_id' => $request->barang_id,
            'user_id' => $request->user_id,
            'stok_tanggal' => $request->stok_tanggal,
            'stok_jumlah' => $request->stok_jumlah
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Data stok berhasil disimpan'
        ]);
    }

    public function edit_ajax($id)
    {
        $stok = StokModel::findOrFail($id);
        $barang = BarangModel::all(['barang_id', 'barang_nama']);
        $user = UserModel::all(['user_id', 'nama']);
        return view('stok.edit_ajax', compact('stok', 'barang', 'user'));
    }

    public function update_ajax(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'barang_id' => 'required|integer|exists:m_barang,barang_id',
            'user_id' => 'required|integer|exists:m_user,user_id',
            'stok_tanggal' => 'required|date',
            'stok_jumlah' => 'required|integer|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
                'message' => 'Validasi gagal'
            ], 422);
        }

        $stok = StokModel::findOrFail($id);
        $stok->update([
            'barang_id' => $request->barang_id,
            'user_id' => $request->user_id,
            'stok_tanggal' => $request->stok_tanggal,
            'stok_jumlah' => $request->stok_jumlah
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Data stok berhasil diperbarui'
        ]);
    }

    public function confirm_ajax($id)
    {
        $stok = StokModel::findOrFail($id);
        return view('stok.confirm_ajax', compact('stok'));
    }

    public function delete_ajax(Request $request, $id)
    {
        $stok = StokModel::findOrFail($id);
        $stok->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data stok berhasil dihapus'
        ]);
    }
}