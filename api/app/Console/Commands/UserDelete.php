<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class UserDelete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes an user from the system.';

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
        $emails = User::all()->map(function($item) {
            return $item->email;
        })->toArray();
        $email = $this->anticipate('User email:', $emails);

        $user = User::where('email', $email)->first();

        if (empty($user)) {
            $this->error("User `$email` was not found.");
            return;
        }

        if (!$this->confirm("Are you sure that you want to delete the user `$email`?")) {
            return;
        }

        try {
            $user->delete();
        } catch (\Throwable $e) {
            $this->error("User deletion failed with message: `{$e->getMessage()}`");
            return;
        }
        $this->info("User `$email` deleted successfully.");
    }
}
