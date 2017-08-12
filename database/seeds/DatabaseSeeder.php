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
    {   // clear our database
        DB::table('users')->delete();
        DB::table('password_resets')->delete();

        //create demo account
        DB::table('users')->insert(array(
            'username' => 'Cem Türk',
            'email'    => 'cemturk@gmail.com',
            'password' => '$2y$10$IZmIpDWI7khcnEl18ZLpbulx0EHWlSDSSXBlTkgfVndtkxj.oWlZK'
        ));
        $this->command->info('Demo user account has been created! Email : cemturk@gmail.com Password: deneme');
    }
}
