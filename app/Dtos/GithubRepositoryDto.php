<?php

namespace App\Dtos;

class GithubRepositoryDto extends DtoTemplate
{
    public ?string $name;
    public ?string $full_name;
    public ?string $language;
    public ?int    $watchers_count;
    public ?int    $forks_count;
    public ?int    $stargazers_count;
    public ?int    $open_issues_count;
    public ?bool   $has_issues;
    public ?bool   $private;
    public ?string $updated_at;
}
