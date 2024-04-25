<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sourcePath = public_path('logo/logo-nobg.png');
        File::copy($sourcePath, public_path('logo/logo-nobg.png'));
        Setting::create([
            'name' => 'Buku Tamu Digital',
            'address' => 'Jl. Raya Karadenan No.7, Karadenan, Kec. Cibinong, Kabupaten Bogor, Jawa Barat 16111',
        ]);
    }
}
