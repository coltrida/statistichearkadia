<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StatistichePresenzeRagazziResource extends JsonResource
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
            'attivita' => $this->activity->name,
            'quantita' => $this->quantita,
            'giorno' => $this->giorno,
        ];
    }
}
