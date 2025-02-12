<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Resource-Klasse für die Transformation von Book-Modellen in JSON-Responses.
 *
 * Sie implementiert das Transformer Pattern für die API-Darstellung von Büchern.
 * Sie wandelt interne Modell-Strukturen in ein präsentationsfreundliches Format um.
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
                // Wir prüfen ob ISBN-10 existiert, da sie optional ist
                'isbn10' => $this->isbn10 ? $this->formatISBN10($this->isbn10) : null,
                'isbn13' => $this->formatISBN13($this->isbn13),
            ],
            // Optimierte Autorenstruktur für einfachere Verwendung im Frontend
            'authors' => $this->whenLoaded('authors', function() {
                return [
                    // Vorformatierter String für direkte Anzeige
                    'full_name' => $this->authors->map(fn($author) => $author->getFullName())->join(', '),
                    // Vollständige Autorenliste für erweiterte Funktionen
                    'list' => AuthorResource::collection($this->authors)
                ];
            }),
            'edition' => $this->edition,
            'publication_date' => $this->publication_date,

            // whenLoaded() prüft, ob eine Beziehung bereits geladen wurde
            // Dies verhindert das N+1 Query Problem
            // Beziehungen müssen im Controller mit with() geladen werden
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
            'format' => new BookFormatResource($this->whenLoaded('format')), // new für BelongsTo Beziehungen


            // Verfügbarkeitsinformationen
            'status' => $this->whenLoaded('copies', function() {
                // Wir prüfen alle Exemplare des Buches
                $availableCopies = $this->copies->filter->isAvailable()->count();
                $totalCopies = $this->copies->count();

                if ($totalCopies === 0) {
                    return ['type' => 'unavailable', 'label' => 'Nicht verfügbar'];
                }

                if ($availableCopies > 0)
                {
                    return ['type' => 'available', 'label' => 'Verfügbar'];
                }

                // Prüfen auf Reservierungen
                $reservedCopies = $this->copies->filter->isReserved()->count();

                if ($reservedCopies > 0)
                {
                    return ['type' => 'reserved', 'label' => 'Reserviert'];
                }

                return ['type' => 'loaned', 'label' => 'Ausgeliehen'];
            }),
        ];
    }

    /**
     * Formatiert eine ISBN-13 Nummer in ein lesbares Format mit Bindestrichen.
     * Format: XXX-X-XXXX-XXXX-X
     *
     * @param string $isbn Die unformatierte ISBN-13 Nummer
     * @return string Die formatierte ISBN-13 Nummer mit Bindestrichen
     */
    private function formatISBN13(string $isbn): string
    {
        // Entferne alle nicht-numerischen Zeichen für den Fall,
        // dass die ISBN bereits Bindestriche oder andere Zeichen enthält
        $clean = preg_replace('/[^0-9]/', '', $isbn);

        // Prüfe, ob wir eine valide 13-stellige Nummer haben
        if (strlen($clean) !== 13) {
            return $isbn; // Gebe Originalwert zurück, wenn Format nicht stimmt
        }

        // Füge Bindestriche an den richtigen Stellen ein
        // Gruppe 1: ISBN-Präfix (3 Ziffern)
        // Gruppe 2: Ländercode (1 Ziffer)
        // Gruppe 3: Verlagsnummer (4 Ziffern)
        // Gruppe 4: Titelnummer (4 Ziffern)
        // Gruppe 5: Prüfziffer (1 Ziffer)
        return preg_replace(
            '/^(\d{3})(\d)(\d{4})(\d{4})(\d)$/',
            '$1-$2-$3-$4-$5',
            $clean
        );
    }

    /**
     * Formatiert eine ISBN-10 Nummer in ein lesbares Format mit Bindestrichen.
     * Format: X-XXXX-XXXX-X
     *
     * @param string $isbn Die unformatierte ISBN-10 Nummer
     * @return string Die formatierte ISBN-10 Nummer mit Bindestrichen
     */
    private function formatISBN10(string $isbn): string
    {
        // Entferne alle nicht-numerischen Zeichen für den Fall,
        // dass die ISBN bereits Bindestriche oder andere Zeichen enthält,
        // aber behalte 'X' als mögliche Prüfziffer
        $clean = preg_replace('/[^0-9X]/', '', $isbn);

        // Prüfe, ob wir eine valide 10-stellige Nummer haben
        if (strlen($clean) !== 10) {
            return $isbn; // Gebe Originalwert zurück, wenn Format nicht stimmt
        }

        // Füge Bindestriche an den richtigen Stellen ein
        // Gruppe 1: Ländercode (1 Ziffer)
        // Gruppe 2: Verlagsnummer (4 Ziffern)
        // Gruppe 3: Titelnummer (4 Ziffern)
        // Gruppe 4: Prüfziffer (1 Ziffer oder 'X')
        return preg_replace(
            '/^(\d)(\d{4})(\d{4})(\d|X)$/',
            '$1-$2-$3-$4',
            $clean
        );
    }
}
