<?php

namespace App\Exports;

use App\Book;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BooksExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Book::select('id','title','author_id','created_at','updated_at')->get();
    }

    public function headings(): array
    {
        return ['ID','Título','ID Autor','Creado en','Actualizado en'];
    }
}
