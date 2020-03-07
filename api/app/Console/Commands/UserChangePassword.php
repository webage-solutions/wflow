<?php

namespace App\Console\Commands;

use App\Models\User;
use Hash;
use Illuminate\Console\Command;

class UserChangePassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:password';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Changes password for a user.';

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
        $emails = User::all()->map(function(User $item) {
            return $item->email;
        })->toArray();
        $email = $this->anticipate('User email:', $emails);

        /** @var User $user */
        $user = User::where('email', $email)->first();

        if (empty($user)) {
            $this->error("User `$email` was not found.");
            return;
        }

        $password = Hash::make($this->secret('New password:'));

        $user->password = $password;

        try {
            $user->save();
        } catch(\Throwable $e) {
            $this->error('Password failed with message: `' . $e->getMessage(). '`');
            return;
        }
        $this->info("Password successfully changed for user `$email`.");
    }
}
