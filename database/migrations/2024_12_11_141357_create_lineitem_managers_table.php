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
        Schema::create('lineitem_managers', function (Blueprint $table) {
            $table->id();
            $table->string('module'); //Master Data
            $table->integer('revision');
            $table->boolean('approved')->default(false);
            $table->unsignedBigInteger('approved_user_id')->nullable();
            $table->unsignedBigInteger('product_type_id'); //Product Type
            $table->unsignedBigInteger('product_id'); //Product Code Name
            $table->unsignedBigInteger('product_group_id'); //Product Group
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lineitem_managers');
    }
};
