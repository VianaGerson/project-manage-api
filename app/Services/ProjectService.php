<?php

namespace App\Services;

use App\Models\Project;
use App\Repositories\ProjectRepository;
use Illuminate\Database\Eloquent\Collection;

class ProjectService
{
  private ProjectRepository $projectRepository;

  public function __construct(ProjectRepository $projectRepository)
  {
    $this->projectRepository = $projectRepository;
  }

  /**
   * @return Collection
   */
  public function getAllProjects(): Collection
  {
    $projects = $this->projectRepository->getAllWithDifficulty();      

    return $projects->map(function ($project) {
      $project->progress = $this->calculateProgress($project);
      return $project;
    });
  }

  /**
   * @param int $id
   * @return Project|null
   */
  public function getProjectById(int $id): ?Project
  {
    $project = $this->projectRepository->findById($id);

    if ($project) {
      $project->progress = $this->calculateProgress($project);
    }

    return $project;
  }

  /**
   * @param array $data
   * @return Project
   */
  public function createProject(array $data): Project
  {
    return $this->projectRepository->create($data);
  }

  /**
   * @param Project $project
   * @return float
   */
  private function calculateProgress(Project $project): float
  {
    if ($project->tasks->isEmpty()) {
      return 0.0;
    }

    $totalEffort = 0;
    $completedEffort = 0;

    foreach ($project->tasks as $task) {
      $effort = $task->difficulty?->effort_points ?? 0;

      $totalEffort += $effort;

      if ($task->completed) {
        $completedEffort += $effort;
      }
    }

    if ($totalEffort === 0) {
      return 0.0;
    }

    return round(($completedEffort / $totalEffort) * 100, 2);
  }
}
