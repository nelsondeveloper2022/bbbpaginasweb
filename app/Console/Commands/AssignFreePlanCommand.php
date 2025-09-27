<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\BbbPlan;
use Illuminate\Console\Command;
use Carbon\Carbon;

class AssignFreePlanCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'plan:assign-free {--force : Force assignment even if user has a plan}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign free 15-day plan to users without a plan';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting free plan assignment...');

        // Verificar que existe el plan Free
        $freePlan = BbbPlan::find(6);
        if (!$freePlan) {
            $this->error('Free plan (ID: 6) not found in database!');
            return Command::FAILURE;
        }

        $this->info("Free plan found: {$freePlan->nombre}");

        // Obtener usuarios sin plan o con plan expirado
        $query = User::query();
        
        if ($this->option('force')) {
            $query->whereNull('id_plan')->orWhere('id_plan', 0);
        } else {
            $query->where(function($q) {
                $q->whereNull('id_plan')
                  ->orWhere('id_plan', 0)
                  ->orWhere(function($subQ) {
                      $subQ->where('id_plan', 6)
                           ->where('trial_ends_at', '<', now());
                  });
            });
        }

        $users = $query->get();

        if ($users->isEmpty()) {
            $this->info('No users found that need free plan assignment.');
            return Command::SUCCESS;
        }

        $this->info("Found {$users->count()} users to process.");

        $assigned = 0;
        foreach ($users as $user) {
            try {
                $user->update([
                    'id_plan' => 6,
                    'trial_ends_at' => Carbon::now()->addDays(15)
                ]);

                $this->line("✓ Assigned free plan to: {$user->email}");
                $assigned++;
            } catch (\Exception $e) {
                $this->error("✗ Failed to assign plan to {$user->email}: " . $e->getMessage());
            }
        }

        $this->info("Successfully assigned free plan to {$assigned} users.");
        return Command::SUCCESS;
    }
}
