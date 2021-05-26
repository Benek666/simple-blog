<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;

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

Route::get('/', [HomeController::class, 'index']);

Route::get('/profile/{id}', [HomeController::class, 'showProfile'])->whereNumber('id');

Route::get('/item/{id}', [HomeController::class, 'showItem'])->whereNumber('id');

Route::post('/dodaj_wpis', [HomeController::class, 'addItem']);
Route::post('/edytuj_wpis/{id}', [HomeController::class, 'updateItem']);
Route::get('/usun_wpis/{id}/{user}', [HomeController::class, 'deleteItem']);

Route::post('/dodaj_komentarz', [HomeController::class, 'addItem']);
Route::post('/edytuj_komentarz/{id}', [HomeController::class, 'updateItem']);
Route::get('/usun_komentarz/{id}/{user}', [HomeController::class, 'deleteItem']);

Route::post('/dodaj_komentarz_profil', [HomeController::class, 'addItem']);
Route::post('/edytuj_komentarz_profil/{id}', [HomeController::class, 'updateItem']);
Route::get('/usun_komentarz_profil/{id}/{user}', [HomeController::class, 'deleteItem']);


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
