<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\ArticleController;
use Illuminate\Http\Request;
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
Route::resource('mahasiswa', MahasiswaController::class);
Route::get('/',[MahasiswaController::class, 'index']);
Route::get('mahasiswas/nilai/{mahasiswa}', [MahasiswaController::class, 'nilai'])->name('users.nilai');
Route::resource('articles', ArticleController::class);
// Route::get('articles/cetak_pdf',[ArticleController::class, 'cetak_pdf']);
Route::get('/articles/cetak_pdf',[ArticleController::class, 'cetak_pdf']);



