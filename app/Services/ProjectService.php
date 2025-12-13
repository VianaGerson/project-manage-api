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
    return $this->projectRepository->getAll();      
  }

  /**
   * @param int $id
   * @return Project|null
   */
  public function getProjectById(int $id): ?Project
  {
    $project = $this->projectRepository->findById($id);

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
}
