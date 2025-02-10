<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Resource-Klasse für die Transformation von Book-Modellen in JSON-Responses.
 *
 * Diese Klasse kapselt die Logik für die API-Darstellung von Büchern und ihren Beziehungen.
 * Sie implementiert das Adapter Pattern, indem sie das interne Modell in ein externes
 * API-Fomat transformiert.
 */
class BookResource extends JsonResource
{
    /**
     * Transformiert das Book-Modell in ein Array für die API-Response.
     *
     * @param Request $request Der aktuelle HTTP-Request
     * @return array Die transformierten Daten
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'isbn' => [
                'isbn10' => $this->isbn10,
                'isbn13' => $this->isbn13,
            ],
            'edition' => $this->edition,
            'publication_date' => $this->publication_date,

            // whenLoaded() prüft, ob eine Beziehung bereits geladen wurde
            // Dies verhindert das N+1 Query Problem
            // Beziehungen müssen im Controller mit with() geladen werden
            'authors' => AuthorResource::collection($this->whenLoaded('authors')), // ::collection() für Has-Many Beziehungen
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
            'format' => new BookFormatResource($this->whenLoaded('format')), // new für BelongsTo Beziehungen


            // Verfügbarkeitsinformationen
            'available' => $this->whenLoaded('copies', function() {
                return $this->copies->filter->isAvailable()->count();
            }, 0),

            // Metadaten
            'created_at' => $this->created_at->toISOString(),
            'updated_at' => $this->updated_at->toISOString(),
            'deleted_at' => $this->deleted_at ? $this->deleted_at->toISOString() : null,
        ];
    }

    /**
     * Fügt zusätzliche Metadaten zur Resource hinzu.
     */
    public function with(Request $request): array
    {
        return [
            'meta' => [
                'api_version' => '1.0',
            ],
        ];
    }
}
