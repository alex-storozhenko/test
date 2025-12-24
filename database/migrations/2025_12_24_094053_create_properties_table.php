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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->ulid();
            $table->string('internal_reference');
            $table->string('title');
            $table->string('street');
            $table->string('number');
            $table->string('zipcode');
            $table->boolean('is_active')->default(false);
            $table->boolean('is_sell')->default(false);
            $table->boolean('is_rent')->default(false);
            $table->decimal('sell_price')->nullable();
            $table->decimal('rental_price')->nullable();
            $table->decimal('built_m2');

            $table->foreignId('office_id')->constrained('offices');
            $table->foreignId('property_type_id')->constrained('property_types');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('secondary_user_id')->nullable()->constrained('users');
            $table->foreignId('neighborhood_id')->nullable()->constrained('neighborhoods');
            $table->foreignId('district_id')->nullable()->constrained('districts');
            $table->foreignId('municipality_id')->nullable()->constrained('municipalities');
            $table->foreignId('region_id')->nullable()->constrained('regions');
            $table->foreignId('location_id')->nullable()->constrained('locations');

            $table->timestamps();
        });
    }
};
