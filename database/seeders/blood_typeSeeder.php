<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\blood_type;

class blood_typeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('blood_types')->delete();

        $Bloods = ['O-', 'O+', 'A-', 'A+', 'B-', 'B+', 'AB+', 'AB-'];

        foreach ($Bloods as $Blood) {
            blood_type::create(['name' => $Blood]);
        }
    }
}
