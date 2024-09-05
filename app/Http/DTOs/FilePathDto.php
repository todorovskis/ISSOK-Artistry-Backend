<?php

namespace App\Http\DTOs;

class FilePathDto
{
    public array $paths;

    public function __construct(array $paths)
    {
        $this->paths = $paths;
    }
}

