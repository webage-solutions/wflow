<?php

namespace App\Console\Commands;

use App\Models\User;
use Hash;
use Illuminate\Console\Command;

class UserCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a user on the system.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->ask('Email:', 'admin@webage.solutions');
        $password = $this->secret('Password:');
        try {
            User::create([
                'email' => $email,
                'password' => Hash::make($password),
            ]);
        } catch(\Throwable $e) {
            $this->error('User creation failed with message: `' . $e->getMessage(). '`');
            return;
        }
        $this->info("User $email created successfully.");
    }
}
