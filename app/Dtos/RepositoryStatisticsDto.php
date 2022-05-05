<?php

namespace App\Dtos;

use App\Entities\RepositoryEntity;
use App\Entities\RepositoryStatisticEntity;
use Illuminate\Support\Collection;

class RepositoryStatisticsDto extends DtoTemplate
{
    public RepositoryDto $repositoryWithMostForks;
    public RepositoryDto $repositoryWithMostWatches;
    public RepositoryDto $repositoryWithMostStars;
    public RepositoryDto $repositoryWithMostOpenIssues;
    public Collection    $repositories;

    public static function fromEntity(RepositoryStatisticEntity $entity): self
    {
        return new self([
            'repositoryWithMostForks' => RepositoryDto::fromEntity($entity->repositoryWithMostForks),
            'repositoryWithMostWatches' => RepositoryDto::fromEntity($entity->repositoryWithMostWatches),
            'repositoryWithMostStars' => RepositoryDto::fromEntity($entity->repositoryWithMostStars),
            'repositoryWithMostOpenIssues' => RepositoryDto::fromEntity($entity->repositoryWithMostOpenIssues),
            'repositories' => $entity->repositories->map(fn (RepositoryEntity $repositoryEntity) => RepositoryDto::fromEntity($repositoryEntity)),
        ]);
    }
}
