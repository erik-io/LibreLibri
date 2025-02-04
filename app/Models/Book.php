<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title',
        'isbn13',
        'isbn10',
        'edition',
        'format_id',
        'publication_date',
    ];

    public function authors()
    {
        return $this->belongsToMany(Author::class, 'books_authors', 'book_id', 'author_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'books_categories', 'book_id', 'category_id');
    }

    public function copies()
    {
        return $this->hasMany(Copy::class, 'book_id');
    }
}
