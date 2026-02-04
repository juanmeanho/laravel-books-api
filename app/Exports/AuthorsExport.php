<?php

namespace App\Exports;

use App\Author;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AuthorsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Author::select('id','name','books_count','created_at','updated_at')->get();
    }

    public function headings(): array
    {
        return ['ID', 'Nombre', 'Cantidad de Libros', 'Creado en', 'Actualizado en'];
    }
}
