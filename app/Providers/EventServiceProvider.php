<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Event' => [
            'App\Listeners\EventListener',
        ],
        'App\Events\MutasiInvestorEvent' => [
            'App\Listeners\MutasiInvestorEventListener'
        ],
        'App\Events\UserMonthlyPayEvent' =>[
            'App\Listeners\UserMontyhlyPayListener'
        ],
        'App\Events\ProjectMutationEvent' =>[
            'App\Listeners\ProjectMutationListener'
        ],    
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
