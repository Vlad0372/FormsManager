<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FillAppController;
use App\Http\Controllers\AppFormController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('newwelcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Route::delete('/applications', [FillAppController::class, 'edit'])->name('applications');
});
//Route::post('applications', [FillAppController::class, 'tryStartFilling'])->name('toggleApprove');

// Route::get('/applications', [FillAppController::class, 'tryStartFilling'])->middleware(['auth', 'verified'])->name('applications');
// Route::get('/applications/edit', [FillAppController::class, 'edit'])->middleware(['auth', 'verified'])->name('applications.edit');
// Route::post('send', [FillAppController::class, 'store'])->name('applications.send');

Route::get('/app-form/create', [AppFormController::class, 'edit'])->middleware(['auth', 'verified'])->name('app-form.edit');
Route::get('/app-form', [AppFormController::class, 'create'])->middleware(['auth', 'verified'])->name('app-form.create');
Route::post('/app-form', [AppFormController::class, 'store'])->middleware(['auth', 'verified'])->name('app-form.store');
Route::delete('/app-form', [AppFormController::class, 'terminate'])->middleware(['auth', 'verified'])->name('app-form.terminate');

require __DIR__.'/auth.php';
