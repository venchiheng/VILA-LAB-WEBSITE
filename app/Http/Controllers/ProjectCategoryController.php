<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProjectCategoryResource;
use App\Services\ProjectCategoryService;
use Illuminate\Http\Request;

class ProjectCategoryController extends Controller
{
    protected $categoryService;

    public function __construct(ProjectCategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        return ProjectCategoryResource::collection(
            $this->categoryService->getAll()
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        return new ProjectCategoryResource(
            $this->categoryService->create($data)
        );
    }
}
