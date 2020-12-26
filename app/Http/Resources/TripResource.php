<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TripResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'kmPercorsi' => $this->kmPercorsi,
            'giorno' => $this->giorno,
            'vettura' => $this->car->name,
            'operatore' => $this->user->name,
            'passeggeri' => PasseggeriResource::collection($this->clienttrip)
        ];
    }
}
