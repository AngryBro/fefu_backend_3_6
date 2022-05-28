<?php

namespace App\Http\Resources;

use App\Models\News;
use Illuminate\Http\Resources\Json\JsonResource;


class NewsResources extends JsonResource
{

    public function toArray($request)
    {
        return [
			'title'=>$this->title,
			'text'=>$this->text,
			'published_at'=>$this->published_at,
			'slug'=>$this->slug
		];
    }
}
