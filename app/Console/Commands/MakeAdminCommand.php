<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class MakeAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:admin {email : The email address of the user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make a user an admin by email address';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            $this->error("User with email '{$email}' not found.");
            return 1;
        }
        
        if ($user->role === User::ROLE_ADMIN) {
            $this->info("User '{$email}' is already an admin.");
            return 0;
        }
        
        $user->update([
            'role' => User::ROLE_ADMIN,
            'is_active' => true // Ensure admin is active
        ]);
        
        $this->info("User '{$email}' has been successfully made an admin.");
        $this->line("User details:");
        $this->line("Name: {$user->name}");
        $this->line("Email: {$user->email}");
        $this->line("Role: {$user->role}");
        $this->line("Status: " . ($user->is_active ? 'Active' : 'Inactive'));
        
        return 0;
    }
}
