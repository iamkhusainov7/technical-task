<?php

namespace App\Entities;

use Illuminate\Support\Collection;

class RepositoryStatisticEntity
{
    /**
     * @param  RepositoryEntity  $repositoryWithMostForks
     * @param  RepositoryEntity  $repositoryWithMostWatches
     * @param  RepositoryEntity  $repositoryWithMostStars
     * @param  Collection  $repositories
     */
    public function __construct(
        public readonly RepositoryEntity $repositoryWithMostForks,
        public readonly RepositoryEntity $repositoryWithMostWatches,
        public readonly RepositoryEntity $repositoryWithMostStars,
        public readonly Collection $repositories,
    ) {
    }
}
