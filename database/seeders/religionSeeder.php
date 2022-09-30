<?php

namespace Database\Seeders;

use App\Models\religion;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class religionSeeder extends Seeder
{

    public function run()
    {
        DB::table('religions')->delete();

        $religions = [

            [
                'en' => 'Muslim',
                'ar' => 'مسلم'
            ],
            [

                'en' => 'Christian',
                'ar' => 'مسيحي'
            ],
            [

                'en' => 'Other',
                'ar' => 'اخرى'
            ],
        ];


        foreach ($religions as $religion) {
            religion::create(['name' => $religion]);
        }
    }
}
