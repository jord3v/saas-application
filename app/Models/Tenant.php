<?php

namespace App\Models;

use Carbon\Carbon;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use Laravel\Cashier\Billable;

class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase, HasDomains, Billable;

    public static function getCustomColumns(): array
    {
        return [
            'id',
            'name',
            'email',
            'stripe_id',
            'pm_type',
            'pm_last_four',
            'trial_ends_at'
        ];
    }

    public function getAccessEndAttribute()
    {
        $accessEndAt = $this->subscription('default')->ends_at;

        return Carbon::make($accessEndAt)->format("d/m/Y à\s H:i:s");
    }
    
}
