<?php

namespace App\Dtos;

use ReflectionClass;
use ReflectionProperty;

abstract class DtoTemplate
{
    public function __construct(array $parameters = [])
    {
        $class = new ReflectionClass(static::class);

        foreach ($class->getProperties(ReflectionProperty::IS_PUBLIC) as $reflectionProperty){
            $property = $reflectionProperty->getName();
            $this->{$property} = $parameters[$property] ?? null;
        }
    }
}
