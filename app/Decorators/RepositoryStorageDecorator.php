<?php

namespace App\Decorators;

use App\ApiDataProviders\RepositoryProviderInterface;
use App\Entities\RepositoryEntity;
use App\Exceptions\RepositoryNotExistsException;
use App\Storages\Contract\RepositoryEntityStorageInterface;
use App\Services\RepositoryIdentifierParserServiceInterface;

class RepositoryStorageDecorator implements RepositoryEntityStorageInterface
{
    /**
     * @param  RepositoryEntityStorageInterface  $storage
     * @param  RepositoryProviderInterface  $dataProvider
     * @param  RepositoryIdentifierParserServiceInterface  $identifierParserService
     */
    public function __construct(
        private readonly RepositoryEntityStorageInterface $storage,
        private readonly RepositoryProviderInterface $dataProvider,
        private readonly RepositoryIdentifierParserServiceInterface $identifierParserService,
    ) {
    }

    public function add(RepositoryEntity $repositoryEntity): RepositoryEntity
    {
        return $this->storage->add($repositoryEntity);
    }

    public function get(string $identifier): RepositoryEntity
    {
        $repositoryIdentifiers = $this->identifierParserService->parse($identifier);

        try {
            $repositoryEntity = $this->storage->get($repositoryIdentifiers->get(RepositoryIdentifierParserServiceInterface::IDENTIFIER_NAME_KEY));
        } catch (RepositoryNotExistsException $e) {
            $repositoryEntity = $this->dataProvider->getRepositoryByName(
                $repositoryIdentifiers->get(
                    RepositoryIdentifierParserServiceInterface::REPOSITORY_OWNER_KEY,
                    ''
                ),
                $repositoryIdentifiers->get(RepositoryIdentifierParserServiceInterface::REPOSITORY_NAME_KEY, '')
            );

            $this->storage->add($repositoryEntity);
        }

        return $repositoryEntity;
    }
}
