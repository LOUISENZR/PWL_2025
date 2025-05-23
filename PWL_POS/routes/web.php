<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\PenjualanController;

//Route::get('/', function () {
    //return view('welcome');
//});

Route::pattern('id', '[0-9]+'); // artinya ketika ada parameter (id), maka harus berupa angka
  
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postlogin']);
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth');


Route::middleware(['authorize:MNG,ADM'])->group(function () { // artinya semua route di dalam group ini harus login dulu
    
    Route::get('/', [WelcomeController::class,'index']);

    Route::group(['prefix' => 'user'], function () {
        Route::get('/', [UserController::class, 'index']);          // menampilkan halaman awal user
        Route::post('/list', [UserController::class, 'list']);      // menampilkan data user dalam bentuk json untuk datatables
        Route::get('/create', [UserController::class, 'create']);   // menampilkan halaman form tambah user
        Route::post('/', [UserController::class, 'store']);         // menyimpan data user baru
        Route::get('/create_ajax', [UserController::class, 'create_ajax']); // menampilkan halaman form tambah user (ajax)
        Route::post('/ajax', [UserController::class, 'store_ajax']);        // menyimpan data user baru (ajax)
        Route::get('/{id}', [UserController::class, 'show']);       // menampilkan detail user
        Route::get('/{id}/edit', [UserController::class, 'edit']);  // menampilkan halaman form edit user
        Route::put('/{id}', [UserController::class, 'update']);     // menyimpan perubahan data user
        Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']); // menampilkan halaman form edit user (ajax)
        Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']); // menyimpan perubahan data user (ajax)
        Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']); // menampilkan konfirmasi hapus user (ajax)
        Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']); // menghapus data user (ajax)
        Route::delete('/{id}', [UserController::class, 'destroy']); // menghapus data user
        Route::get('/import', [UserController::class, 'import']); // menampilkan halaman form upload excel user ajax
        Route::post('/import_ajax', [UserController::class, 'import_ajax']); // menyimpan import excel user ajax
        Route::get('/export_excel', [UserController::class,'export_excel']); //export excel
        Route::get('/export_pdf', [UserController::class,'export_pdf']); //export pdf
        
    });
    
    Route::middleware(['authorize:ADM'])->group(function (){// artinya semua route di dalam group ini harus login dulu
        Route::group(['prefix' => 'level'], function () {
            Route::get('/', [LevelController::class, 'index']);          // menampilkan halaman awal level
            Route::post('/list', [LevelController::class, 'list']);      // menampilkan data level dalam bentuk json untuk datatables
            Route::get('/create', [LevelController::class, 'create']);   // menampilkan halaman form tambah level
            Route::post('/', [LevelController::class, 'store']);         // menyimpan data level baru
            Route::get('/create_ajax', [LevelController::class, 'create_ajax']); // menampilkan halaman form tambah level (ajax)
            Route::post('/ajax', [LevelController::class, 'store_ajax']);        // menyimpan data level baru (ajax)
            Route::get('/{id}', [LevelController::class, 'show']);       // menampilkan detail level
            Route::get('/{id}/edit', [LevelController::class, 'edit']);  // menampilkan halaman form edit level
            Route::put('/{id}', [LevelController::class, 'update']);     // menyimpan perubahan data level
            Route::get('/{id}/edit_ajax', [LevelController::class, 'edit_ajax']); // menampilkan halaman form edit level (ajax)
            Route::put('/{id}/update_ajax', [LevelController::class, 'update_ajax']); // menyimpan perubahan data level (ajax)
            Route::get('/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']); // menampilkan konfirmasi hapus level (ajax)
            Route::delete('/{id}/delete_ajax', [LevelController::class, 'delete_ajax']); // menghapus data level (ajax)
            Route::delete('/{id}', [LevelController::class, 'destroy']); // menghapus data level
            Route::get('/import', [LevelController::class, 'import']); // menampilkan halaman form upload excel level ajax
            Route::post('/import_ajax', [LevelController::class, 'import_ajax']); // menyimpan import excel level ajax
            Route::get('/export_excel', [LevelController::class,'export_excel']); //export excel
            Route::get('/export_pdf', [LevelController::class,'export_pdf']); //export pdf
        });
    
    
        Route::group(['prefix' => 'kategori'], function () {
            Route::get('/', [KategoriController::class, 'index']);          // menampilkan halaman awal kategori
            Route::post('/list', [KategoriController::class, 'list']);      // menampilkan data kategori dalam bentuk json untuk datatables
            Route::get('/create', [KategoriController::class, 'create']);   // menampilkan halaman form tambah kategori
            Route::post('/', [KategoriController::class, 'store']);         // menyimpan data kategori baru
            Route::get('/create_ajax', [KategoriController::class, 'create_ajax']); // menampilkan halaman form tambah kategori (ajax)
            Route::post('/ajax', [KategoriController::class, 'store_ajax']);        // menyimpan data kategori baru (ajax)
            Route::get('/{id}', [KategoriController::class, 'show']);       // menampilkan detail kategori
            Route::get('/{id}/edit', [KategoriController::class, 'edit']);  // menampilkan halaman form edit kategori
            Route::put('/{id}', [KategoriController::class, 'update']);     // menyimpan perubahan data kategori
            Route::get('/{id}/edit_ajax', [KategoriController::class, 'edit_ajax']); // menampilkan halaman form edit kategori (ajax)
            Route::put('/{id}/update_ajax', [KategoriController::class, 'update_ajax']); // menyimpan perubahan data kategori (ajax)
            Route::get('/{id}/delete_ajax', [KategoriController::class, 'confirm_ajax']); // menampilkan konfirmasi hapus kategori (ajax)
            Route::delete('/{id}/delete_ajax', [KategoriController::class, 'delete_ajax']); // menghapus data kategori (ajax)
            Route::delete('/{id}', [KategoriController::class, 'destroy']); // menghapus data kategori
            Route::get('/import', [KategoriController::class, 'import']); // menampilkan halaman form upload excel kategori ajax
                Route::post('/import_ajax', [KategoriController::class, 'import_ajax']); // menyimpan import excel kategori ajax
                Route::get('/export_excel', [KategoriController::class,'export_excel']); //export excel
                Route::get('/export_pdf', [KategoriController::class,'export_pdf']); //export pdf
        });
    });

        Route::group(['prefix' => 'supplier'], function () {
            Route::get('/', [SupplierController::class, 'index']);          // menampilkan halaman awal supplier
            Route::post('/list', [SupplierController::class, 'list']);      // menampilkan data supplier dalam bentuk json untuk datatables
            Route::get('/create', [SupplierController::class, 'create']);   // menampilkan halaman form tambah supplier
            Route::post('/', [SupplierController::class, 'store']);         // menyimpan data supplier baru
            Route::get('/create_ajax', [SupplierController::class, 'create_ajax']); // menampilkan halaman form tambah supplier (ajax)
            Route::post('/ajax', [SupplierController::class, 'store_ajax']);        // menyimpan data supplier baru (ajax)
            Route::get('/{id}', [SupplierController::class, 'show']);       // menampilkan detail supplier
            Route::get('/{id}/edit', [SupplierController::class, 'edit']);  // menampilkan halaman form edit supplier
            Route::put('/{id}', [SupplierController::class, 'update']);     // menyimpan perubahan data supplier
            Route::get('/{id}/edit_ajax', [SupplierController::class, 'edit_ajax']); // menampilkan halaman form edit supplier (ajax)
            Route::put('/{id}/update_ajax', [SupplierController::class, 'update_ajax']); // menyimpan perubahan data supplier (ajax)
            Route::get('/{id}/delete_ajax', [SupplierController::class, 'confirm_ajax']); // menampilkan konfirmasi hapus supplier (ajax)
            Route::delete('/{id}/delete_ajax', [SupplierController::class, 'delete_ajax']); // menghapus data supplier (ajax)
            Route::delete('/{id}', [SupplierController::class, 'destroy']); // menghapus data supplier
            Route::get('/import', [SupplierController::class, 'import']); // menampilkan halaman form upload excel supplier ajax
                Route::post('/import_ajax', [SupplierController::class, 'import_ajax']); // menyimpan import excel supplier ajax
                Route::get('/export_excel', [SupplierController::class,'export_excel']); //export excel
                Route::get('/export_pdf', [SupplierController::class,'export_pdf']); //export pdf
            
        });
    
    Route::group(['prefix' => 'barang'], function () {
        Route::get('/', [BarangController::class, 'index']);          // menampilkan halaman awal barang
        Route::post('/list', [BarangController::class, 'list']);      // menampilkan data barang dalam bentuk json untuk datatables
        Route::get('/create', [BarangController::class, 'create']);   // menampilkan halaman form tambah barang
        Route::post('/', [BarangController::class, 'store']);         // menyimpan data barang baru
        Route::get('/create_ajax', [BarangController::class, 'create_ajax']); // menampilkan halaman form tambah barang (ajax)
        Route::post('/ajax', [BarangController::class, 'store_ajax']);        // menyimpan data barang baru (ajax)
        Route::get('/{id}', [BarangController::class, 'show']);       // menampilkan detail barang
        Route::get('/{id}/edit', [BarangController::class, 'edit']);  // menampilkan halaman form edit barang
        Route::put('/{id}', [BarangController::class, 'update']);     // menyimpan perubahan data barang
        Route::get('/{id}/edit_ajax', [BarangController::class, 'edit_ajax']); // menampilkan halaman form edit barang (ajax)
        Route::put('/{id}/update_ajax', [BarangController::class, 'update_ajax']); // menyimpan perubahan data barang (ajax)
        Route::delete('/{id}/delete_ajax', [BarangController::class, 'delete_ajax']); // menghapus data barang (ajax)
        Route::delete('/{id}', [BarangController::class, 'destroy']); // menghapus data barang
        Route::get('/barang/import', [BarangController::class, 'import']); // ajax form upload exel
        Route::post('/barang/import_ajak', [BarangController::class, 'import_ajax']);  // ajax importexel
        Route::get('/import', [BarangController::class, 'import']); // menampilkan halaman form upload excel barang ajax
        Route::post('/import_ajax', [BarangController::class, 'import_ajax']); // menyimpan import excel barang ajax
        Route::get('/export_excel', [BarangController::class,'export_excel']); //export excel
        Route::get('/export_pdf', [BarangController::class,'export_pdf']); //export pdf
    });
    Route::prefix('stok')->group(function () {
        Route::get('/', [StokController::class, 'index'])->name('stok.index'); 
        Route::post('/list', [StokController::class, 'list'])->name('stok.list'); 
        Route::get('/create', [StokController::class, 'create'])->name('stok.create'); 
        Route::post('/', [StokController::class, 'store'])->name('stok.store'); 
        Route::get('/{id}', [StokController::class, 'show'])->name('stok.show'); 
        Route::get('/{id}/edit', [StokController::class, 'edit'])->name('stok.edit'); 
        Route::put('/{id}', [StokController::class, 'update'])->name('stok.update'); 
        Route::delete('/{id}', [StokController::class, 'destroy'])->name('stok.destroy'); 
        Route::post('/{id}/confirm', [StokController::class, 'confirm_ajax'])->name('stok.confirm_ajax'); 
        Route::post('/create/ajax', [StokController::class, 'create_ajax'])->name('stok.create_ajax'); 
        Route::post('/{id}/edit/ajax', [StokController::class, 'edit_ajax'])->name('stok.edit_ajax'); 
        Route::post('/{id}/show/ajax', [StokController::class, 'show_ajax'])->name('stok.show_ajax'); 
        Route::get('/export/pdf', [StokController::class, 'export_pdf'])->name('stok.export_pdf'); 
        Route::get('/import', [StokController::class, 'import'])->name('stok.import'); 
    });
    Route::prefix('penjualan')->group(function () {
        Route::get('/', [PenjualanController::class, 'index'])->name('penjualan.index'); 
        Route::post('/list', [PenjualanController::class, 'list'])->name('penjualan.list');
        Route::get('/create', [PenjualanController::class, 'create'])->name('penjualan.create');
        Route::post('/', [PenjualanController::class, 'store'])->name('penjualan.store');
        Route::get('/{id}', [PenjualanController::class, 'show'])->name('penjualan.show');
        Route::get('/{id}/edit', [PenjualanController::class, 'edit'])->name('penjualan.edit');
        Route::put('/{id}', [PenjualanController::class, 'update'])->name('penjualan.update');
        Route::delete('/{id}', [PenjualanController::class, 'destroy'])->name('penjualan.destroy');
        Route::post('/{id}/confirm', [PenjualanController::class, 'confirm_ajax'])->name('penjualan.confirm_ajax');
        Route::post('/create/ajax', [PenjualanController::class, 'create_ajax'])->name('penjualan.create_ajax');
        Route::post('/{id}/edit/ajax', [PenjualanController::class, 'edit_ajax'])->name('penjualan.edit_ajax');
        Route::post('/{id}/show/ajax', [PenjualanController::class, 'show_ajax'])->name('penjualan.show_ajax');
        Route::get('/export/pdf', [PenjualanController::class, 'export_pdf'])->name('penjualan.export_pdf');
        Route::get('/import', [PenjualanController::class, 'import'])->name('penjualan.import');
    });      

    Route::get('/level', [LevelController::class, 'index']);
    Route::get('/kategori', [KategoriController::class, 'index']);
    Route::get('/user', [UserController::class, 'index']);
    Route::get('/user/tambah', [UserController::class, 'tambah']);
    Route::post('/user/tambah_simpan', [UserController::class, 'tambah_simpan']);
    Route::get('/user/ubah/{id}', [UserController::class, 'ubah']);
    Route::put('/user/ubah_simpan/{id}', [UserController::class, 'ubah_simpan']);
    Route::get('/user/hapus/{id}', [UserController::class, 'hapus']);
        

});
