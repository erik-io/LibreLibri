<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Resource-Klasse für die Transformation von Autoren-Modellen in JSON-Responses.
 *
 * Die Klasse implementiert das Transformer Pattern für die API-Darstellung von Autoren
 * und stellt zusätzliche Hilfsmethoden für die Formatierung bereit.
 */
class AuthorResource extends JsonResource
{
    /**
     * Transformiert das Author-Modell in ein Array für die API-Response.
     *
     * @param Request $request Der aktuelle HTTP-Request
     * @return array Die transformierten Daten
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
        ];
    }
}
