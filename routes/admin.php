<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Middleware\AuthenticateAdmin;



// Login page
Route::get('/login', function () {
    return view('admin.login');
})->name('admin.login');

// Login POST
Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect('/admin/dashboard');
    }

    return back()->withErrors(['email' => 'Invalid credentials']);
})->name('admin.login.post');

// Protected admin routes — attach middleware directly

Route::get('/dashboard', [App\Http\Controllers\Admin\BookingController::class, 'index'])
    ->middleware(AuthenticateAdmin::class)
    ->name('admin.dashboard');

Route::get('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('admin.login');
})->name('admin.logout');


   Route::get('/datewisebookings', [App\Http\Controllers\Admin\BookingController::class, 'datewise'])
    ->middleware(AuthenticateAdmin::class)
    ->name('admin.datewisebookings');


    // Update booking status (confirm, cancel, payment done)
    Route::post('/update-status', [App\Http\Controllers\Admin\BookingController::class, 'updateStatus'])->name('admin.update-status');



    Route::get('/print-single/{id}', [App\Http\Controllers\Admin\BookingController::class, 'printSingle'])
    ->middleware(AuthenticateAdmin::class)
    ->name('admin.print-single');

Route::get('/print-all', [App\Http\Controllers\Admin\BookingController::class, 'printAll'])
    ->middleware(AuthenticateAdmin::class)
    ->name('admin.print-all');

Route::get('/export-excel', [App\Http\Controllers\Admin\BookingController::class, 'exportExcel'])
    ->middleware(AuthenticateAdmin::class)
    ->name('admin.export-excel');
