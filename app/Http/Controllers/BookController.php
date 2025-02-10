<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with(['authors', 'categories']);
        return inertia('Books/Index',
            ['books' => BookResource::collection($books)]);
    }
}
