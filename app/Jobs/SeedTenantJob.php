<?php

namespace App\Jobs;

use App\Models\School;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\Tenant;
use App\Models\User;

class SeedTenantJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    protected $tenant;
    public function __construct(Tenant $tenant)
    {
        $this->tenant = $tenant;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->tenant->run(function () {

            $school = School::create([
                'name' => $this->tenant->name,
                'email' => $this->tenant->email
            ]);

            // Create admin user
            $user = User::create([
                'school_id' => $school->id,
                'name' => $this->tenant->name,
                'email' => $this->tenant->email,
                'password' => $this->tenant->password,
            ]);

            $user->assignRole('admin');
        });
    }
}
