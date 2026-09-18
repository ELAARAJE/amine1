<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExceptionalClosure extends Model
{
    protected $table = 'closures';

    protected $fillable = [
        'date',
        'reason',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
        ];
    }
}
