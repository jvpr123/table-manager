<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Meeting extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'uuid',
        'date',
        'description',
        'created_at',
        'updated_at',
    ];

    protected $hidden = ['id'];

    public function responsible(): BelongsTo
    {
        return $this->belongsTo(Responsible::class, 'responsible_id', 'uuid');
    }

    public function period(): BelongsTo
    {
        return $this->belongsTo(Period::class, 'period_id', 'uuid');
    }

    public function local(): BelongsTo
    {
        return $this->belongsTo(Local::class, 'local_id', 'uuid');
    }
}
