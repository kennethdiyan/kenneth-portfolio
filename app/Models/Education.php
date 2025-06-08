<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;

    protected $table = 'educations';

    protected $fillable = [
        'degree',
        'field_of_study',
        'institution',
        'location',
        'start_date',
        'end_date',
        'gpa',
        'description',
        'achievements',
        'is_current',
        'is_active'
    ];

    protected $casts = [
        'achievements' => 'array',
        'start_date' => 'date',
        'end_date' => 'date',
        'is_current' => 'boolean',
        'is_active' => 'boolean'
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('start_date', 'desc');
    }
}
