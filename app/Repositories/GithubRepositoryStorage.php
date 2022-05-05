<?php

namespace App\Repositories;

use App\Entities\RepositoryEntity;

class GithubRepositoryStorage extends RepositoryEntityCacheStorageTemplate
{
    protected const REPOSITORY_KEY = 'githubRepository';

    /**
     * @param  RepositoryEntity|string  $repositoryEntity
     *
     * @return string
     */
    protected function getKey(RepositoryEntity|string $repositoryEntity): string
    {
        $identifier = is_string($repositoryEntity) ? $repositoryEntity : $repositoryEntity->localIdentifier;

        return self::REPOSITORY_KEY . ":$identifier";
    }
}
