<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Responsible extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'uuid',
        'name',
        'created_at',
        'updated_at',
    ];

    protected $hidden = ['id'];

    public function meetings(): HasMany
    {
        return $this->hasMany(Meeting::class, 'meeting_id', 'uuid');
    }
}
