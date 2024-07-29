<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class MeetingGroup extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'uuid',
        'name',
        'description',
        'created_at',
        'updated_at',
    ];

    protected $hidden = ['id'];

    public function periods(): BelongsToMany
    {
        return $this->belongsToMany(
            Period::class,
            'meeting_group_periods',
            'meeting_group_id',
            'period_id',
            'uuid',
            'uuid',
        );
    }
}
