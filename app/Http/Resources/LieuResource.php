<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LieuResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "nom" => $this->nom,
            "description" => $this->desciption,
            "lieu" => DictionnaireResource::make($this->dico),
            "likes" => $this->likes,
            "dislikes" => $this->dislikes,
            "images" => ImageResource::collection($this->images)
        ];
    }
}
