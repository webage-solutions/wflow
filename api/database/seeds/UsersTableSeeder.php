<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'id' => 1,
                'email' => 'root@webage.solutions',
                'name' => 'Root Admin',
                'password' => Hash::make('password'),
                'superuser' => true,
                'settings' => null,
            ],
            [
                'id' => 2,
                'email' => 'freddiemercury@gmail.com',
                'name' => 'Freddie Mercury',
                'password' => Hash::make('password'),
                'superuser' => false,
                'settings' => null,
            ],
            [
                'id' => 3,
                'email' => 'brianmay@gmail.com',
                'name' => 'Brian May',
                'password' => Hash::make('password'),
                'superuser' => false,
                'settings' => null,
            ],
            [
                'id' => 4,
                'email' => 'paulrodgers@gmail.com',
                'name' => 'Paul Rodgers',
                'password' => Hash::make('password'),
                'superuser' => false,
                'settings' => null,
            ],
            [
                'id' => 5,
                'email' => 'paulkossoff@gmail.com',
                'name' => 'Paul Kossoff',
                'password' => Hash::make('password'),
                'superuser' => false,
                'settings' => null,
            ],[
                'id' => 6,
                'email' => 'johndeacon@gmail.com',
                'name' => 'John Deacon',
                'password' => Hash::make('password'),
                'superuser' => false,
                'settings' => json_encode([
                    'locale' => [
                        'value' => 'en-US'
                    ]
                ]),
            ],
            [
                'id' => 7,
                'email' => 'rogertaylor@gmail.com',
                'name' => 'Roger Taylor',
                'password' => Hash::make('password'),
                'superuser' => false,
                'settings' => null,
            ],
        ]);
    }
}
