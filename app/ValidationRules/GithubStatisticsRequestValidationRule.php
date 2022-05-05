<?php

namespace App\ValidationRules;

use App\Services\GithubRepositoryNameParserService;
use App\Services\RepositoryIdentifierParserServiceInterface;

class GithubStatisticsRequestValidationRule
{
    /**
     * Returns validation Rule for the GitHub repository.
     *
     * @return array
     */
    public static function getRules(): array
    {
        $requestedRepositories = collect();

        return [
            'repositories' => 'required|min:2,max:10',
            'repositories.*.identifier' => [
                'required',
                'distinct',
                function ($attr, $value, $fail) use ($requestedRepositories) {
                    $parsedIdentifier = app(GithubRepositoryNameParserService::class)->parse($value);

                    if (
                        ! $parsedIdentifier->get(
                            RepositoryIdentifierParserServiceInterface::REPOSITORY_OWNER_KEY
                        )
                        || ! $parsedIdentifier->get(
                            RepositoryIdentifierParserServiceInterface::REPOSITORY_NAME_KEY
                        )
                    ) {
                        $fail('Wrong format repository identifier');
                    }

                    $jointIdentifier = $parsedIdentifier->join(',');

                    if ($requestedRepositories->get($jointIdentifier)) {
                        $fail("$attr.identifier field has a duplicate value.");
                    }

                    $requestedRepositories->put($parsedIdentifier->join(','), true);
                }
            ]
        ];
    }
}
