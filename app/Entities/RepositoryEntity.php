<?php

namespace App\Entities;

class RepositoryEntity
{
    /**
     * @param  string  $name
     * @param  string  $fullName
     * @param  string  $language
     * @param  int  $watchers
     * @param  int  $forks
     * @param  int  $stars
     * @param  int  $openIssues
     * @param  bool  $has_issues
     * @param  bool  $isPrivate
     * @param  \DateTimeInterface  $updatedAt
     * @param  string  $localIdentifier
     */
    public function __construct(
        public readonly string $name,
        public readonly string $fullName,
        public readonly string $language,
        public readonly int $watchers,
        public readonly int $forks,
        public readonly int $stars,
        public readonly int $openIssues,
        public readonly bool $has_issues,
        public readonly bool $isPrivate,
        public readonly \DateTimeInterface $updatedAt,
        public readonly string $localIdentifier,
    ) {
    }
}
