<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Support\Collection;

interface CategoryRepository
{
    public function findAll(): Collection;

    public function findByCategory(string $category): ?Category;
}
