<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Profession;

class ProfessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
        // We can make raw queries by this way
        DB::insert('INSERT INTO professions (title) VALEUS (:title)', [
            'title' => "Back-end developer"
        ]);*/

        /*
        DB::table('professions')->insert([
            'title' => 'Back-end developer'
        ]);*/

        Profession::create([
            'title' => 'Back-end developer'
        ]);

        Profession::create([
            'title' => 'Front-end developer'
        ]);
        Profession::create([
            'title' => 'Web designer'
        ]);
    }
}
