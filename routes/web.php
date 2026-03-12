<?php

use App\Http\Controllers\AadbController;
use App\Http\Controllers\AadbKategoriController;
use App\Http\Controllers\AtkController;
use App\Http\Controllers\AtkDistribusiController;
use App\Http\Controllers\AtkKategori;
use App\Http\Controllers\AtkKategoriController;
use App\Http\Controllers\AtkKeranjang;
use App\Http\Controllers\AtkKeranjangController;
use App\Http\Controllers\AtkSatuanController;
use App\Http\Controllers\AtkStokController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BmhpKategoriController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\GdnController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\UktController;
use App\Http\Controllers\UnitKerjaController;
use App\Http\Controllers\UserAksesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UsulanAtkController;
use App\Http\Controllers\UsulanController;
use App\Http\Controllers\BmhpController;
use App\Http\Controllers\BmhpKeranjangController;
use App\Http\Controllers\BmhpStokController;
use App\Http\Controllers\UsulanBmhpController;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('logout', [AuthController::class, 'logout'])->name('logout');
Route::post('login', [AuthController::class, 'post'])->name('loginPost');

Route::group(['middleware' => 'auth'], function () {
    Route::get('dashboard',          [DashboardController::class, 'index'])->name('dashboard');
    Route::get('profil/show/{id}',   [AuthController::class, 'profil'])->name('profil');
    Route::get('profil/edit/{id}',   [AuthController::class, 'profilUpdate'])->name('profil.edit');
    Route::get('profil/update/{id}', [AuthController::class, 'profilUpdate'])->name('profil.update');
    Route::get('email',              [AuthController::class, 'email'])->name('email');
    Route::get('email/update',       [AuthController::class, 'email'])->name('email.update');
    Route::get('email/delete/{id}',  [AuthController::class, 'emailDelete'])->name('email.delete');
    Route::get('users/select',       [UserController::class, 'select'])->name('users.select');

    Route::get('usulan-atk/hapus/{id}', [UsulanAtkController::class, 'delete'])->name('usulan-atk.delete');
    Route::post('usulan-atk/store',     [UsulanAtkController::class, 'store'])->name('usulan-atk.store');
    Route::post('usulan-atk/update',    [UsulanAtkController::class, 'update'])->name('usulan-atk.update');

    Route::get('usulan-bmhp/hapus/{id}', [UsulanBmhpController::class, 'delete'])->name('usulan-bmhp.delete');
    Route::post('usulan-bmhp/store',     [UsulanBmhpController::class, 'store'])->name('usulan-bmhp.store');
    Route::post('usulan-bmhp/update',    [UsulanBmhpController::class, 'update'])->name('usulan-bmhp.update');

    Route::get('atk/select-detail/{id}',  [AtkController::class, 'selectByCategory'])->name('atk.select-detail');
    Route::get('bmhp/select-detail/{id}', [BmhpController::class, 'selectByCategory'])->name('bmhp.select-detail');

    Route::get('usulan/verif/{id}',   [UsulanController::class, 'verif'])->name('usulan.verif');
    Route::get('usulan/proses/{id}',  [UsulanController::class, 'proses'])->name('usulan.proses');
    Route::get('usulan/daftar/{id}',  [UsulanController::class, 'show'])->name('usulan');
    Route::get('usulan/detail/{id}',  [UsulanController::class, 'detail'])->name('usulan.detail');
    Route::get('usulan/select/{id}',  [UsulanController::class, 'select'])->name('usulan.select');
    Route::get('usulan/surat/{id}',   [UsulanController::class, 'surat'])->name('usulan.surat');
    Route::get('usulan/edit/{id}',    [UsulanController::class, 'edit'])->name('usulan.edit');
    Route::get('usulan/delete/{id}',  [UsulanController::class, 'delete'])->name('usulan.delete');
    Route::get('usulan/viewPdf/{id}',  [UsulanController::class, 'viewPdf'])->name('usulan.viewPdf');
    Route::post('usulan/store/{id}',  [UsulanController::class, 'store'])->name('usulan.store');
    Route::post('usulan/update/{id}', [UsulanController::class, 'update'])->name('usulan.update');

    Route::get('usulan/delete-item/{id}',  [UsulanController::class, 'deleteItem'])->name('usulan.deleteItem');
    Route::get('usulan/delete-servis/{id}',  [UsulanController::class, 'deleteServis'])->name('usulan.deleteServis');


    Route::get('gdn', [GdnController::class, 'index'])->name('gdn');
    Route::get('ukt', [UktController::class, 'index'])->name('ukt');

    // ATK ====================================================================================================
    Route::get('atk', [AtkController::class, 'index'])->name('atk');
    Route::get('atk-stok/ready',   [AtkStokController::class, 'ready'])->name('atk-stok.ready');
    Route::post('atk-stok/store',  [AtkKeranjangController::class, 'keranjang'])->name('atk-stok.create');
    Route::get('atk-distribusi',   [AtkDistribusiController::class, 'show'])->name('atk-distribusi');

    Route::group(['prefix' => 'atk-distribusi', 'as' => 'atk-distribusi.'], function () {
        Route::get('select',       [AtkDistribusiController::class, 'select'])->name('select');
        Route::get('detail/{id}',  [AtkDistribusiController::class, 'detail'])->name('detail');
    });

    Route::group(['prefix' => 'atk-bucket', 'as' => 'atk-bucket.'], function () {
        Route::get('update/{aksi}/{id}', [AtkKeranjangController::class, 'update'])->name('update');
        Route::get('remove/{id}',        [AtkKeranjangController::class, 'remove'])->name('remove');
        Route::get('reusul/{id}',        [AtkKeranjangController::class, 'reusul'])->name('reusul');
        Route::get('store',              [AtkKeranjangController::class, 'store'])->name('store');
        Route::post('create',            [AtkKeranjangController::class, 'create'])->name('create');
    });
    // ========================================================================================================

    // BMHP ====================================================================================================
    Route::get('bmhp', [BmhpController::class, 'index'])->name('bmhp');
    Route::get('bmhp-stok/ready',   [BmhpStokController::class, 'ready'])->name('bmhp-stok.ready');

    Route::group(['prefix' => 'bmhp-bucket', 'as' => 'bmhp-bucket.'], function () {
        Route::get('update/{aksi}/{id}', [BmhpKeranjangController::class, 'update'])->name('update');
        Route::get('remove/{id}',        [BmhpKeranjangController::class, 'remove'])->name('remove');
        Route::get('reusul/{id}',        [BmhpKeranjangController::class, 'reusul'])->name('reusul');
        Route::get('store',              [BmhpKeranjangController::class, 'store'])->name('store');
        Route::post('create',            [BmhpKeranjangController::class, 'create'])->name('create');
    });
    // ========================================================================================================

    Route::get('aadb',              [AadbController::class, 'index'])->name('aadb');
    Route::get('aadb/select',       [AadbController::class, 'select'])->name('aadb.select');
    Route::get('aadb/create',       [AadbController::class, 'create'])->name('aadb.create');
    Route::get('aadb/detail/{id}',  [AadbController::class, 'detail'])->name('aadb.detail');
    Route::get('aadb/edit/{id}',    [AadbController::class, 'edit'])->name('aadb.edit');
    Route::post('aadb/store',       [AadbController::class, 'store'])->name('aadb.store');
    Route::post('aadb/update/{id}', [AadbController::class, 'update'])->name('aadb.update');

    // Akses Super User
    Route::group(['middleware' => ['access:user']], function () {

        Route::get('usulan/tambah/{id}',  [UsulanController::class, 'create'])->name('usulan.create');

        Route::group(['prefix' => 'atk-distribusi', 'as' => 'atk-distribusi.'], function () {
            Route::get('edit/{id}',    [AtkDistribusiController::class, 'edit'])->name('edit');
            Route::post('store',       [AtkDistribusiController::class, 'store'])->name('store');
            Route::post('update/{id}', [AtkDistribusiController::class, 'update'])->name('update');

            Route::get('item-delete/{id}',  [AtkDistribusiController::class, 'itemDelete'])->name('item.delete');
            Route::post('item-store',       [AtkDistribusiController::class, 'itemStore'])->name('item.store');
            Route::post('item-update/{id}', [AtkDistribusiController::class, 'itemUpdate'])->name('item.update');
        });
    });

    // Akses Super User
    Route::group(['middleware' => ['access:monitor']], function () {

        Route::get('kriteria', [PenilaianKriteriaController::class, 'show'])->name('kriteria');
    });

    // Akses Admin
    Route::group(['middleware' => ['access:admin']], function () {

        Route::get('kriteria/store', [PenilaianKriteriaController::class, 'store'])->name('kriteria.store');
        Route::post('kriteria/update/{id}', [PenilaianKriteriaController::class, 'update'])->name('kriteria.update');
    });

    Route::group(['middleware' => ['access:admin-atk']], function () {
        Route::get('atk-barang',                    [AtkController::class, 'show'])->name('atk-barang');
        Route::get('atk-barang/select',             [AtkController::class, 'select'])->name('atk-barang.select');
        Route::get('atk-barang/select/detail/{id}', [AtkController::class, 'selectById'])->name('atk-barang.select-detail');
        Route::get('atk-barang/detail/{id}',        [AtkController::class, 'detail'])->name('atk-barang.detail');
        Route::get('atk-barang/edit/{id}',          [AtkController::class, 'edit'])->name('atk-barang.edit');
        Route::get('atk-barang/create',             [AtkController::class, 'create'])->name('atk-barang.create');
        Route::post('atk-barang/store',             [AtkController::class, 'store'])->name('atk-barang.store');
        Route::post('atk-barang/upload',            [AtkController::class, 'upload'])->name('atk-barang.upload');
        Route::post('atk-barang/update',            [AtkController::class, 'update'])->name('atk-barang.update');

        Route::get('atk-stok', [AtkStokController::class, 'show'])->name('atk-stok');
        Route::get('atk-stok/detail/{id}', [AtkStokController::class, 'detail'])->name('atk-stok.detail');
        Route::get('atk-stok/edit/{id}', [AtkStokController::class, 'edit'])->name('atk-stok.edit');
        Route::get('atk-stok/delete/{id}', [AtkStokController::class, 'delete'])->name('atk-stok.delete');
        Route::post('atk-stok/store', [AtkStokController::class, 'store'])->name('atk-stok.store');
        Route::post('atk-stok/update/{id}', [AtkStokController::class, 'update'])->name('atk-stok.update');

        Route::get('atk-stok/item-delete/{id}', [AtkStokController::class, 'itemDelete'])->name('atk-stok.item.delete');
        Route::post('atk-stok/item-store', [AtkStokController::class, 'itemStore'])->name('atk-stok.item.store');
        Route::post('atk-stok/item-update/{id}', [AtkStokController::class, 'itemUpdate'])->name('atk-stok.item.update');

        Route::get('atk-kategori', [AtkKategoriController::class, 'show'])->name('atk-kategori');
        Route::post('atk-kategori/store', [AtkKategoriController::class, 'store'])->name('atk-kategori.store');
        Route::post('atk-kategori/update/{id}', [AtkKategoriController::class, 'update'])->name('atk-kategori.update');

        Route::get('atk-satuan', [AtkSatuanController::class, 'show'])->name('atk-satuan');
        Route::post('atk-satuan/store', [AtkSatuanController::class, 'store'])->name('atk-satuan.store');
        Route::post('atk-satuan/update/{id}', [AtkSatuanController::class, 'update'])->name('atk-satuan.update');
    });

    Route::group(['middleware' => ['access:admin-aadb']], function () {
        Route::get('aadb-kategori', [AadbKategoriController::class, 'show'])->name('aadb-kategori');
        Route::group(['prefix' => 'aadb-kategori', 'as' => 'aadb-kategori.'], function () {
            Route::post('store',       [AadbKategoriController::class, 'store'])->name('store');
            Route::post('update/{id}', [AadbKategoriController::class, 'update'])->name('update');
        });
    });

    Route::group(['middleware' => ['access:admin-bmhp']], function () {
        Route::get('bmhp-kategori', [BmhpKategoriController::class, 'show'])->name('bmhp-kategori');
        Route::group(['prefix' => 'bmhp-kategori', 'as' => 'bmhp-kategori.'], function () {
            Route::post('store',       [BmhpKategoriController::class, 'store'])->name('store');
            Route::post('update/{id}', [BBmhpKategoriControllerm::class, 'update'])->name('update');
        });

        Route::get('bmhp-barang',                    [BmhpController::class, 'show'])->name('bmhp-barang');
        Route::get('bmhp-barang/select',             [BmhpController::class, 'select'])->name('bmhp-barang.select');
        Route::get('bmhp-barang/select/detail/{id}', [BmhpController::class, 'selectById'])->name('bmhp-barang.select-detail');
        Route::get('bmhp-barang/detail/{id}',        [BmhpController::class, 'detail'])->name('bmhp-barang.detail');
        Route::get('bmhp-barang/edit/{id}',          [BmhpController::class, 'edit'])->name('bmhp-barang.edit');
        Route::get('bmhp-barang/create',             [BmhpController::class, 'create'])->name('bmhp-barang.create');
        Route::post('bmhp-barang/store',             [BmhpController::class, 'store'])->name('bmhp-barang.store');
        Route::post('bmhp-barang/upload',            [BmhpController::class, 'upload'])->name('bmhp-barang.upload');
        Route::post('bmhp-barang/update',            [BmhpController::class, 'update'])->name('bmhp-barang.update');

        Route::get('bmhp-stok',                      [BmhpStokController::class, 'show'])->name('bmhp-stok');
        Route::get('bmhp-stok/detail/{id}',          [BmhpStokController::class, 'detail'])->name('bmhp-stok.detail');
        Route::get('bmhp-stok/edit/{id}',            [BmhpStokController::class, 'edit'])->name('bmhp-stok.edit');
        Route::get('bmhp-stok/delete/{id}',          [BmhpStokController::class, 'delete'])->name('bmhp-stok.delete');
        Route::get('bmhp-stok/item-delete/{id}',     [BmhpStokController::class, 'itemDelete'])->name('bmhp-stok.item.delete');
        Route::post('bmhp-stok/store',               [BmhpStokController::class, 'store'])->name('bmhp-stok.store');
        Route::post('bmhp-stok/update/{id}',         [BmhpStokController::class, 'update'])->name('bmhp-stok.update');
        Route::post('bmhp-stok/item-store',          [BmhpStokController::class, 'itemStore'])->name('bmhp-stok.item.store');
        Route::post('bmhp-stok/item-update/{id}',    [BmhpStokController::class, 'itemUpdate'])->name('bmhp-stok.item.update');
    });


    // Akses Super Admin
    Route::group(['middleware' => ['access:master']], function () {

        Route::get('users', [UserController::class, 'show'])->name('users');
        Route::get('users/detail/{id}', [UserController::class, 'detail'])->name('users.detail');
        Route::get('users/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
        Route::post('users/store', [UserController::class, 'store'])->name('users.store');
        Route::post('users/update/{id}', [UserController::class, 'update'])->name('users.update');

        Route::get('pegawai', [PegawaiController::class, 'show'])->name('pegawai');
        Route::get('pegawai/select', [PegawaiController::class, 'select'])->name('pegawai.select');
        Route::get('pegawai/detail/{id}', [PegawaiController::class, 'detail'])->name('pegawai.detail');
        Route::get('pegawai/edit/{id}', [PegawaiController::class, 'edit'])->name('pegawai.edit');
        Route::get('pegawai/delete/{id}', [PegawaiController::class, 'delete'])->name('pegawai.delete');
        Route::post('pegawai/store', [PegawaiController::class, 'store'])->name('pegawai.store');
        Route::post('pegawai/update/{id}', [PegawaiController::class, 'update'])->name('pegawai.update');

        Route::get('form', [FormController::class, 'show'])->name('form');
        Route::post('form/store', [FormController::class, 'store'])->name('form.store');
        Route::post('form/update/{id}', [FormController::class, 'update'])->name('form.update');

        Route::get('uker', [UnitKerjaController::class, 'show'])->name('uker');
        Route::post('uker/store', [UnitKerjaController::class, 'store'])->name('uker.store');
        Route::post('uker/update/{id}', [UnitKerjaController::class, 'update'])->name('uker.update');

        Route::get('akses', [UserAksesController::class, 'show'])->name('akses');
        Route::post('akses/store', [UserAksesController::class, 'store'])->name('akses.store');
        Route::post('akses/update/{id}', [UserAksesController::class, 'update'])->name('akses.update');
    });
});
