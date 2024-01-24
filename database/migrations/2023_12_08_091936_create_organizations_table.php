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
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->foreignId("detail_id")->constrained()->onDelete("cascade");
            $table->string("company_name")->nullable();
            $table->string("activity_name")->nullable();
            $table->string("country")->nullable();
            $table->string("stage_name")->nullable();
            $table->string("target_country_name")->nullable();
            $table->string("template_volume")->nullable();
            $table->integer("template_price")->nullable();
            $table->string("product_volume")->nullable();
            $table->integer("product_price")->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organizations');
    }
};
