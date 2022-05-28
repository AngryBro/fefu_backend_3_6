<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;


class News extends Model
{
    use HasFactory, Sluggable;
	public function sluggable() : array {
		return [
			'slug'=> [
				'source'=>'title'
			]
		];
	}
	public function scopePublished(Builder $builder): Builder {
		return $builder->where('published_at','<',Carbon::now());
	}
}
