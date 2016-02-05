<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

//use DB;

class OauthClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('oauth_clients')->insert([
        	'id' => 'appid1',
        	'secret' => 'secret',
        	'name' => 'AngularAPP'
        	]);
    }
}
