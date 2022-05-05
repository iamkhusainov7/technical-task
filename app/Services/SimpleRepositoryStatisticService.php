<?php

namespace App\Services;

use App\Entities\RepositoryEntity;
use App\Entities\RepositoryStatisticEntity;
use Illuminate\Support\Collection;

class SimpleRepositoryStatisticService implements RepositoryComparisonStatisticInterface
{
    /**
     * @param  Collection  $repositories
     *
     * @return RepositoryStatisticEntity
     */
    public function compareRepositories(Collection $repositories): RepositoryStatisticEntity {
        if ($repositories->isEmpty()) {
            return collect();
        }

        $repositoryWithMostForks = $repositoryWithMostWatches = $repositoryWithMostStars = $repositories->first();

        foreach ($repositories as $repository) {
            foreach ($repositories as $repositoryToBeCompared) {
                if ($repository === $repositoryToBeCompared) {
                    continue;
                }

                $result = $this->compareTwoRepositories($repository, $repositoryToBeCompared);
                $repositoryWithMostForks = $result->repositoryWithMostForks;
                $repositoryWithMostWatches = $result->repositoryWithMostWatches;
                $repositoryWithMostStars = $result->repositoryWithMostStars;
            }
        }

        return new RepositoryStatisticEntity(
            $repositoryWithMostForks,
            $repositoryWithMostWatches,
            $repositoryWithMostStars,
            $repositories->keyBy(fn (RepositoryEntity $entity) => $entity->fullName)
        );
    }

    public function compareTwoRepositories(
        RepositoryEntity $firstRepo,
        RepositoryEntity $secondRepo
    ): RepositoryStatisticEntity {
        $repositoryWithMostForks =
            match ($firstRepo->forks <=> $secondRepo->forks) {
                1 => $firstRepo,
                -1 => $secondRepo,
                default => null
            };

        $repositoryWithMostWatches =
            match ($firstRepo->watchers <=> $secondRepo->watchers) {
                1 => $firstRepo,
                -1 => $secondRepo,
                default => null
            };

        $repositoryWithMostStars =
            match ($firstRepo->stars <=> $secondRepo->stars) {
                1 => $firstRepo,
                -1 => $secondRepo,
                default => null
            };

        return new RepositoryStatisticEntity(
            $repositoryWithMostForks,
            $repositoryWithMostWatches,
            $repositoryWithMostStars,
            collect([
                $firstRepo->fullName => $firstRepo,
                $secondRepo->fullName => $secondRepo,
            ])
        );
    }
}
