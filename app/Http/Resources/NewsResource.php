<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,

            'title' => $this->title,

            'slug' => $this->slug,

            'category' => $this->category,

            'summary' => $this->summary,

            'content' => $this->content,

            'image' => $this->image
                ? asset('storage/' . $this->image)
                : null,

            'button' => [
                'text' => $this->button_text,
                'url' => $this->button_url,
            ],

            'published_at' => $this->published_at?->toISOString(),

            'is_featured' => $this->is_featured,

            'url' => url('/actualites/' . $this->slug),
        ];
    }
}
