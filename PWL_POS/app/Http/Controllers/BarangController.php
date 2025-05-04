<?php 
namespace App\Http\Controllers; 

use App\Models\BarangModel; 
use App\Models\KategoriModel; 
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Validator; 
use PhpOffice\PhpSpreadsheet\IOFactory; 
use Yajra\DataTables\Facades\DataTables; 
use Barryvdh\DomPDF\Facade\Pdf;

class BarangController extends Controller 
{ 
    public function index() 
    { 
        $activeMenu = 'barang'; 
        $breadcrumb = (object) [ 
            'title' => 'Data Barang', 
            'list' => ['Home', 'Barang'] 
        ]; 

        $kategori = KategoriModel::select('kategori_id', 'kategori_nama')->get(); 
        return view('barang.index', compact('activeMenu', 'breadcrumb', 'kategori')); 
    } 

    public function list(Request $request) 
    { 
        $barang = BarangModel::with('kategori')
            ->select('barang_id', 'barang_kode', 'barang_nama', 'harga_beli', 'harga_jual', 'kategori_id'); 

        if($request->filled('filter_kategori')) { 
            $barang->where('kategori_id', $request->filter_kategori); 
        } 

        return DataTables::of($barang)
            ->addIndexColumn() 
            ->addColumn('harga_beli', function($barang) {
                return $barang->harga_beli ? 'Rp ' . number_format($barang->harga_beli, 0, ',', '.') : '-';
            })
            ->addColumn('harga_jual', function($barang) {
                return $barang->harga_jual ? 'Rp ' . number_format($barang->harga_jual, 0, ',', '.') : '-';
            })
            ->addColumn('aksi', function ($barang) {
                $btn = '<button onclick="modalAction(\''.url('/barang/'.$barang->barang_id.'/show_ajax').'\')" 
                        class="btn btn-info btn-sm mr-1">
                        <i class="fas fa-eye"></i>
                    </button>';
                $btn .= '<button onclick="modalAction(\''.url('/barang/'.$barang->barang_id.'/edit_ajax').'\')" 
                        class="btn btn-warning btn-sm mr-1">
                        <i class="fas fa-edit"></i>
                    </button>';
                $btn .= '<button onclick="modalAction(\''.url('/barang/'.$barang->barang_id.'/delete_ajax').'\')" 
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
        $kategori = KategoriModel::all(['kategori_id', 'kategori_nama']); 
        return view('barang.create_ajax', compact('kategori')); 
    } 

    public function store_ajax(Request $request) 
    { 
        $validator = Validator::make($request->all(), [
            'kategori_id' => 'required|integer|exists:m_kategori,kategori_id',
            'barang_kode' => 'required|min:3|max:20|unique:m_barang,barang_kode',
            'barang_nama' => 'required|string|max:100',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0|gt:harga_beli'
        ], [
            'harga_jual.gt' => 'Harga jual harus lebih besar dari harga beli'
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
                'message' => 'Validasi gagal'
            ], 422);
        }

        BarangModel::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil disimpan'
        ]);
    } 

    public function edit_ajax($id) 
    { 
        $barang = BarangModel::findOrFail($id);
        $kategori = KategoriModel::all(['kategori_id', 'kategori_nama']);
        return view('barang.edit_ajax', compact('barang', 'kategori'));
    } 

    public function update_ajax(Request $request, $id) 
    { 
        $validator = Validator::make($request->all(), [
            'kategori_id' => 'required|integer|exists:m_kategori,kategori_id',
            'barang_kode' => 'required|min:3|max:20|unique:m_barang,barang_kode,'.$id.',barang_id',
            'barang_nama' => 'required|string|max:100',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0|gt:harga_beli'
        ], [
            'harga_jual.gt' => 'Harga jual harus lebih besar dari harga beli'
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
                'message' => 'Validasi gagal'
            ], 422);
        }

        $barang = BarangModel::findOrFail($id);
        $barang->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil diperbarui'
        ]);
    } 

    public function confirm_ajax($id) 
    { 
        $barang = BarangModel::findOrFail($id);
        return view('barang.confirm_ajax', compact('barang'));
    } 

    public function delete_ajax(Request $request, $id) 
    { 
        $barang = BarangModel::findOrFail($id);
        $barang->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    } 

    public function import() 
    { 
        return view('barang.import'); 
    } 

    public function import_ajax(Request $request) 
    { 
        $validator = Validator::make($request->all(), [
            'file_barang' => 'required|mimes:xlsx,xls|max:2048'
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
                'message' => 'File tidak valid'
            ], 422);
        }

        try {
            $file = $request->file('file_barang');
            $spreadsheet = IOFactory::load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray();

            $data = [];
            foreach(array_slice($rows, 1) as $row) { // Skip header
                $data[] = [
                    'kategori_id' => $row[0] ?? null,
                    'barang_kode' => $row[1] ?? null,
                    'barang_nama' => $row[2] ?? null,
                    'harga_beli' => $row[3] ?? 0,
                    'harga_jual' => $row[4] ?? 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }

            if(empty($data)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Tidak ada data yang valid untuk diimport'
                ], 422);
            }

            BarangModel::insert($data);

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil diimport',
                'count' => count($data)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan: '.$e->getMessage()
            ], 500);
        }
    } 

    public function export_excel()
    {
        // ambil data barang yang akan di export
        $barang = BarangModel::select('kategori_id','barang_kode','nama_barang','harga_beli','harga_jual')
                ->orderBy('kategori_id')
                ->with('kategori')
                ->get();
                // load library excel
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet(); // ambil sheet yang aktif

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Kode Barang');
        $sheet->setCellValue('C1', 'Nama Barang');
        $sheet->setCellValue('D1', 'Harga Beli');
        $sheet->setCellValue('E1', 'Harga Jual');
        $sheet->setCellValue('F1', 'Kategori');

        $sheet->getStyle('A1:F1')->getFont()->setBold(true); // bold header
        $no = 1; // nomor data dimulai dari 1
        $baris = 2; // baris data dimulai dari baris ke 2
        foreach ($barang as $key => $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->barang_kode);
            $sheet->setCellValue('C' . $baris, $value->nama_barang);
            $sheet->setCellValue('D' . $baris, $value->harga_beli);
            $sheet->setCellValue('E' . $baris, $value->harga_jual);
            $sheet->setCellValue('F' . $baris, $value->kategori->kategori_nama); // ambil nama kategori
            $baris++;
            $no++;
        }

        foreach (range('A', 'F') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true); // set auto size untuk kolom
        }
        
        $sheet->setTitle('Data Barang'); // set title sheet
  
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Barang_' . date('Y-m-d H:i:s') . '.xlsx';
  
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');
  
        $writer->save('php://output');
        exit;
    }
        public function export_pdf()
    {
         set_time_limit(300); // batas waktu export dalam detik
         $barang = BarangModel::select('kategori_id', 'barang_kode', 'nama_barang', 'harga_beli', 'harga_jual')
             ->orderBy('kategori_id')
             ->orderBy('barang_kode')
             ->with('kategori')
             ->get();
 
         $pdf = Pdf::loadView('barang.export_pdf', ['barang' => $barang]);
         $pdf->setPaper('a4', 'portrait'); // set ukuran kertas dan orientasi
         $pdf->setOption("isRemoteEnabled", true); // set true jika ada gambar dari url
         // $pdf->render(); // Render the PDF as HTML - uncomment if you want to see the HTML output
 
         return $pdf->stream('Data Barang_' . date('Y-m-d H:i:s') . '.pdf');
    }
}