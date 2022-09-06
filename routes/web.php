<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\AuthController;

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

Route::group(['prefix' => '/'], function() {
    Route::get('/', function () {
        return view('landing');
    })->name('landing');
    Route::get('/about', function () {
        return view('about');
    });
    Route::get('/contact', function () {
        return view('contact');
    });
    Route::get('/signin', function () {
        if (Auth::check()) {
            return redirect('dashboard');
        }
        return view('login');
    })->name('login');
});

Route::group(['prefix' => 'dashboard', 'middleware' => 'auth'], function() {
    Route::get('/', [Dashboard::class, 'index'])->name('dashboard');
    Route::get('/users', [Dashboard::class, 'users'])->name('users');
    Route::post('/users', [Dashboard::class, 'add_account'])->name('users.add')->middleware('checkRole:admin');
    Route::get('/users/{biodata_id}', [Dashboard::class, 'usersEdit'])->name('usersEdit')->middleware('checkRole:admin');
    Route::put('/users/{user_id}/{biodata_id}', [Dashboard::class, 'userEdit_action'])->name('userEdit_action')->middleware('checkRole:admin');
    Route::delete('/users/{biodata_id}', [Dashboard::class, 'remove_account'])->name('users.remove')->middleware('checkRole:admin');

    Route::get('/aspek', [Dashboard::class, 'aspek'])->name('aspek')->middleware('checkRole:admin,guru');
});

Route::group(['prefix' => 'auth'], function() {
    Route::post('login', [AuthController::class, 'login'])->name('login.action');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout.action')->middleware('checkRole:admin,guru,siswa');
});