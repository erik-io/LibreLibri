<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Testing\Fluent\Concerns\Has;

/**
 * Book-Modell: Repräsentiert ein Buch in der Datenbank.
 *
 * @property int $id
 * @property string $title
 * @property string|null $isbn10
 * @property string $isbn13
 * @property string $edition
 * @property int $format_id
 * @property \DateTime $publication_date
 * @property \DateTime $created_at
 * @property \DateTime $updated_at
 * @property \DateTime|null $deleted_at
 */
class Book extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Die Attribute, die zugewiesen werden dürfen.
     */
    protected $fillable = [
        'title',
        'isbn13',
        'isbn10',
        'edition',
        'format_id',
        'publication_date',
    ];

    /**
     * Die Attribute, die als Datum behandelt werden sollen
     */
    protected $dates = [
        'publication_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $with = [
        'authors',
        'categories',
    ];

    /**
     * Die Beziehungen zu den Autoren des Buches.
     *
     * @return BelongsToMany
     */
    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class, 'books_authors')
            ->withTimestamps();
    }

    /**
     * Die Beziehungen zu den Kategorien des Buches.
     *
     * @return BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'books_categories')
            ->withTimestamps();
    }

    /**
     * Die Beziehungen zum Format des Buches.
     *
     * @return BelongsTo
     */
    public function format(): BelongsTo
    {
        return $this->belongsTo(BookFormat::class, 'format_id');
    }

    /**
     * Die Beziehungen zu den Exemplaren des Buches.
     *
     * @return HasMany
     */
    public function copies(): HasMany
    {
        return $this->hasMany(Copy::class, 'book_id');
    }
}
