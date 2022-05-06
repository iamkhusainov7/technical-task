<?php

namespace App\Services;

use App\Entities\RepositoryEntity;
use App\Entities\RepositoryStatisticEntity;
use Illuminate\Support\Collection;

interface RepositoryComparisonStatisticInterface
{
    /**
     * Compares multiple repositories.
     *
     * @param  Collection  $repositories
     *
     * @return RepositoryStatisticEntity
     */
    public function compareRepositories(Collection $repositories): RepositoryStatisticEntity;

    /**
     * Compares two repositories.
     *
     * @param  RepositoryEntity  $firstRepo
     * @param  RepositoryEntity  $secondRepo
     *
     * @return RepositoryStatisticEntity
     */
    public function compareTwoRepositories(RepositoryEntity $firstRepo, RepositoryEntity $secondRepo): RepositoryStatisticEntity;
}
