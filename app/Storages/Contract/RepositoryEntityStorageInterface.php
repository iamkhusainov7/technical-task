<?php

namespace App\Storages\Contract;

use App\Entities\RepositoryEntity;
use App\Exceptions\RepositoryNotExistsException;

interface RepositoryEntityStorageInterface
{
    /**
     * @param  RepositoryEntity  $repositoryEntity
     *
     * @return RepositoryEntity
     */
    public function add(RepositoryEntity $repositoryEntity): RepositoryEntity;

    /**
     * @param  string  $identifier
     *
     * @return RepositoryEntity
     *
     * @throws RepositoryNotExistsException
     */
    public function get(string $identifier): RepositoryEntity;
}
