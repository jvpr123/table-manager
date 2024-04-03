<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }
}
