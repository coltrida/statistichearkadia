<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ActivityClientResource extends JsonResource
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
            'attivita' => $this->activity->name,
            'ragazzo' => $this->client->name,
            'quantita' => $this->quantita,
            'costo' => $this->costo,
            'giorno' => $this->giorno,
        ];
    }
}
