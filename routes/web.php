<?php

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

Route::get('/qr', function () {
    echo \Milon\Barcode\Facades\DNS2DFacade::getBarcodeHTML('4445645656', 'QRCODE');
    //return view('welcome');
});

Route::get('/', function () {return redirect('login');});
Route::get('/register', function () {return redirect('login');});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', [\App\Http\Controllers\DashboardController::class,'index'])->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->resource('department', \App\Http\Controllers\DepartmentController::class)->names('department');
Route::middleware(['auth:sanctum', 'verified'])->resource('user', \App\Http\Controllers\UserController::class)->names('user');

Route::middleware(['auth:sanctum', 'verified'])->get('send', [\App\Http\Controllers\FileController::class,'send'])->name('file.send');
Route::middleware(['auth:sanctum', 'verified'])->get('receive', [\App\Http\Controllers\FileController::class,'receive'])->name('file.receive');
Route::middleware(['auth:sanctum', 'verified'])->get('create_receive', [\App\Http\Controllers\FileController::class,'createReceive'])->name('create_receive');
Route::middleware(['auth:sanctum', 'verified'])->post('file_create_receive_store', [\App\Http\Controllers\FileController::class,'storeCreateReceive'])->name('file_create_receive_store');
Route::middleware(['auth:sanctum', 'verified'])->get('checkattachments', [\App\Http\Controllers\FileController::class,'checkattachments'])->name('file.checkattachments');

Route::middleware(['auth:sanctum', 'verified'])->get('file/{file}/printlabel', [\App\Http\Controllers\FileController::class,'printlabel'])->name('file.printlabel');
Route::middleware(['auth:sanctum', 'verified'])->get('file/{file}/reopen', [\App\Http\Controllers\FileController::class,'reopen'])->name('file.reopen');
Route::middleware(['auth:sanctum', 'verified'])->get('file/{file}/close', [\App\Http\Controllers\FileController::class,'close'])->name('file.close');
Route::middleware(['auth:sanctum', 'verified'])->get('reports', [\App\Http\Controllers\FileController::class,'reports'])->name('reports');
Route::middleware(['auth:sanctum', 'verified'])->get('reports/receive', [\App\Http\Controllers\FileController::class,'reports_receive'])->name('reports_receive');
Route::middleware(['auth:sanctum', 'verified'])->get('reports/dispatch', [\App\Http\Controllers\FileController::class,'reports_dispatch'])->name('reports_dispatch');

Route::middleware(['auth:sanctum', 'verified'])->get('fileup', [\App\Http\Controllers\DashboardController::class,'fileup'])->name('fileup');
Route::middleware(['auth:sanctum', 'verified'])->get('depfilesd', [\App\Http\Controllers\DashboardController::class,'depfilesd'])->name('depfilesd');

/*Route::middleware(['auth:sanctum', 'verified'])->get('filereceived', [\App\Http\Controllers\DashboardController::class,'filereceived'])->name('filereceived');
Route::middleware(['auth:sanctum', 'verified'])->get('filereceivedin', [\App\Http\Controllers\DashboardController::class,'filereceivedin'])->name('filereceivedin');
Route::middleware(['auth:sanctum', 'verified'])->get('filereceivedout', [\App\Http\Controllers\DashboardController::class,'filereceivedout'])->name('filereceivedout');*/


Route::middleware(['auth:sanctum', 'verified'])->resource('file', \App\Http\Controllers\FileController::class)->names('file');

