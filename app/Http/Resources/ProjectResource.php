<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'           => $this->id,
            'title'        => $this->title,
            'description'  => $this->description,
            'status'       => $this->status,
            'is_featured'  => (bool) $this->is_featured,
            'banner_image' => $this->banner_image,

            'category'     => new ProjectCategoryResource($this->whenLoaded('category')),
            'members'      => ProjectMemberResource::collection($this->whenLoaded('members')),
            'progress'     => ProjectProgressResource::collection($this->whenLoaded('progress')),
            //'publications' => PublicationResource::collection($this->whenLoaded('publications')),

            'created_at'   => $this->created_at,
        ];
    }
}
