<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if($this->picture == null)
            $pictureUrl = null;
        else
            $pictureUrl = URL::to("/products/images/".$this->id);

        return [
            'id' => $this->id,
            'category_id' => $this->category_id,
            'name' => $this->name,
            'picture' => $pictureUrl,
            'total' => $this->total,
            'selling_price' => $this->selling_price,
            'cost_price' => $this->cost_price,
        ];
    }
}
