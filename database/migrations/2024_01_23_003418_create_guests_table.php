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
            $table->string('name');
            $table->string('phone');
            $table->string('alliance');
            $table->enum('destination', ['TU', 'Walikelas', 'Guru', 'Bendahara', 'Kurikulum', 'Kesiswaan', 'Kepala Sekolah', 'Meeting', 'Lainnya']);
            $table->text('purpose');
            $table->string('scan_ktp');
            $table->enum('has_vehicle', ['Yes', 'No']);
            $table->dateTime('checkin');
            $table->dateTime('checkout')->nullable();
            $table->mediumText('image_path')->nullable();
            $table->enum('status', ['Check Out', 'Still Inside'])->default('Still Inside');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('guests')) {
            Schema::table('guests', function (Blueprint $table) {
                $table->dropColumn('image_path');
            });
        }
    }
};
