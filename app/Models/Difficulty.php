<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Difficulty extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'effort_points'];

    /**
     * @return HasMany|Builder|Task
     */
    public function tasks(): HasMany {
        return $this->hasMany(Task::class);
    }
}
