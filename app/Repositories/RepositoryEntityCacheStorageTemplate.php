<?php

namespace App\Repositories;

use App\Entities\RepositoryEntity;
use App\Exceptions\RepositoryNotExistsException;
use App\Repositories\Contract\RepositoryEntityStorageInterface;
use Illuminate\Contracts\Cache\Repository;

abstract class RepositoryEntityCacheStorageTemplate implements RepositoryEntityStorageInterface
{
    /**
     * @param  RepositoryEntity|string  $repositoryEntity
     *
     * @return string
     */
    abstract protected function getKey(RepositoryEntity|string $repositoryEntity): string;

    public function __construct(
        private readonly Repository $repository,
        private readonly int $ttl = 900,
    ) {
    }

    /**
     * @param  RepositoryEntity  $repositoryEntity
     *
     * @return RepositoryEntity
     * @throws \Exception
     */
    public function add(RepositoryEntity $repositoryEntity): RepositoryEntity
    {
        if (! $this->repository->add($this->getKey($repositoryEntity), $repositoryEntity, $this->ttl)) {
            throw new \Exception('Something went wrong while saving');
        }

        return $repositoryEntity;
    }

    /**
     * @param  string  $identifier
     *
     * @return RepositoryEntity
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function get(string $identifier): RepositoryEntity
    {
        $repositoryEntity = $this->repository->get($this->getKey($identifier));

        if (! $repositoryEntity) {
            throw new RepositoryNotExistsException($identifier);
        }

        return $repositoryEntity;
    }
}
