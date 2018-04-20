<?php

use App\Models\User;
use App\Models\Profession;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	// $profession = DB::select('SELECT id FROM professions WHERE title = ?', ['Back-end developer']);

    	/*
		
		$profession = DB::table('professions')->select('id')->take(1)->get();
		$profession->first()->id
		
		*/

        /*
		$profession = DB::table('professions')->select('id')->where('title', '=', 'Back-end developer  ')->first();

        DB::table('users')->insert([
            'name' => 'Franco Colmenarez',
            'email' => 'francoacg1@gmail.com',
            'password' => bcrypt('1234'),
            'profession_id' => $profession->id
        ]);
        */

        User::create([
            'name' => 'Franco Colmenarez',
            'email' => 'francoacg1@gmail.com',
            'password' => bcrypt('1234'),
            'is_admin' => true,
            'profession_id' => Profession::where('title', 'Back-end developer')->value('id')
        ]);

        factory(User::class)->create([
            'profession_id' => Profession::where('title', 'Front-end developer')->value('id')
        ]);

        factory(User::class)->create();
    }
}
