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
            $table->string("company_name");
            $table->string("activity_name");
            $table->string("country");
            $table->string("stage_name");
            $table->string("target_country_name");
            $table->integer("template_volume");
            $table->integer("template_price");
            $table->integer("product_volume");
            $table->integer("product_price");
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
