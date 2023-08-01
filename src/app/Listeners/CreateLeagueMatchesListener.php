<?php

namespace App\Listeners;

use App\Events\LeagueCreated;
use App\Repositories\LeagueRepositoryInterface;

class CreateLeagueMatchesListener
{
    /**
     * Create the event listener.
     */
    public function __construct(protected LeagueRepositoryInterface $repository)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(LeagueCreated $event): void
    {
        $league = $event->league;

        $this->repository->generateMatchesForTheLeague($league);
    }
}
