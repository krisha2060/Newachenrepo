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
        Schema::table('orders', function (Blueprint $table) {
            // Add these 4 fields
            $table->string('email')->nullable()->after('customer_phone');
            $table->date('event_date')->nullable()->after('delivery_address');
            $table->string('event_time')->nullable()->after('event_date');
            $table->text('notes')->nullable()->after('grand_total');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['email', 'event_date', 'event_time', 'notes']);
        });
    }
};
