<?php

namespace App\Repositories\impl;

use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Support\Collection;

class CategoryRepositoryImpl implements CategoryRepository
{
    public function findByCategory(string $category): ?Category
    {
        return Category::where('category', $category)->first();
    }

    public function findAll(): Collection
    {
        return Category::all();
    }
}
