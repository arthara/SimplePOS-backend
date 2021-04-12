<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class StoreResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if($this->logo == null)
            $logoUrl = null;
        else
            $logoUrl = URL::to("/api/stores/logo");

        return [
            "id" => $this->id,
            "user_id" => $this->user_id,
            "name" => $this->name,
            "logo" => $logoUrl,
            "address" => $this->address,
            "phone_number" => $this->phone_number,
            "note_receipt" => $this->note_receipt,
        ];
    }
}
