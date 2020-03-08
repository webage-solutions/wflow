<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ServerSettingsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(OrganizationsTableSeeder::class);
        $this->call(DomainNamesTableSeeder::class);
        $this->call(OrganizationUserTableSeeder::class);
        $this->call(StatesTableSeeder::class);
        $this->call(TaskTypesTableSeeder::class);
        $this->call(StateTaskTypeTableSeeder::class);
        $this->call(TasksTableSeeder::class);
        $this->call(UserGroupsTableSeeder::class);
        $this->call(UserUserGroupTableSeeder::class);
        $this->call(OauthClientsTableSeeder::class);
    }
}
