<?php

namespace App\Resolvers;

interface IResolver
{
    public function resolve(string $path, string $directory);
}
