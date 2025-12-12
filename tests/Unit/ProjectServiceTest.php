<?php

namespace Tests\Unit;

use App\Models\Project;
use App\Models\Task;
use App\Models\Difficulty;
use App\Repositories\ProjectRepository;
use App\Services\ProjectService;
use Illuminate\Database\Eloquent\Collection;
use Mockery;
use Tests\TestCase;

class ProjectServiceTest extends TestCase
{
    /**
     * @var Mockery\MockInterface|ProjectRepository
     */
    protected $projectRepositoryMock;

    protected ProjectService $projectService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->projectRepositoryMock = Mockery::mock(ProjectRepository::class);

        $this->projectService = new ProjectService($this->projectRepositoryMock);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    private function createTaskStub(int $difficultyId, int $effortPoints, bool $completed = false): Task
    {
        $task = new Task(['completed' => $completed]);

        $task->setRelation('difficulty', new Difficulty([
            'id' => $difficultyId,
            'effort_points' => $effortPoints
        ]));

        return $task;
    }

    /** @test */
    public function it_calculates_zero_progress_for_an_empty_project()
    {
        $project = new Project(['id' => 1, 'name' => 'Zero Task']);
        $project->setRelation('tasks', new Collection());

        $this->projectRepositoryMock
            ->shouldReceive('findById')
            ->once()
            ->andReturn($project);

        $resultProject = $this->projectService->getProjectById(1);

        $this->assertEquals(0.0, $resultProject->progress);
    }

    /** @test */
    public function it_calculates_zero_progress_when_no_tasks_are_completed()
    {
        $tasks = new Collection([
            $this->createTaskStub(1, 1, false),   // Baixa (1 ponto)
            $this->createTaskStub(2, 4, false),   // Média (4 pontos)
            $this->createTaskStub(3, 12, false),  // Alta (12 pontos)
        ]);

        $project = new Project(['id' => 2, 'name' => 'All Pending']);
        $project->setRelation('tasks', $tasks);

        $this->projectRepositoryMock
            ->shouldReceive('findById')
            ->once()
            ->andReturn($project);

        $resultProject = $this->projectService->getProjectById(2);

        $this->assertEquals(0.0, $resultProject->progress);
    }

    /** @test */
    public function it_calculates_partial_progress_correctly_based_on_effort_points()
    {
        // 1. Arrange: Cenário do usuário: Apenas a tarefa Média (4 pontos) concluída.
        // Esforço Total: 1 + 4 + 12 = 17. Esforço Concluído: 4.
        // Progresso Esperado: 4/17 * 100 = 23.53%
        $tasks = new Collection([
            $this->createTaskStub(1, 1, false),
            $this->createTaskStub(2, 4, true),
            $this->createTaskStub(3, 12, false),
        ]);

        $project = new Project(['id' => 3, 'name' => 'Partial Progress']);
        $project->setRelation('tasks', $tasks);

        $this->projectRepositoryMock
            ->shouldReceive('findById')
            ->once()
            ->andReturn($project);

        $resultProject = $this->projectService->getProjectById(3);

        $this->assertEquals(23.53, $resultProject->progress);
    }

    /** @test */
    public function it_calculates_one_hundred_percent_progress_when_all_tasks_are_completed()
    {
        // 1. Arrange: Todas as tarefas concluídas.
        // Esforço Total: 1 + 4 + 12 = 17. Esforço Concluído: 17.
        // Progresso Esperado: 17/17 * 100 = 100%
        $tasks = new Collection([
            $this->createTaskStub(1, 1, true),
            $this->createTaskStub(2, 4, true),
            $this->createTaskStub(3, 12, true),
        ]);

        $project = new Project(['id' => 4, 'name' => 'All Done']);
        $project->setRelation('tasks', $tasks);

        $this->projectRepositoryMock
            ->shouldReceive('findById')
            ->once()
            ->andReturn($project);

        $resultProject = $this->projectService->getProjectById(4);

        $this->assertEquals(100.0, $resultProject->progress);
    }
}
