<?php

namespace App\Console\Commands;

use App\Mail\SellerDeactivated;
use App\Mail\SellerInactivityWarning;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CheckSellerActivity extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sellers:check-activity 
                            {--dry-run : Run without actually sending emails or deactivating accounts}
                            {--warning-days=23 : Days of inactivity before sending warning (H-7 from 30 days)}
                            {--deactivate-days=30 : Days of inactivity before auto-deactivation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check seller activity and send warnings (H-7) or auto-deactivate inactive sellers (30 days)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dryRun = $this->option('dry-run');
        $warningDays = (int) $this->option('warning-days');
        $deactivateDays = (int) $this->option('deactivate-days');
        
        $this->info('🔍 Checking seller activity...');
        $this->info("   Warning threshold: {$warningDays} days (H-" . ($deactivateDays - $warningDays) . ")");
        $this->info("   Deactivation threshold: {$deactivateDays} days");
        
        if ($dryRun) {
            $this->warn('⚠️  DRY RUN MODE - No actual changes will be made');
        }
        
        $this->newLine();
        
        // Get all active approved sellers
        $activeSellers = User::where('role', 'seller')
            ->where('status', 'approved')
            ->where('is_active', true)
            ->get();
        
        $this->info("Found {$activeSellers->count()} active sellers to check.");
        $this->newLine();
        
        $warned = 0;
        $deactivated = 0;
        
        foreach ($activeSellers as $seller) {
            $lastActivity = $seller->last_login_at ?? $seller->created_at;
            $daysSinceActivity = now()->diffInDays($lastActivity);
            
            // Check if seller should be deactivated (30+ days inactive)
            if ($daysSinceActivity >= $deactivateDays) {
                $this->deactivateSeller($seller, $daysSinceActivity, $dryRun);
                $deactivated++;
            }
            // Check if seller should receive warning (23 days = H-7 from 30)
            elseif ($daysSinceActivity >= $warningDays && $daysSinceActivity < $deactivateDays) {
                $this->sendWarning($seller, $daysSinceActivity, $deactivateDays - $daysSinceActivity, $dryRun);
                $warned++;
            }
        }
        
        $this->newLine();
        $this->info('📊 Summary:');
        $this->table(
            ['Action', 'Count'],
            [
                ['Warnings Sent', $warned],
                ['Accounts Deactivated', $deactivated],
            ]
        );
        
        if ($dryRun) {
            $this->newLine();
            $this->warn('⚠️  This was a dry run. Run without --dry-run to apply changes.');
        }
        
        return Command::SUCCESS;
    }
    
    /**
     * Send inactivity warning email to seller
     */
    protected function sendWarning(User $seller, int $daysSinceActivity, int $daysUntilDeactivation, bool $dryRun): void
    {
        $shopName = $seller->seller->shop_name ?? $seller->name;
        
        $this->line("⚠️  Warning: {$shopName} ({$seller->email}) - {$daysSinceActivity} days inactive");
        $this->line("    Will be deactivated in {$daysUntilDeactivation} days");
        
        if (!$dryRun) {
            try {
                Mail::to($seller->email)->send(new SellerInactivityWarning($seller, $daysUntilDeactivation));
                $this->info("    ✉️  Warning email sent");
            } catch (\Exception $e) {
                $this->error("    ❌ Failed to send email: " . $e->getMessage());
            }
        }
    }
    
    /**
     * Deactivate seller account
     */
    protected function deactivateSeller(User $seller, int $daysSinceActivity, bool $dryRun): void
    {
        $shopName = $seller->seller->shop_name ?? $seller->name;
        
        $this->line("🔒 Deactivating: {$shopName} ({$seller->email}) - {$daysSinceActivity} days inactive");
        
        if (!$dryRun) {
            try {
                $seller->update([
                    'is_active' => false,
                    'deactivated_at' => now(),
                    'deactivation_reason' => "Otomatis dinonaktifkan karena tidak ada aktivitas login selama {$daysSinceActivity} hari.",
                ]);
                
                Mail::to($seller->email)->send(new SellerDeactivated($seller, 'inactivity'));
                $this->info("    ✅ Account deactivated and notification sent");
            } catch (\Exception $e) {
                $this->error("    ❌ Failed to deactivate: " . $e->getMessage());
            }
        }
    }
}
