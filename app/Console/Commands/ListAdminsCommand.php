<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class ListAdminsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'list:admins';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all admin users in the system';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $admins = User::where('role', User::ROLE_ADMIN)->get();
        
        if ($admins->isEmpty()) {
            $this->info('No admin users found in the system.');
            return 0;
        }
        
        $this->info('Admin Users:');
        $this->line('');
        
        $headers = ['ID', 'Name', 'Email', 'Status', 'Created At'];
        $rows = [];
        
        foreach ($admins as $admin) {
            $rows[] = [
                $admin->id,
                $admin->name,
                $admin->email,
                $admin->is_active ? 'Active' : 'Inactive',
                $admin->created_at->format('Y-m-d H:i:s')
            ];
        }
        
        $this->table($headers, $rows);
        
        $this->line('');
        $this->info("Total admin users: {$admins->count()}");
        
        return 0;
    }
}
