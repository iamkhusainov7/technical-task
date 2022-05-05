<?php

namespace App\Providers;

use App\ApiDataProviders\GithubDataProvider;
use App\Decorators\RepositoryStorageDecorator;
use App\Http\Controllers\GithubRepositoryStatisticController;
use App\Storages\Contract\RepositoryEntityStorageInterface;
use App\Storages\GithubRepositoryStorage;
use App\Services\GithubRepositoryNameParserService;
use App\Services\RepositoryComparisonStatisticInterface;
use App\Services\RepositoryIdentifierParserServiceInterface;
use App\Services\SimpleRepositoryStatisticService;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class GithubServiceProvider extends ServiceProvider
{
    /**
     * Register required services by GitHub.
     *
     * @return void
     */
    public function register()
    {
        $this->app->when(GithubDataProvider::class)
            ->needs(ClientInterface::class)
            ->give(fn() => new Client());

        $this->app->when(GithubRepositoryStorage::class)
            ->needs(Repository::class)
            ->give(fn() => Cache::store('redis'));

        $this->app->when(GithubRepositoryStatisticController::class)
            ->needs(RepositoryIdentifierParserServiceInterface::class)
            ->give(GithubRepositoryNameParserService::class);

        $this->app->bind(
            RepositoryComparisonStatisticInterface::class,
            SimpleRepositoryStatisticService::class
        );
    }

    /**
     * Register depended service.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->when(GithubRepositoryStatisticController::class)
            ->needs(RepositoryEntityStorageInterface::class)
            ->give(fn() => new RepositoryStorageDecorator(
                $this->app->make(GithubRepositoryStorage::class),
                $this->app->make(GithubDataProvider::class),
                $this->app->make(GithubRepositoryNameParserService::class),
            ));
    }
}
