<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ProjectService;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    private ProjectService $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    public function indexProjects()
    {
        $projects = $this->projectService->getAllProjects();
        return response()->json($projects);
    }

    public function showProject(int $id)
    {
        $project = $this->projectService->getProjectById($id);

        if (!$project) {
            return response()->json(['message' => 'Project not found'], 404);
        }

        return response()->json($project);
    }

    public function storeProject(Request $request)
    {
        $data = $request->validate(['name' => 'required|string|max:255']);
        $project = $this->projectService->createProject($data);

        return response()->json($project, 201);
    }
}
