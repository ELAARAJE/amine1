<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dish extends Model
{
    use HasFactory;

    protected $fillable = [
        'menu_category_id',
        'name',
        'description',
        'price',
        'allergens',
        'position',
        'is_visible',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'allergens' => 'array',
            'is_visible' => 'boolean',
        ];
    }

    public function category()
    {
        return $this->belongsTo(MenuCategory::class, 'menu_category_id');
    }
}
