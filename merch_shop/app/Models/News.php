<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;

class News extends Model
{
    use HasFactory, Sluggable;

    protected $dates = ['published_at'];
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function scopePublished(Builder $builder) : Builder
    {
        return $builder->where('published_at', '<', Carbon::now());
    }
}