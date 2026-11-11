<?php

namespace App\Console\Commands;

use App\Services\PermissionSyncService;
use Illuminate\Console\Command;

class SyncRoutePermissions extends Command
{
    protected $signature = 'permissions:sync {--prune : Je route nei tar permission delete korbe}';

    protected $description = 'Route name theke permissions table sync kore';

    public function handle(PermissionSyncService $service): int
    {
        $service->ensureSuperAdminRole();
        $r = $service->sync((bool) $this->option('prune'));

        $this->info("Created: {$r['created']} | Updated: {$r['updated']} | Removed: {$r['removed']} | Total: {$r['total']}");

        return self::SUCCESS;
    }
}