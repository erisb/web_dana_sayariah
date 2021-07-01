<?php

namespace App\Listeners;

use App\Events\ProjectMutationEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
class ProjectMutationListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ProjectMutationEvent  $event
     * @return void
     */
    public function handle(ProjectMutationEvent $event)
    {
        //create new record on mutation proyek table from the changed proyek model
        $proyek = $event->proyek;
        $proyek->mutationProyek()->create([
            'nominal' => $event->nominal,
            'tipe' => $event->tipe,
        ]);
    }
}
