<?php

namespace Database\Seeders;

use App\Models\LogEntry;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $entries = [
            [
                'title'       => 'System startup completed',
                'category'    => 'General',
                'description' => 'All services started successfully. No issues detected during boot sequence.',
                'severity'    => 'info',
                'logged_at'   => now()->subDays(1)->setTime(8, 0),
            ],
            [
                'title'       => 'High memory usage detected',
                'category'    => 'Incident',
                'description' => 'Memory usage spiked to 87%. Investigated and found a runaway process. Restarted the service.',
                'severity'    => 'warning',
                'logged_at'   => now()->subHours(5),
            ],
            [
                'title'       => 'Database backup completed',
                'category'    => 'Maintenance',
                'description' => 'Nightly database backup completed successfully. Backup size: 2.3 GB.',
                'severity'    => 'info',
                'logged_at'   => now()->subDays(2)->setTime(2, 0),
            ],
            [
                'title'       => 'API endpoint returning 500 errors',
                'category'    => 'Incident',
                'description' => 'The /api/users endpoint began returning 500 errors. Root cause: missing environment variable. Fixed and deployed.',
                'severity'    => 'error',
                'logged_at'   => now()->subDays(3),
            ],
            [
                'title'       => 'SSL certificate renewed',
                'category'    => 'Maintenance',
                'description' => 'SSL certificate for the main domain renewed. New expiry: 12 months.',
                'severity'    => 'info',
                'logged_at'   => now()->subDays(5),
            ],
            [
                'title'       => 'Security breach attempt detected',
                'category'    => 'Incident',
                'description' => 'Multiple failed login attempts from IP 192.168.x.x. IP blocked via firewall rule. Security team notified.',
                'severity'    => 'critical',
                'logged_at'   => now()->subDays(7),
            ],
        ];

        foreach ($entries as $entry) {
            LogEntry::create($entry);
        }
    }
}
