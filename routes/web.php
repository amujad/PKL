<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PengirimanController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\loginController;

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

Route::get('/', function () {
    return view('auth.login');
});

Route::post('/cari', [PengirimanController::class, 'getPengiriman'])->name('cari');

Route::post('login',[LoginController::class, 'login'])->name('login');
Route::get('logout',[LoginController::class, 'logout'])->name('logout');
Auth::routes();

//AllUser
Route::get('profile',[PageController::class,'profile'])->name('profile');
Route::post('profile',[UserController::class,'profile'])->name('gantiprofile');
Route::get('ganti-password',[PageController::class,'gantiPw'])->name('ganti-password');
Route::post('ganti-password',[UserController::class,'gantiPw'])->name('gantiPassword');

//User Admin
Route::middleware('isAdmin')->group(function(){
    Route::get('admin',[PageController::class,'dashboardAdmin'])->name('dashboardAdmin');
    Route::get('admin/users', [PageController::class, 'user'])->name('home');
    Route::post('user',[UserController::class, 'store'])->name('newUser');
    Route::post('getPos',[UserController::class, 'getPos'])->name('getPos');
    Route::post('editUser',[UserController::class, 'update'])->name('update');
    Route::delete('user',[UserController::class, 'destroy'])->name('delete'); 
    Route::get('admin/pengiriman', [PageController::class, 'pengiriman'])->name('pengiriman');
    Route::post('kirim',[PengirimanController::class, 'createUAdmin'])->name('createByAdmin');
    Route::post('editKirim', [PengirimanController::class, 'update'])->name('updateKirim');
    Route::delete('kirim',[PengirimanController::class, 'destroy'])->name('deleteKirim'); 
    Route::post('reset',[UserController::class, 'resetPw'])->name('reset');
});

//User Pos
Route::middleware('isPos')->group(function(){
    Route::get('pos',[PageController::class,'dashboardPos'])->name('dashboardPos');
    Route::get('pos/Tugas',[PageController::class, 'pos'])->name('pos');
    Route::get('pos/pengiriman-baru',[PageController::class, 'kirimBaru'])->name('pengirimanBaru');
    Route::post('newKirimPos', [PengirimanController::class,'createUPos'])->name('createByPos');
    Route::get('pos/pdf/{id}',[PengirimanController::class,'createPDF'])->name('pdf');
    Route::get('pos/pengiriman-terkirim',[PageController::class,'terkirim'])->name('terkirim');
    Route::get('pos/pengiriman-terkirim/{noreg}',[PageController::class,'terkirimII'])->name('terkirimII');
    Route::post('terkirim',[PengirimanController::class,'resi'])->name('terkirimResi');
    Route::get('pos/wa/{reg}',[PengirimanController::class,'whatsapp'])->name('wa');
    Route::post('editKirim2', [PengirimanController::class, 'update2'])->name('updateKirim');
});


//User MejaIII
Route::middleware('isMejaIII')->group(function(){
    Route::get('mejaIII/',[PageController::class, 'mejaIII'])->name('mejaIII');
    Route::get('mejaIII/{status}',[PageController::class, 'statusMejaIII'])->name('mejaIIIbyStatus');
    Route::post('dataAkta',[PengirimanController::class, 'dataAkta'])->name('dataAkta');
    Route::post('editAkta',[PengirimanController::class, 'editAkta'])->name('editAkta');   
});
