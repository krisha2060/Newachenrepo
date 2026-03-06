<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->foreignId('package_id')->constrained();

        // Customer details
        $table->string('customer_name');
        $table->string('customer_phone');
        $table->text('delivery_address')->nullable();

        $table->integer('guest_count');

        // Pricing snapshot
        $table->decimal('package_price', 10, 2);
        $table->decimal('package_total', 10, 2);

        $table->decimal('addon_total', 10, 2)->default(0);
        $table->decimal('grand_total', 10, 2);

        $table->string('order_status')->default('Pending');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
