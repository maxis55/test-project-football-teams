<?php

namespace App\Providers;

use App\Repositories\LeagueRepository;
use App\Repositories\LeagueRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        foreach ($this->bindings() as $interface => $class) {
            $this->app->bind($interface, $class);
        }
    }

    /**
     * @return array
     */
    private function bindings(): array
    {
        return [
            LeagueRepositoryInterface::class => LeagueRepository::class,
        ];
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
