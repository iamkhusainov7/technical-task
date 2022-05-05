<?php

namespace App\ApiDataProviders;

use App\Dtos\GithubRepositoryDto;
use App\Entities\RepositoryEntity;
use App\Exceptions\RepositoryNotExistsException;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Response;

class GithubDataProvider extends ApiDataProviderTemplate implements RepositoryProviderInterface
{
    protected const API_URL             = 'https://api.github.com/';
    protected const REPOSITORY_ENDPOINT = self::API_URL . 'repos/{owner}/{repositoryName}';

    public function getRepositoryByName(
        string $owner,
        string $name
    ): RepositoryEntity {
        try {
            $response = $this->get(self::REPOSITORY_ENDPOINT, collect([
                self::URL_PARAM_KEY => [
                    'owner'          => $owner,
                    'repositoryName' => $name,
                ]
            ]));
            $dto = new GithubRepositoryDto((array) json_decode($response->getBody()));
        } catch (ClientException $e) {
            if ($e->getResponse()->getStatusCode() === Response::HTTP_NOT_FOUND) {
                throw new RepositoryNotExistsException($owner . '/' . $name);
            };
        }

        return new RepositoryEntity(
            $dto->name,
            $dto->full_name,
            $dto->language,
            $dto->watchers_count,
            $dto->forks_count,
            $dto->stargazers_count,
            $dto->open_issues_count,
            $dto->has_issues,
            $dto->private,
            new \DateTime($dto->updated_at),
            $dto->full_name
        );
    }
}
