<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Lead;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CheckLeadSLA extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sla:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks Leads for SLA breaches (12hr Manager Alert, 18hr Admin Escalation)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting SLA Verification for Leads...');

        $now = Carbon::now();

        // Find leads that are still in initial stages and haven't been updated recently
        $staleLeads = Lead::whereIn('stage', ['Entry', 'Pending', 'New'])
            ->where('updated_at', '<=', $now->copy()->subHours(12))
            ->get();

        $managerAlertCount = 0;
        $escalationCount = 0;

        foreach ($staleLeads as $lead) {
            $hoursPassed = $lead->updated_at->diffInHours($now);

            if ($hoursPassed >= 18) {
                // 18 Hour Rule: Escalate to Admin
                Log::critical("SLA ESCALATION: Lead {$lead->lead_code} has no action for {$hoursPassed} hours! Escalating to Master Admin.");
                // Here we would typically insert an alert into an `alerts` or `notifications` table for the Master Admin
                $escalationCount++;
            } 
            elseif ($hoursPassed >= 12) {
                // 12 Hour Rule: Manager Alert
                Log::warning("SLA ALERT: Lead {$lead->lead_code} has no action for {$hoursPassed} hours. Alerting Manager.");
                // Insert an alert for the Manager/Accounts role
                $managerAlertCount++;
            }
        }

        $this->info("SLA Check Complete. Manager Alerts: {$managerAlertCount} | Admin Escalations: {$escalationCount}");
    }
}
