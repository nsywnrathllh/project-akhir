<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('guests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicles_id')->constrained('vehicles')->cascadeOnDelete();
            $table->string('name');
            $table->bigInteger('phone');
            $table->enum('destination', ['TU', 'Walikelas', 'Guru', 'Bendahara', 'Kurikulum', 'Kesiswaan', 'Kepala Sekolah', 'Meeting', 'Lainnya']);
            $table->string('purpose');
            $table->time('checkin');
            $table->time('checkout')->nullable();
            $table->mediumText('image')->nullable();
            $table->enum('status', ['Check Out', 'Still Inside'])->default('Still Inside');
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
