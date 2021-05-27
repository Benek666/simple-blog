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

Route::get('/profile/{id}/comment/{comment_id}', [HomeController::class, 'showProfile'])->whereNumber('id')->whereNumber('comment_id');
Route::get('/profile/{id}', [HomeController::class, 'showProfile'])->whereNumber('id');

Route::get('/item/{id}/comment/{comment_id}', [HomeController::class, 'showItem'])->whereNumber('id')->whereNumber('comment_id');
Route::get('/item/{id}', [HomeController::class, 'showItem'])->whereNumber('id');


Route::post('/add_comment', [HomeController::class, 'addComment']);
Route::get('/remove_comment/{id}', [HomeController::class, 'removeComment'])->whereNumber('id');
Route::post('/update_comment', [HomeController::class, 'updateComment']);

Route::post('/add_item', [HomeController::class, 'addItem']);
Route::post('/update_item/{id}', [HomeController::class, 'updateItem'])->whereNumber('id');
Route::get('/remove_item/{id}', [HomeController::class, 'removeItem'])->whereNumber('id');



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
