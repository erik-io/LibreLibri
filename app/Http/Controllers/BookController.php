<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with(['authors', 'categories'])->get();
        return Inertia::render('Books/Index',
            ['books' => BookResource::collection($books)]);
    }
}
