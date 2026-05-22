<?php

use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Middleware\AuthenticateAdmin;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class,'index'])->name('home');
Route::get('/reservation', [HomeController::class, 'index1'])->name('reservation');



Route::prefix('admin')->group(function () {
    require base_path('routes/admin.php');
});
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::post('/orders/{id}/update', [OrderController::class, 'update'])
    ->middleware(AuthenticateAdmin::class)
    ->name('orders.update');

Route::get('/run-migration-payment-fields', function () {
    Artisan::call('migrate', [
        '--path' => 'database/migrations/2026_03_18_085121_add_payment_fields_to_orders_table.php',
        '--force' => true
    ]);
 
    return 'Migration executed!';
});

Route::get('/run-migration', function () {
    Artisan::call('migrate', [
        '--force' => true // required for production
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

Route::get('/run-migration-create_kids_order_items', function () {
    Artisan::call('migrate', [
        '--path' => 'database/migrations/2026_03_31_044319_create_kids_order_items_table.php',
        '--force' => true
    ]);
 
    return 'Migration executed!';
});

Route::get('/run-migration-add_kids_fields_to_orders_table', function () {
    Artisan::call('migrate', [
        '--path' => 'database/migrations/2026_03_31_044338_add_kids_fields_to_orders_table.php',
        '--force' => true
    ]);
 
    return 'Migration executed!';
});

Route::get('/run-migration-add_delivery_charge_to_orders_table', function () {
    Artisan::call('migrate', [
        '--path' => 'database/migrations/2026_04_01_080201_add_delivery_charge_to_orders_table.php',
        '--force' => true
    ]);
 
    return 'Migration executed!';
});



Route::get('/run-migration-add_quantity_to_order_addon_items_table', function () {
    Artisan::call('migrate', [
        '--path' => 'database/migrations/2026_05_21_101500_add_quantity_to_order_addon_items_table.php',
        '--force' => true
    ]);
 
    return 'Migration executed!';
});


