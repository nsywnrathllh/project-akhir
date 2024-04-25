<?php

namespace Database\Seeders;

use App\Models\NotificationTarget;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NotificationTargetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $target = [
            [
                'phone' => '085219135188',
                'destination' => 'Kurikulum',
            ],
            [
                'phone' => '08121849933',
                'destination' => 'Hubin',
            ],
            [
                'phone' => '082280001162',
                'destination' => 'Kesiswaan',
            ],
            [
                'phone' => '085889129620',
                'destination' => 'Walikelas',
            ],
        ];

        foreach ($target as $key => $value) {
            NotificationTarget::create($value);
        }
    }
}
