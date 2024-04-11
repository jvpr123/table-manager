<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Local extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'uuid',
        'title',
        'description',
        'created_at',
        'updated_at',
    ];

    protected $hidden = ['id'];

    public function meetings(): HasMany
    {
        return $this->hasMany(Meeting::class, 'local_id', 'uuid');
    }
}
