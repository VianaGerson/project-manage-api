<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * @return HasMany|Builder|Task
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function toResourceArray(): array
    {
        return $this->only([
            'id',
            'name',
            'progress',
            'created_at',
            'updated_at',
        ]);
    }

    protected function getProgressAttribute(): int
    {
        if ($this->tasks->isEmpty()) {
            return 0;
        }

        $totalEffort = 0;
        $completedEffort = 0;

        foreach ($this->tasks as $task) {
            $effort = $task->difficulty?->effort_points ?? 0;

            $totalEffort += $effort;

            if ($task->completed) {
                $completedEffort += $effort;
            }
        }

        if ($totalEffort === 0) {
            return 0;
        }

        return (int) round(($completedEffort / $totalEffort) * 100);
    }
}
