<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['project_id', 'title', 'completed', 'difficulty_id'];

    protected $casts = [
        'completed' => 'boolean',
    ];

    /**
     * @return BelongsTo|Builder|Project
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * @return BelongsTo|Builder|Difficulty
     */
    public function difficulty(): BelongsTo {
        return $this->belongsTo(Difficulty::class);
    }

    public function toResourceArray(): array
    {
        return $this->only([
            'id',
            'title',
            'completed',
            'difficulty_id',
            'created_at',
            'updated_at',
        ]);
    }
}
