<?php

use App\Http\Controllers\BeritaacaraController;
use App\Http\Controllers\ggnpenyebabcontroller;
use App\Http\Controllers\JenistiketController;
use App\Http\Controllers\JobdeskController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\Lmaterial;
use App\Http\Controllers\RekapBaController;
use App\Http\Controllers\saldocontroller;
use App\Http\Controllers\Sektorcontroller;
use App\Http\Controllers\TeamdetailController;
use App\Http\Controllers\TeamlistController;
use App\Http\Controllers\TiketlistController;
use App\Http\Controllers\TikettimController;
use Illuminate\Support\Facades\Route;

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

$controller_path = 'App\Http\Controllers';

// Main Page Route
//project
//user
// authentication
Route::get('/auth/login', $controller_path . '\authentications\LoginBasic@index')->name('login');
Route::post('/auth/postlogin', $controller_path . '\authentications\LoginBasic@login')->name('log-in');
Route::post('/auth/logout', $controller_path . '\authentications\LoginBasic@logout')->name('logout');

//master role
Route::group(['middleware' => ['auth', 'CekRole:Master']], function () {
    $controller_path = 'App\Http\Controllers';
    Route::get('/page/user', $controller_path . '\authentications\LoginBasic@page')->name('usr');
    Route::post('/auth/signin', $controller_path . '\authentications\LoginBasic@signin')->name('signin');
    Route::get('/auth/register', $controller_path . '\authentications\LoginBasic@register')->name('register');
    Route::get('/auth/forgot-password', $controller_path . '\authentications\ForgotPasswordBasic@index')->name('reset-password');
    Route::get('/page/edt-user/{id}', $controller_path . '\authentications\LoginBasic@edit')->name('edt.usr');
    Route::post('/page/up-user/{id}', $controller_path . '\authentications\LoginBasic@update')->name('up.usr');
    Route::get('/page/dlt-user/{id}', $controller_path . '\authentications\LoginBasic@delete')->name('dlt.usr');

    //list material
    Route::get('/lmaterial', [Lmaterial::class, 'index'])->name('lm');
    Route::get('/tbh_material', [Lmaterial::class, 'create'])->name('tbh.lm');
    Route::post('/spn_material', [Lmaterial::class, 'store'])->name('spn.mm');
    Route::get('/edt_material/{id}', [Lmaterial::class, 'edit'])->name('edt.mm');
    Route::post('/up_material/{kd_material}', [Lmaterial::class, 'update'])->name('up.lm');
    Route::get('/dlt_material/{id}', [Lmaterial::class, 'delete'])->name('dlt.mm');
    Route::get('/material/search', [Lmaterial::class, 'search'])->name('search.lm');

    //penyuebab gangguan
    Route::get('/pg-ggn', [ggnpenyebabcontroller::class, 'index'])->name('pg');
    Route::get('/pg-create', [ggnpenyebabcontroller::class, 'create'])->name('pg-create');
    Route::get('/pg-edit/{id}', [ggnpenyebabcontroller::class, 'edit'])->name('pg-edit');
    Route::post('/pg-store', [ggnpenyebabcontroller::class, 'store'])->name('pg-store');
    Route::post('/pg-up/{id}', [ggnpenyebabcontroller::class, 'update'])->name('pg-up');
    Route::get('/pg-dlt/{id}', [ggnpenyebabcontroller::class, 'delete'])->name('pg-dlt');
});


//admin role
//karyawan
Route::group(['middleware' => ['auth', 'CekRole:Master,Admin']], function () {
    // Route::get('/', [KaryawanController::class, 'index']);
    Route::get('/karyawan', [KaryawanController::class, 'index'])->name('kyw');
    Route::get('/karyawan-tbh', [KaryawanController::class, 'create'])->name('tbh.kyw');
    Route::post('/karyawan-spn', [KaryawanController::class, 'store'])->name('spn.kyw');
    Route::post('/karyawan-up/{id}', [KaryawanController::class, 'update'])->name('up.kyw');
    Route::get('/karyawan-edt/{id}', [KaryawanController::class, 'edit'])->name('edt.kyw');
    Route::get('/karyawan-dlt/{id}', [KaryawanController::class, 'delete'])->name('dlt.kyw');
    Route::get('/karyawan/search', [KaryawanController::class, 'search'])->name('search.kyw');
    Route::get('/karyawan-ctk', [KaryawanController::class, 'print'])->name('ctk.kyw');

    //jobdesk
    Route::get('/jd', [JobdeskController::class, 'index'])->name('jd');
    Route::get('/jd-tambah', [Jobdeskcontroller::class, 'create'])->name('tambah.jd');
    Route::post('/jd-simpan', [Jobdeskcontroller::class, 'store'])->name('simpan.jd');
    Route::post('/jd-update/{id}', [Jobdeskcontroller::class, 'update'])->name('up.jd');
    Route::get('/jd-edit/{id}', [Jobdeskcontroller::class, 'edit'])->name('edt.jd');
    Route::get('/jd-dlt/{id}', [Jobdeskcontroller::class, 'delete'])->name('dlt.jd');
    Route::get('/jd/search', [JobdeskController::class, 'search'])->name('search.jd');

    //jenistiket
    Route::get('/jtiket', [JenistiketController::class, 'index'])->name('jt');
    Route::get('/jtiket-tambah', [JenistiketController::class, 'create'])->name('tambah.jt');
    Route::post('/jtiket-simpan', [JenistiketController::class, 'store'])->name('simpan.jt');
    Route::post('/jtiket-update/{id}', [JenistiketController::class, 'update'])->name('up.jt');
    Route::get('/jtiket-edit/{id}', [JenistiketController::class, 'edit'])->name('edt.jt');
    Route::get('/jtiket-dlt/{id}', [JenistiketController::class, 'delete'])->name('dlt.jt');
    Route::get('/jtiket/search', [JenistiketController::class, 'search'])->name('search.jt');

    //Daftar Tiket
    Route::get('/tiket/printggn', [TiketlistController::class, 'print'])->name('print.tkt');
    Route::get('/tiket/printpsb', [TiketlistController::class, 'printpsb'])->name('print.psb');
    Route::get('/tiket/printmtn', [TiketlistController::class, 'printmtn'])->name('print.mtn');

    //Utama
    Route::get('/ggntiket', [TiketlistController::class, 'ggnindex'])->name('ggn');
    Route::get('/mtntiket', [TiketlistController::class, 'mtnindex'])->name('mtn');
    Route::get('/psbtiket', [TiketlistController::class, 'psindex'])->name('psb');

    Route::get('/tiket-cari', [TiketlistController::class, 'search'])->name('cari.ggn');
    Route::get('/tiket-tambah-psb', [TiketlistController::class, 'pscreate'])->name('tbh.psb');
    Route::get('/tiket-tambah-ggn', [TiketlistController::class, 'ggncreate'])->name('tbh.ggn');
    Route::get('/tiket-tambah-mtn', [TiketlistController::class, 'mtncreate'])->name('tbh.mtn');
    Route::post('/tiket-simpan-psb', [TiketlistController::class, 'psstore'])->name('spn.psb');
    Route::post('/tiket-simpan-ggn', [TiketlistController::class, 'ggnstore'])->name('spn.ggn');
    Route::post('/tiket-simpan-mtn', [TiketlistController::class, 'mtnstore'])->name('spn.mtn');

    Route::get('tiket-detail/{id}', [TikettimController::class, 'detail'])->name('edt.detail');
    Route::post('update-detail/{id}', [TikettimController::class, 'updtl'])->name('up.detail');


    Route::post('/tiket-update/{id}', [TiketlistController::class, 'ggnupdate'])->name('up.ggn');
    Route::get('/tiket-edit/{id}', [TiketlistController::class, 'ggnedit'])->name('edt.ggn');
    Route::get('/tiket-dlt/{id}', [TiketlistController::class, 'ggndelete'])->name('dlt.ggn');

    //tiket update

    //sektor
    Route::get('/sektor',[Sektorcontroller::class, 'index'])->name('sektor');
    Route::get('/sektor-tambah',[Sektorcontroller::class, 'create'])->name('sektor-tbh');
    Route::post('/sektor-spn',[Sektorcontroller::class, 'store'])->name('sektor-spn');
    Route::get('/sektor-edit/{id}',[Sektorcontroller::class, 'edit'])->name('sektor-edt');
    Route::post('/sektor-up/{id}',[Sektorcontroller::class, 'update'])->name('sektor-up');
    Route::get('/sektor-dlt/{id}',[Sektorcontroller::class, 'delete'])->name('sektor-dlt');

    //Tiket Tambah


    //teamlist
    Route::get('/tl', [TeamlistController::class, 'index'])->name('tl');
    Route::get('/tl-tambah', [TeamlistController::class, 'create'])->name('tl-tbh');
    Route::post('/tl-simpan', [TeamlistController::class, 'store'])->name('spn.tl');
    Route::post('/tl-update/{id}', [TeamlistController::class, 'update'])->name('up.tl');
    Route::get('/tl-edit/{id}', [TeamlistController::class, 'edit'])->name('edt.tl');
    Route::get('/tl-dlt/{id}', [TeamlistController::class, 'delete'])->name('dlt.tl');
    Route::get('/tl/search', [TeamlistController::class, 'search'])->name('search.tl');

    //teamdetail
    Route::get('/td', [TeamdetailController::class, 'index'])->name('td');
    Route::get('/td-tambah', [TeamdetailController::class, 'create'])->name('tbh.td');
    Route::post('/td-simpan', [TeamdetailController::class, 'store'])->name('spn.td');
    Route::post('/td-update/{id}', [TeamdetailController::class, 'update'])->name('up.td');
    Route::get('/td-edit/{id}', [TeamdetailController::class, 'edit'])->name('edt.td');
    Route::get('/td-dlt/{id}', [TeamdetailController::class, 'delete'])->name('dlt.td');
    Route::get('/td/search', [TeamdetailController::class, 'search'])->name('search.td');
    Route::get('/td/cetak', [TeamdetailController::class, 'print'])->name('cetak.td');

    //berita acara
    Route::get('/ba/print', [BeritaacaraController::class, 'print'])->name('print.ba');
    Route::get('/ba/merge', [BeritaacaraController::class, 'mergepdf'])->name('merge.ba');

    //alur tiket
    Route::get('/tiket_team/print', [TikettimController::class, 'print'])->name('print.tiket');

    //rekap berita acara
    Route::get('/rba/print', [RekapBaController::class, 'print'])->name('print.rba');

    Route::get('/tiket_team-psb', [TikettimController::class, 'index_psb'])->name('tiket-psb');
    Route::get('tiket_print-psb', [TikettimController::class, 'print_psb'])->name('print.tiket-psb');
    Route::get('/tiket_team-ggn', [TikettimController::class, 'index_ggn'])->name('tiket-ggn');
    Route::get('/tiket_team-mtn', [TikettimController::class, 'index_mtn'])->name('tiket-mtn');

    Route::get('/saldo_edit/{id}/{bln}', [saldocontroller::class, 'edit'])->name('edt.sld');
    Route::post('/saldo_up/{id_tim}/{bln}', [saldocontroller::class, 'update'])->name('up.sld');
    Route::get('/history-saldo', [saldocontroller::class, 'index_history'])->name('hsld');
    Route::get('/history-edit/{id}', [saldocontroller::class, 'edit_history'])->name('e.hsld');
    Route::post('/history-update/{id}', [saldocontroller::class, 'update_history'])->name('up.hsld');
    Route::get('/history-delete/{id}', [saldocontroller::class, 'delete_history'])->name('dlt.hsld');
});


//teknisi role
Route::group(['middleware' => ['auth', 'CekRole:Master,Admin,Teknisi']], function () {
    //Tiket
    $controller_path = 'App\Http\Controllers';
    Route::get('/', $controller_path . '\dashboard\Analytics@index')->name('dashboard');

    //ba
    Route::get('/ba', [BeritaacaraController::class, 'index'])->name('ba');
    Route::get('/ba-tambah', [BeritaacaraController::class, 'create'])->name('tbh.ba');
    Route::post('/ba-simpan', [BeritaacaraController::class, 'store'])->name('spn.ba');
    Route::post('/ba-update/{id}', [BeritaacaraController::class, 'update'])->name('up.ba');
    Route::get('/ba-edit/{id}', [BeritaacaraController::class, 'edit'])->name('edt.ba');
    Route::get('/ba-dlt/{id}', [BeritaacaraController::class, 'delete'])->name('dlt.ba');
    Route::get('/ba/search', [BeritaacaraController::class, 'search'])->name('search.ba');
    Route::get('/ba/show/{id}/{file_ba}', [BeritaacaraController::class, 'show'])->name('shw.ba');

    //tiket
    Route::get('/tiket_team', [TikettimController::class, 'index'])->name('tiket');
    Route::get('/tiket_team-tambah', [TikettimController::class, 'create'])->name('tbh.tiket');
    Route::post('/tiket_team-simpan', [TikettimController::class, 'store'])->name('spn.tiket');
    Route::post('/tiket_team-update/{id}', [TikettimController::class, 'update'])->name('up.tiket');
    Route::get('/tiket_team-edit/{id}', [TikettimController::class, 'edit'])->name('edt.tiket');
    Route::get('/tiket_team-dlt/{id}', [TikettimController::class, 'delete'])->name('dlt.tiket');
    Route::get('/tiket_team/search', [TikettimController::class, 'search'])->name('search.tiket');

    //rba
    Route::get('/rba', [RekapBaController::class, 'index'])->name('rba');
    Route::get('/rba/merge', [RekapBaController::class, 'mergepdf'])->name('merge.rba');
    Route::get('/rba-tambah', [RekapBaController::class, 'create'])->name('tbh.rba');
    Route::post('/rba-simpan', [RekapBaController::class, 'store'])->name('spn.rba');
    Route::post('/rba-update/{id}', [RekapBaController::class, 'update'])->name('up.rba');
    Route::get('/rba-edit/{id}', [RekapBaController::class, 'edit'])->name('edt.rba');
    Route::get('/rba-dlt/{id}', [RekapBaController::class, 'delete'])->name('dlt.rba');
    // Route::get('/rba/search', [RekapBaController::class, 'search'])->name('search.rba');
    Route::get('/rba/show/{id}/{file_ba}', [RekapBaController::class, 'show'])->name('shw.rba');

    Route::get('/saldo', [saldocontroller::class, 'index'])->name('sld');
});
