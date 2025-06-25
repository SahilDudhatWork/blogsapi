<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'title',
        'content',
        'image_path',
        'table_of_content',
    ];

    protected $casts = [
        'table_of_content' => 'array',
    ];

    public function getImagePathAttribute($value)
    {
        return isset($value) && !empty($value) ? url('/storage/' . $value) : null;
    }
}
