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
        Schema::create('guests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('phone');
            $table->enum('destination', ['TU', 'Walikelas', 'Guru', 'Bendahara', 'Kurikulum', 'Kesiswaan', 'Kepala Sekolah', 'Meeting', 'Lainnya']);
            $table->string('purpose');
            $table->time('checkin');
            $table->time('checkout');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guests');
    }
};
