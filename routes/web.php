<?php

use App\Http\Controllers\Admin\ApartmentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\VisitController;
use App\Http\Controllers\Api\AnalyticsController;
use App\Models\Visit;
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
    return view('auth.login');
});



// Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->name('admin.')->prefix('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('apartments', ApartmentController::class)->parameters(['apartments' => 'apartment:slug']);
    Route::resource('messages', MessageController::class)->parameters(['messages' => 'message:id']);
    Route::resource('analytics', VisitController::class);
    Route::get('apartments/{apartment}/sponsor-apartment', [ApartmentController::class, 'sponsorship'])->name('apartments.sponsorship');
    Route::post('apartments/{apartment}/sponsor-apartment', [ApartmentController::class, 'buySponsorship'])->name('apartments.buySponsorship');
});





require __DIR__ . '/auth.php';
