<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('statuses', static function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->string('color')->default('#000000');
            $table->string('text_color')->default('#FFFFFF');
            $table->string('type');
            $table->boolean('is_started')->default(false);
            $table->boolean('is_ended')->default(false);
            $table->integer('weight')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('statuses');
    }
};
