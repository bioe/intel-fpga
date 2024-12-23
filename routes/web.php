<?php

use App\Http\Controllers\LineItemManagerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductGroupController;
use App\Http\Controllers\ProductTypeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SpeedController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return redirect('/login');
    // return Inertia::render('Welcome', [
    //     'canLogin' => Route::has('login'),
    //     'canRegister' => Route::has('register'),
    //     'laravelVersion' => Application::VERSION,
    //     'phpVersion' => PHP_VERSION,
    // ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth', 'admin')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('users')->name('users.')->group(function () {
        //Do Something later
        Route::patch('menu/{id}', [UserController::class, 'patchMenu'])->name('menu.update');
    });
    Route::resource('users', UserController::class);
    Route::resource('product_types', ProductTypeController::class);
    Route::resource('products', ProductController::class);
    Route::resource('product_groups', ProductGroupController::class);

    Route::post('/speed/import', [SpeedController::class, 'import'])->name('speed.import');
    Route::resource('speed', SpeedController::class);

    Route::resource('lineitem_managers', LineItemManagerController::class);
});

require __DIR__ . '/auth.php';
