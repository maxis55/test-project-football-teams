<?php

namespace App\Http\Resources;

use App\Models\FootballMatch;
use App\Models\FootballMatchToTeam;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property FootballMatch $resource
 */
class MatchWithResultsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->getKey(),
            'name' => $this->resource->name,

            'home_team' => $this->formatMatchToTeam(
                $this->resource->matchToTeams
                    ->where('is_team_stadium_owner', true)
                    ->first()),
            'guest_team' => $this->formatMatchToTeam(
                $this->resource->matchToTeams
                    ->where('is_team_stadium_owner', false)
                    ->first())

        ];
    }

    protected function formatMatchToTeam(FootballMatchToTeam $matchToTeam)
    {
        return [
            'id' => $matchToTeam->team_id,
            'name' => $matchToTeam->team->name,
            'goals' => $matchToTeam->goals
        ];
    }
}
