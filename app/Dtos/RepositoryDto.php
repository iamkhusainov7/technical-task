<?php

namespace App\Dtos;

use App\Entities\RepositoryEntity;

class RepositoryDto extends DtoTemplate
{
    public string             $name;
    public string             $fullName;
    public string             $language;
    public int                $watchers;
    public int                $forks;
    public int                $stars;
    public int                $openIssues;
    public bool               $has_issues;
    public bool               $isPrivate;
    public \DateTimeInterface $updatedAt;

    public static function fromEntity(RepositoryEntity $entity): self
    {
        return new self([
            'name' => $entity->name,
            'fullName' => $entity->fullName,
            'language' => $entity->language,
            'watchers' => $entity->watchers,
            'forks' => $entity->forks,
            'stars' => $entity->stars,
            'openIssues' => $entity->openIssues,
            'has_issues' => $entity->has_issues,
            'isPrivate' => $entity->isPrivate,
            'updatedAt' => $entity->updatedAt,
        ]);
    }
}
