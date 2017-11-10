<?php

use Illuminate\Database\Seeder;

class JediTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
	    public function run()
	    {
	    	$now = Carbon\Carbon::now();

	        DB::table('jedi')->insert([
	        [
	            'name' => 'Luke Skywalker',
	            'email' => 'luke@jedirebels.com',
	            'level'  => 'Jedi in training',
	            'is_lightsaber_on' => '1',
	            'created_at' => $now,
	            'updated_at' => $now
	        ],
	        [
	        	'name' => 'Yoda',
	            'email' => 'yoda@jedicouncil.org',
	            'level'  => 'Jedi Master',
	            'is_lightsaber_on' => '1',
	            'created_at' => $now,
	            'updated_at' => $now
	        ],
	        [
	        	'name' => 'Mace Wondu',
	            'email' => 'mace@jedicouncil.org',
	            'level'  => 'Jedi Master',
	            'is_lightsaber_on' => '0',
	            'created_at' => $now,
	        	'updated_at' => $now
	        ],
	        [
	        	'name' => 'Anakin Skywalkder',
	            'email' => 'vader@theevilempire.org',
	            'level'  => 'Sith Lord',
	            'is_lightsaber_on' => '0',
	            'created_at' => $now,
	            'updated_at' => $now
	        ],
	        [
	        	'name' => 'Obi Wan Kenobi',
	            'email' => 'ken@obiwancan.com',
	            'level'  => 'Master jedi',
	            'is_lightsaber_on' => '1',
	            'created_at' => $now,
	            'updated_at' => $now
	        ]
	    ]);
	}
}