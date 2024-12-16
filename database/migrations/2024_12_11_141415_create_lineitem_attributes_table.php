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
        Schema::create('lineitem_attributes', function (Blueprint $table) {
            $table->id();
            $table->boolean('active')->default(true);
            $table->string('symbol')->nullable();
            $table->string('attribute_name')->nullable();
            $table->string('value')->nullable();
            $table->string('expression')->nullable();
            $table->unsignedBigInteger('lineitem_manager_id');
            $table->unsignedBigInteger('lineitem_attributes_id'); //module origin id
            $table->string('lineitem_attributes_type'); //module origin table
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lineitem_attributes');
    }
};
