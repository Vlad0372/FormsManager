<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MyAppFormsController;
use App\Http\Controllers\AppFormController;
use App\Http\Controllers\AppFormSettingsController;
use App\Http\Controllers\BipParserController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/app-form/edit', [AppFormController::class, 'edit'])->name('app-form.edit');
    Route::get('/app-form', [AppFormController::class, 'create'])->name('app-form.create');
    Route::post('/app-form', [AppFormController::class, 'store'])->name('app-form.store');
    Route::delete('/app-form', [AppFormController::class, 'terminate'])->name('app-form.terminate');
});

Route::middleware('auth')->group(function () {
    Route::get('/my-app-forms', [MyAppFormsController::class, 'index'])->name('my-app-forms');
    Route::get('/my-app-forms/{id}/edit', [MyAppFormsController::class, 'edit'])->name('my-app-forms.edit');
    Route::patch('/my-app-forms', [MyAppFormsController::class, 'update'])->name('my-app-forms.update');
    Route::delete('/my-app-forms', [MyAppFormsController::class, 'destroy'])->name('my-app-forms.destroy');
    Route::get('/my-app-forms/pdf', [MyAppFormsController::class, 'pdfStream'])->name('my-app-forms.pdfStream');
});

Route::middleware('auth')->group(function () {
    Route::get('/app-form-settings', [AppFormSettingsController::class, 'edit'])->name('app-form-settings.edit');
});

Route::middleware('auth')->group(function () {
    //Route::get('/bip-parser', [BipParserController::class, 'index'])->name('bip-parser');
    //Route::get('/bip-parser/results', [BipParserController::class, 'showResults'])->name('bip-parser.showResults');
    Route::get('/bip-parser/results', [BipParserController::class, 'showResults'])->name('bip-parser');
});

require __DIR__.'/auth.php';
