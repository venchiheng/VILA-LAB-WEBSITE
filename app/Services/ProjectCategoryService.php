<?php

namespace App\Services;

use App\Models\ProjectCategory;

class ProjectCategoryService
{
    public function getAll()
    {
        return ProjectCategory::all();
    }

    public function create(array $data)
    {
        return ProjectCategory::create($data);
    }
}
