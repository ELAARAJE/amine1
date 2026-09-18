<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('opening_hours', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('day_of_week'); // 0=Sunday … 6=Saturday
            $table->string('service'); // lunch | dinner
            $table->time('start_time');
            $table->time('end_time');
            $table->boolean('is_open')->default(true);
            $table->timestamps();

            $table->unique(['day_of_week', 'service']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('opening_hours');
    }
};
