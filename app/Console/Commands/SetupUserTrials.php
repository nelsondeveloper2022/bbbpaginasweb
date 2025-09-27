<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SetupUserTrials extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:setup-trials 
                            {--days=15 : Number of trial days}
                            {--force : Force update even if trial_ends_at is already set}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup trial periods for existing users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $days = $this->option('days');
        $force = $this->option('force');
        
        $this->info("Setting up {$days}-day trials for users...");
        
        $query = User::query();
        
        if (!$force) {
            $query->whereNull('trial_ends_at');
        }
        
        $users = $query->get();
        
        if ($users->isEmpty()) {
            $this->warn('No users found to update.');
            return;
        }
        
        $this->info("Found {$users->count()} users to update.");
        
        $updated = 0;
        
        foreach ($users as $user) {
            $trialEndDate = Carbon::now()->addDays($days);
            
            $user->update([
                'trial_ends_at' => $trialEndDate,
                'free_trial_days' => $days
            ]);
            
            $updated++;
            
            $this->line("Updated user: {$user->email} - Trial ends: {$trialEndDate->format('d/m/Y')}");
        }
        
        $this->info("Successfully updated {$updated} users with {$days}-day trials.");
    }
}
