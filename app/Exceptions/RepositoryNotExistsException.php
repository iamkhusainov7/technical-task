<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RepositoryNotExistsException extends NotFoundHttpException
{
    protected const MESSAGE = 'Given repository does not exist. Repository name: %s';

    /**
     * @param  string  $repository Repository name.
     */
    public function __construct(string $repository)
    {
        parent::__construct(sprintf(static::MESSAGE, trim($repository, "\t\n\r\0\x0B\/")));
    }
}
