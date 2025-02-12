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
        $books = BookResource::collection(Book::all());
        return Inertia('Books/Index', ['books' => $books]);
    }
}
