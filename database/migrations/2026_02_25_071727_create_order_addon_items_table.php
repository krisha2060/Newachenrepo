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
    Schema::create('order_addon_items', function (Blueprint $table) {
        $table->id();

        $table->foreignId('order_id')->constrained()->cascadeOnDelete();
        $table->foreignId('item_id')->constrained();//null

        $table->string('item_name'); // snapshot
        $table->decimal('price_per_pax', 10, 2);
        $table->integer('guest_count');
        $table->decimal('total_price', 10, 2);

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_addon_items');
    }
};
