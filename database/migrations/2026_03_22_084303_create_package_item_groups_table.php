<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('package_item_groups', function (Blueprint $table) {
    $table->id();
    $table->foreignId('package_id')->constrained('packages')->onDelete('cascade');
    $table->string('group_name');
    $table->boolean('is_required')->default(1);
    $table->tinyInteger('max_selection')->default(1);
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_item_groups');
    }
};
