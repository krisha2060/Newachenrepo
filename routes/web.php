<?php

use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class,'index'])->name('home');
Route::get('/reservation', [HomeController::class, 'index1'])->name('reservation');



Route::prefix('admin')->group(function () {
    require base_path('routes/admin.php');
});
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');