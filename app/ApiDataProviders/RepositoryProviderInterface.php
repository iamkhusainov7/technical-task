<?php

namespace App\ApiDataProviders;

use App\Entities\RepositoryEntity;
use App\Exceptions\RepositoryNotExistsException;

interface RepositoryProviderInterface
{
    /**
     * @param  string  $owner
     * @param  string  $name
     *
     * @return RepositoryEntity
     * @throws RepositoryNotExistsException
     */
    public function getRepositoryByName(string $owner, string $name): RepositoryEntity;
}
