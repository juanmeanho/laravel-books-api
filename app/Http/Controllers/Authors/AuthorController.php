<?php

namespace App\Http\Controllers\Authors;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Author;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AuthorController extends Controller
{
    public function index()
    {
        $users = Author::all();
        return response()->json($users);
    }

    public function show($id)
    {
        $user = Author::findOrFail($id);
        return response()->json($user);
    }

    public function indexView()
    {
        $authors = Author::all();
        return view('authors.index', compact('authors'));
    }

    public function createView()
    {
        return view('authors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $author = Author::create([
            'name' => $request->name
        ]);

        return response()->json([
            'message' => 'Autor creado exitosamente',
            'author' => $author
        ], 201); 
    }

    public function editView($id)
    {
        $author = Author::findOrFail($id);
        return view('authors.edit', compact('author'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $author = Author::findOrFail($id);
        $author->update($request->only('name'));

        return response()->json([
            'message' => 'Autor actualizado',
            'author' => $author
        ]);
    }

    public function destroy($id)
    {
        Author::destroy($id);
        
        return response()->json([
            'success' => true,
            'message' => 'Autor eliminado correctamente.'
        ]);    
    }

    public function export()
    {
        return Excel::download(new class implements FromCollection, WithHeadings {
            public function collection()
            {
                return Author::select('id','name','books_count','created_at','updated_at')->get();
            }

            public function headings(): array
            {
                return ['ID','Nombre','Cantidad de Libros','Creado en','Actualizado en'];
            }
        }, 'authors.xlsx');
    }
}
