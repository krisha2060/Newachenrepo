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

Route::get('/run-migration-payment-fields', function () {
    Artisan::call('migrate', [
        '--path' => 'database/migrations/2026_03_18_085121_add_payment_fields_to_orders_table.php',
        '--force' => true
    ]);
 
    return 'Migration executed!';
});


Route::get('/run-migration-group_id', function () {
    Artisan::call('migrate', [
        '--path' => 'database/migrations/2026_03_22_081531_add_group_id_to_package_items_table.php',
        '--force' => true
    ]);
 
    return 'Migration executed!';
});
Route::get('/run-migration-package_item_groups', function () {
    Artisan::call('migrate', [
        '--path' => 'database/migrations/2026_03_22_084303_create_package_item_groups_table.php',
        '--force' => true
    ]);

    return 'Migration executed!';
});


Route::get('/run-migration-create_order_package_selections', function () {
    Artisan::call('migrate', [
        '--path' => 'database/migrations/2026_03_23_050428_create_order_package_selections_table.php',
        '--force' => true
    ]);
 
    return 'Migration executed!';
});


