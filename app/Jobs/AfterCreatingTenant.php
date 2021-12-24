<?php

namespace App\Jobs;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AfterCreatingTenant implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $tenant;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Tenant $tenant)
    {
        $this->tenant = $tenant;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $tenant = $this->tenant;

        $tenant->run(function ($tenant) {
            $user = User::create(['name' => $tenant->manager, 'email_verified_at' => now(), 'email' => $tenant->email, 'email_verified_at' => '', 'password' => bcrypt($tenant->password), 'google_id' => $tenant->google_id]);
        });

        $tenant->createOrGetStripeCustomer([
            'name' => $tenant->name,
            'email' => $tenant->email,
            "preferred_locales" => ['pt-BR'],
        ]);

        $tenant->update(['initial_migration_complete' => true]);
    }
}
