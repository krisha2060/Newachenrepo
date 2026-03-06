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
    Schema::table('order_addon_items', function (Blueprint $table) {
        $table->dropForeign(['item_id']); // remove foreign key first
        
        $table->unsignedBigInteger('item_id')->nullable()->change(); // make nullable
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_addon_items', function (Blueprint $table) {
            //
        });
    }
};
