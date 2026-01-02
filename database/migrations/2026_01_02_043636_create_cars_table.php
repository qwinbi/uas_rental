<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['Brio', 'Jazz', 'Civic', 'HR-V', 'CR-V']);
            $table->text('description');
            $table->decimal('price_per_day', 10, 2);
            $table->integer('seats');
            $table->string('transmission');
            $table->string('fuel_type');
            $table->boolean('available')->default(true);
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cars');
    }
};