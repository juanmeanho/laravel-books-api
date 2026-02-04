<?php

namespace App\Http\Controllers\Books;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Author;
use App\Events\BookCreated;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BookController extends Controller
{
    public function index()
    {
        $users = Book::all();
        return response()->json($users);
    }

    public function show($id)
    {
        $user = Book::findOrFail($id);
        return response()->json($user);
    }

    public function indexView()
    {
        $books = Book::with('author')->get();
        return view('books.index', compact('books'));
    }

    public function createView()
    {
        $authors = Author::all();
        return view('books.create', compact('authors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id'
        ]);

        $book = Book::create([
            'title' => $request->title,
            'author_id' => $request->author_id
        ]);

        event(new BookCreated($book));

        return response()->json([
            'message' => 'Libro creado exitosamente',
            'book' => $book
        ], 201);
    }

    public function editView($id)
    {
        $book = Book::findOrFail($id);
        $authors = Author::all();
        return view('books.edit', compact('book', 'authors'));
    }

    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        $request->validate([
            'title'     => 'required|string|max:255',
            'author_id'=> 'required|exists:authors,id'
        ]);

        $oldAuthorId = $book->author_id;

        $book->update([
            'title'     => $request->title,
            'author_id' => $request->author_id
        ]);

        if ($oldAuthorId != $book->author_id) {

            $oldAuthor = Author::find($oldAuthorId);
            if ($oldAuthor) {
                $oldAuthor->decrement('books_count');
            }

            $newAuthor = Author::find($book->author_id);
            if ($newAuthor) {
                $newAuthor->increment('books_count');
            }
        }
        return response()->json([
            'message' => 'Libro creado exitosamente',
            'book' => $book
        ], 201);
    }

    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->author->decrement('books_count');
        $book->delete();

        return response()->json([
            'success' => true,
            'message' => 'Libro eliminado correctamente.'
        ]); 
    }


    public function export()
    {
        return Excel::download(new class implements FromCollection, WithHeadings {
            public function collection()
            {
                return Book::with('author')
                    ->select('id','title','author_id','created_at','updated_at')
                    ->get();
            }

            public function headings(): array
            {
                return ['ID', 'Título', 'ID Autor', 'Creado en', 'Actualizado en'];
            }
        }, 'books.xlsx');
    }
}
