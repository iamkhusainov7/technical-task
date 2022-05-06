<?php

namespace App\Entities;

use Illuminate\Support\Collection;

class RepositoryStatisticEntity
{
    /**
     * @param  RepositoryEntity  $repositoryWithMostForks
     * @param  RepositoryEntity  $repositoryWithMostWatches
     * @param  RepositoryEntity  $repositoryWithMostStars
     * @param  RepositoryEntity  $repositoryWithMostOpenIssues
     * @param  Collection  $repositories
     */
    public function __construct(
        public readonly RepositoryEntity $repositoryWithMostForks,
        public readonly RepositoryEntity $repositoryWithMostWatches,
        public readonly RepositoryEntity $repositoryWithMostStars,
        public readonly RepositoryEntity $repositoryWithMostOpenIssues,
        public readonly Collection $repositories,
    ) {
    }
}
