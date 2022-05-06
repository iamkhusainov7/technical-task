<?php

namespace App\Services;

use Illuminate\Support\Collection;

interface RepositoryIdentifierParserServiceInterface
{
    /**
     * Repository owner key in the collection after parsing.
     */
    public const REPOSITORY_OWNER_KEY = 'repository_owner';

    /**
     * Repository name key in the collection after parsing.
     */
    public const REPOSITORY_NAME_KEY = 'repository_name';

    /**
     * Repository identifier key in the collection after parsing.
     */
    public const IDENTIFIER_NAME_KEY = 'identifier';

    /**
     * @param  string  $content
     *
     * @return Collection
     */
    public function parse(string $content): Collection;
}
