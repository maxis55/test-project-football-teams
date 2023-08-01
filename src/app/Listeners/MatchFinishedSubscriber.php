<?php

namespace App\Listeners;

use App\Events\MatchIsFinished;
use App\Events\MatchResultsHaveChanged;
use App\Events\PlayedAllMatchesInALeague;
use App\Models\FootballTeam;
use Illuminate\Events\Dispatcher;

class MatchFinishedSubscriber
{

    /**
     * @param MatchIsFinished|MatchResultsHaveChanged $event
     * @return void
     */
    public function handleMatchResultsChanged($event): void
    {
        /**
         * @var FootballTeam $team
         */
        foreach ($event->match->teams as $team) {
            $team->refreshTeamScoreInALeague($event->match->league_id);
        }
    }

    public function handlePlayingAllMatches(PlayedAllMatchesInALeague $event): void
    {
        $league = $event->league;
        foreach ($league->teams as $team) {
            $team->refreshTeamScoreInALeague($league->getKey());
        }
    }

    /**
     * Register the listeners for the subscriber.
     */
    public function subscribe(Dispatcher $events): void
    {
        $events->listen(
            MatchIsFinished::class,
            [MatchFinishedSubscriber::class, 'handleMatchResultsChanged']
        );

        $events->listen(
            MatchResultsHaveChanged::class,
            [MatchFinishedSubscriber::class, 'handleMatchResultsChanged']
        );

        $events->listen(
            PlayedAllMatchesInALeague::class,
            [MatchFinishedSubscriber::class, 'handlePlayingAllMatches']
        );
    }
}
