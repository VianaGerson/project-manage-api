<?php

namespace App\Repositories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;

class ProjectRepository
{
  /**
   * @return Collection<int, Project>
   */
  public function getAll(): Collection
  {
    return Project::with('tasks')->get();
  }

  /**
   * @return Collection<int, Project>
   */
  public function getAllWithDifficulty(): Collection
  {
    return Project::with('tasks.difficulty')->get();
  }

  /**
   * @param int $id
   * @return Project|null
   */
  public function findById(int $id): ?Project
  {
    return Project::with('tasks.difficulty')->find($id);
  }

  /**
   * @param array $data
   * @return Project
   */
  public function create(array $data): Project
  {
    return Project::create($data);
  }
}
