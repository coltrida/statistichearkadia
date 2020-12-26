<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class TripClientResource extends JsonResource
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
            'kmPercorsi' => $this->trip[0]->kmPercorsi,
            'giorno' => $this->trip[0]->giorno,
            'operatore' => User::find($this->trip[0]->user_id)->name,
        ];
    }
}
