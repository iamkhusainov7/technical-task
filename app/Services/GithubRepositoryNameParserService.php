<?php

namespace App\Services;

use Illuminate\Support\Collection;

class GithubRepositoryNameParserService implements RepositoryIdentifierParserServiceInterface
{
    public function parse(string $content): Collection
    {
        if (filter_var($content, FILTER_VALIDATE_URL)) {
            $content = substr($this->getUrlPath($content), 1);
        }

        @[$owner, $repositoryName] = explode('/', $content);

        return collect([
            static::REPOSITORY_NAME_KEY => $repositoryName ?? '',
            static::REPOSITORY_OWNER_KEY => $owner ?? '',
            static::IDENTIFIER_NAME_KEY => $this->prepareIdentifier($owner ?? '', $repositoryName ?? ''),
        ]);
    }

    private function getUrlPath(string $url): string
    {
        $parsed = parse_url($url);

        return $parsed['path'] ?? '';
    }

    private function prepareIdentifier(string $owner, string $repositoryName): string
    {
        return $owner . '/' . $repositoryName;
    }
}
