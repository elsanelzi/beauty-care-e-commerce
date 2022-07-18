<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KurirController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\KelolaAkunController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PersediaanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', [DashboardController::class, 'index'])->name('/');
Route::get('barang', [DashboardController::class, 'barang_view'])->name('barang_view');
Route::group(['middleware' => 'guest'], function () {
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::POST('proses_login', [AuthController::class, 'proses_login'])->name('proses_login');
    Route::get('register', [AuthController::class, 'register'])->name('register');
    Route::POST('proses_register', [AuthController::class, 'proses_register'])->name('proses_register');
});
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::group(['middleware' => 'auth'], function () {
    Route::get('admin', [AuthController::class, 'admin'])->name('admin');
    Route::get('karyawan', [AuthController::class, 'karyawan'])->name('karyawan');
    // Route::get('kepsek', [AuthController::class, 'kepsek'])->name('kepsek');
    // Route::get('ketua_yayasan', [AuthController::class, 'ketua_yayasan'])->name('ketua_yayasan');
    Route::POST('logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('dashboard', [KelolaAkunController::class, 'dashboard'])->name('dashboard');
    Route::prefix('kelola_akun')->group(function () {
        Route::get('index', [KelolaAkunController::class, 'index'])->name('kelola_akun');
        Route::get('tambah', [KelolaAkunController::class, 'create'])->name('akun_tambah');
        Route::POST('tambah', [KelolaAkunController::class, 'store'])->name('akun_tambah');
        Route::get('edit/{id}', [KelolaAkunController::class, 'edit'])->name('akun_edit');
        Route::POST('edit/{id}', [KelolaAkunController::class, 'update'])->name('akun_edit');
        Route::DELETE('hapus/{id}', [KelolaAkunController::class, 'destroy'])->name('akun_hapus');
    });

    Route::prefix('barang')->group(function () {
        Route::get('barang', [BarangController::class, 'index'])->name('kelola_barang');
        Route::get('tambah', [BarangController::class, 'create'])->name('barang_tambah');
        Route::POST('tambah', [BarangController::class, 'store'])->name('barang_tambah');
        Route::get('edit/{id}', [BarangController::class, 'edit'])->name('barang_edit');
        Route::POST('edit/{id}', [BarangController::class, 'update'])->name('barang_edit');
        Route::get('detail_barang/{id}', [BarangController::class, 'show'])->name('detail_barang');
        Route::DELETE('hapus/{id}', [BarangController::class, 'destroy'])->name('barang_hapus');
    });

    Route::prefix('kurir')->group(function () {
        Route::get('kurir', [KurirController::class, 'index'])->name('kurir');
        Route::get('tambah', [KurirController::class, 'create'])->name('kurir_tambah');
        Route::POST('tambah', [KurirController::class, 'store'])->name('kurir_tambah');
        Route::get('edit/{id}', [KurirController::class, 'edit'])->name('kurir_edit');
        Route::POST('edit/{id}', [KurirController::class, 'update'])->name('kurir_edit');
        Route::DELETE('hapus/{id}', [KurirController::class, 'destroy'])->name('kurir_hapus');
    });

    Route::prefix('kelola_persediaan')->group(function () {
        Route::get('persediaan', [PersediaanController::class, 'index'])->name('kelola_persediaan');
        Route::get('tambah', [PersediaanController::class, 'create'])->name('persediaan_tambah');
        Route::POST('ajax', [PersediaanController::class, 'ajax'])->name('ajax_persediaan');
        Route::POST('tambah', [PersediaanController::class, 'store'])->name('persediaan_tambah');
        Route::get('edit/{id}', [PersediaanController::class, 'edit'])->name('persediaan_edit');
        Route::POST('edit/{id}', [PersediaanController::class, 'update'])->name('persediaan_edit');
        Route::DELETE('delete/{id}', [PersediaanController::class, 'delete'])->name('persediaan_delete');
    });

    Route::prefix('pemesanan')->group(function () {
        Route::POST('proses_pemesanan', [PemesananController::class, 'proses_pemesanan'])->name('proses_pemesanan');
        Route::get('pesanan_user', [PemesananController::class, 'pesanan_user'])->name('pesanan_user');
        Route::DELETE('hapus/{id_pemesanan}', [PemesananController::class, 'hapus'])->name('pesan_hapus');
        Route::get('konfirmasi_pemesanan', [PemesananController::class, 'kelola_pemesanan'])->name('kelola_pemesanan');
        Route::get('konfirmasi/{id_pemesanan}', [PemesananController::class, 'konfirmasi'])->name('konfirmasi');
        Route::get('cancel/{id_pemesanan}', [PemesananController::class, 'cancel'])->name('cancel');
    });

    Route::prefix('pembayaran')->group(function () {
        Route::get('proses_pembayaran', [PembayaranController::class, 'proses_pembayaran'])->name('proses_pembayaran');
        Route::POST('proses_checkout', [PembayaranController::class, 'proses_checkout'])->name('proses_checkout');
        Route::get('kelola_pembayaran', [PembayaranController::class, 'kelola_pembayaran'])->name('kelola_pembayaran');
        Route::get('konfirmasi/{id_pembayaran}', [PembayaranController::class, 'konfirmasi'])->name('konfirmasi1');
        Route::get('cancel/{id_pembayaran}', [PembayaranController::class, 'cancel'])->name('cancel1');
    });

    Route::prefix('laporan')->group(function () {
        Route::get('pemesanan_saya', [LaporanController::class, 'pemesanan_saya'])->name('pemesanan_saya');
        Route::get('barang_sampai/{id}', [LaporanController::class, 'barang_sampai'])->name('barang_sampai');
        Route::get('laporan_admin', [LaporanController::class, 'laporan_admin'])->name('laporan_admin');
        Route::get('faktur', [LaporanController::class, 'faktur'])->name('faktur');
        Route::get('print1', [LaporanController::class, 'print1'])->name('print1');
        Route::get('print/{periode}', [LaporanController::class, 'print'])->name('print');
        Route::POST('cari', [LaporanController::class, 'cari'])->name('cari');
    });
});
