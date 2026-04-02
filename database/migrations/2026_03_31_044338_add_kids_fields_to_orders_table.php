<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('kids_package_id')
                  ->nullable()
                  ->after('package_id')
                  ->constrained('packages')
                  ->nullOnDelete();
            $table->unsignedTinyInteger('kids_count')
                  ->nullable()
                  ->after('kids_package_id');
            $table->decimal('kids_package_total', 10, 2)
                  ->nullable()
                  ->after('kids_count');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['kids_package_id']);
            $table->dropColumn(['kids_package_id', 'kids_count', 'kids_package_total']);
        });
    }
};