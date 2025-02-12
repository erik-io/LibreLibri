<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transformiert das Category-Modell in ein Array für die API-Response.
     *
     * Diese Methode reduziert die Ausgabe auf die wesentlichen Felder:
     * - id: Die eindeutige Kennung der Kategorie
     * - parent_id: Die ID der übergeordneten Kategorie (optional)
     * - code: Der Thema-Code der Kategorie (aus dem value-Feld)
     * - label: Der Anzeigename der Kategorie (aus dem description-Feld)
     *
     * @param Request $request Der aktuelle HTTP-Request
     * @return array Die transformierten Daten
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            // Wir fügen parent_id nur hinzu, wenn sie existiert
            // Wenn die Bedingung false ist, wird das Feld komplett aus der Response entfernt
            'parent_id' => $this->when($this->parent_id, $this->parent_id),
            'code' => $this->value, // Der EDItEUR Thema-Code
            'label' => $this->description,
        ];
    }
}
