<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        DB::table('photos')->insert([
        	[
        		'path' => 'img/photos/pascalsommer_9.jpg',
        		'description' => 'Trees. äöü. я не говорю по-русский.',
        		'post_id' => 1,
        	]
        ]);
    }
}
