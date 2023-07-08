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
        Schema::create('company_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id'); // relation with customers
            $table->unsignedBigInteger('city_id'); // direct city_id
            $table->unsignedBigInteger('district_id'); // direct district_id
            
            $table->year('establishment_year');   
            $table->text('about_company');
            $table->text('message');

            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('district_id')->references('id')->on('districts');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_details');
    }
};
