<?php

namespace Tests\Feature;

use App\Events\LeagueCreated;
use App\Events\MatchIsFinished;
use App\Events\PlayedAllMatchesInALeague;
use App\Listeners\CreateLeagueMatchesListener;
use App\Models\FootballLeagueToTeam;
use App\Models\FootballMatch;
use App\Models\FootballMatchToTeam;
use App\Models\FootballTeam;
use App\Models\League;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class LeagueControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_index(): void
    {
        League::unsetEventDispatcher();
        $num = 5;

        League::factory($num)->create();

        $response = $this->get('/api/leagues');

        $response->assertJsonIsObject();
        $response->assertJsonCount($num, 'data');
        $response->assertJsonStructure(
            ['data' => ['*' => ['id', 'created_at', 'updated_at', 'name']]]
        );

        $response->assertStatus(200);
    }

    public function test_store(): void
    {
        $teamsN = 4;
        $matchesN = $teamsN * $teamsN - $teamsN;
        $matchesToTeamsN = $matchesN * 2;
        $teams = FootballTeam::factory($teamsN)->create();

        $name = 'League1';
        $response = $this->post('/api/leagues', ['name' => $name]);
        $response->assertCreated();
        $this->assertDatabaseCount((new League())->getTable(), 1);
        $this->assertDatabaseHas((new League())->getTable(), ['name' => $name]);

        $this->assertDatabaseCount((new FootballLeagueToTeam())->getTable(), $teamsN);

        $this->assertDatabaseCount((new FootballMatch())->getTable(), $matchesN);
        $this->assertDatabaseCount((new FootballMatchToTeam())->getTable(), $matchesToTeamsN);
    }

    public function test_store_event_firing(): void
    {
        Event::fake();
        $name = 'League1';
        $response = $this->post('/api/leagues', ['name' => $name]);
        $response->assertCreated();
        $this->assertDatabaseCount((new League())->getTable(), 1);
        $this->assertDatabaseHas((new League())->getTable(), ['name' => $name]);

        Event::assertDispatched(LeagueCreated::class);
        Event::assertListening(
            LeagueCreated::class,
            CreateLeagueMatchesListener::class
        );
    }

    public function test_get_standings_and_odds(): void
    {
        $teamsN = 4;
        $teams = FootballTeam::factory($teamsN)->create();

        $leagues = 1;

        $league = League::factory($leagues)->create()->first();

        $response = $this->get(route('api.leagues.get-league-standing-and-predictions', $league->getKey()));

        $response->assertJsonIsObject();

        $response->assertJsonStructure(
            [
                'data' => [
                    'standings' =>
                        [
                            '*' => [
                                'id',
                                'team_id',
                                'league_id',
                                'points',
                                'matches_played',
                                'wins',
                                'loses',
                                'draws',
                                'goal_difference'
                            ]
                        ],
                    'predictions' => [
                        '*' => ['name', 'odds']
                    ]
                ]
            ]
        );

        $response->assertStatus(200);
    }

    public function test_post_run_next_week()
    {
        Event::fake()->except([LeagueCreated::class]);
        $teamsN = 4;
        $teams = FootballTeam::factory($teamsN)->create();

        $leagues = 1;


        $league = League::factory($leagues)->create()->first();

        $response = $this->post(route('api.leagues.run-next-week', $league->getKey()));
        $response->assertSuccessful();

        $response->assertJsonStructure(
            [
                'data' => [
                    'id',
                    'name',
                    'home_team' => ['id', 'name', 'goals'],
                    'guest_team' => ['id', 'name', 'goals'],
                ]
            ]
        );

        $this->assertDatabaseHas((new FootballMatch())->getTable(), ['finished' => true]);
        $match = FootballMatch::where('finished', true)->first();
        $this->assertDatabaseHas(
            (new FootballMatchToTeam())->getTable(),
            ['team_id' => $teams->first()->getKey(), 'match_id' => $match->getKey()]
        );

        $finishedMatches = FootballMatch::where('finished', true)->count();
        $updatedMatchedToTeams = FootballMatchToTeam::whereNotNull('goals')->count();

        $this->assertEquals(1, $finishedMatches);
        $this->assertEquals(2, $updatedMatchedToTeams);

        Event::assertDispatched(MatchIsFinished::class);
    }

    public function test_get_all_match_results(): void
    {
        $teamsN = 4;
        $teams = FootballTeam::factory($teamsN)->create();

        $leagues = 1;


        $league = League::factory($leagues)->create()->first();

        $response = $this->get(route('api.leagues.get-all-match-results', $league->getKey()));

        $response->assertSuccessful();
        $response->assertJsonStructure(
            [
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'home_team' => ['id', 'name', 'goals'],
                        'guest_team' => ['id', 'name', 'goals'],
                    ]
                ]
            ]
        );
    }

    public function test_play_all_matches(): void
    {
        Event::fake()->except([LeagueCreated::class]);

        $teamsN = 4;
        $teams = FootballTeam::factory($teamsN)->create();

        $leagues = 1;


        $league = League::factory($leagues)->create()->first();

        $response = $this->post(route('api.leagues.play-all-remaining-matches', $league->getKey()));

        $this->assertDatabaseHas((new FootballMatch())->getTable(), ['finished' => true]);
        $match = FootballMatch::where('finished', true)->first();
        $this->assertDatabaseHas(
            (new FootballMatchToTeam())->getTable(),
            ['team_id' => $teams->first()->getKey(), 'match_id' => $match->getKey()]
        );
        $matchesN = $teamsN * $teamsN - $teamsN;
        $matchesToTeamsN = $matchesN * 2;
        $finishedMatches = FootballMatch::where('finished', true)->count();
        $updatedMatchedToTeams = FootballMatchToTeam::whereNotNull('goals')->count();

        $this->assertEquals($matchesN, $finishedMatches);
        $this->assertEquals($matchesToTeamsN, $updatedMatchedToTeams);

        Event::assertDispatched(PlayedAllMatchesInALeague::class);
    }
}
