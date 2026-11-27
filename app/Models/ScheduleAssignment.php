<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ScheduleAssignment extends Model
{
    protected $fillable = [
        'work_schedule_id',
        'assignable_type',
        'assignable_id',
        'day_of_week',
        'room',
        'quota',
        'status'
    ];

    public function workSchedule(): BelongsTo
    {
        return $this->belongsTo(WorkSchedule::class);
    }

    public function assignable(): MorphTo
    {
        return $this->morphTo();
    }
}
