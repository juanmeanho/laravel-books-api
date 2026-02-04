@extends('layouts.app-auth')

@section('title', 'Libros')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
    <div class="d-flex align-items-center mb-3">
        <div class="bg-success bg-opacity-10 p-2 rounded-3 me-3">
            <i class="bi bi-book text-success fs-3"></i>
        </div>
        <div>
            <h2 class="mb-0 fw-bold h4">Libros</h2>
            <small class="text-muted">Gestión del catálogo de libros</small>
        </div>
    </div>
    
    <div class="d-flex flex-wrap gap-2">
        <button id="exportBooks" class="btn btn-outline-success d-flex align-items-center">
            <i class="bi bi-download me-1"></i>
            <span class="d-none d-sm-inline">Exportar</span>
        </button>
        
        <a href="{{ route('books.create') }}" class="btn btn-success d-flex align-items-center text-white">
            <i class="bi bi-plus-lg me-1"></i>
            <span class="d-none d-sm-inline">Nuevo</span>
        </a>
    </div>
</div>

<div id="message"></div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-success text-white py-3">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="bi bi-book-half me-2"></i>Lista de Libros
            </h5>
            <div>
                <span class="badge bg-light text-success">Total: {{ count($books) }}</span>
            </div>
        </div>
    </div>
    
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">
                            <i class="bi bi-hash me-1 text-muted"></i>ID
                        </th>
                        <th>
                            <i class="bi bi-bookmark me-1 text-muted"></i>Título
                        </th>
                        <th>
                            <i class="bi bi-person me-1 text-muted"></i>Autor
                        </th>
                        <th class="text-end pe-4">
                            <i class="bi bi-gear me-1 text-muted"></i>Acciones
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($books as $book)
                    <tr id="book-{{ $book->id }}">
                        <td class="ps-4">
                            <span class="badge bg-success bg-opacity-10 text-success">{{ $book->id }}</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div>
                                    <div class="fw-medium">{{ $book->title }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div>
                                    <div class="fw-medium">{{ $book->author->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="text-end pe-4">
                            <div class="btn-group" role="group">
                                <a href="{{ route('books.edit', $book->id) }}" 
                                   class="btn btn-outline-primary btn-sm d-flex align-items-center me-1">
                                    <i class="bi bi-pencil me-1"></i>
                                    <span class="d-none d-md-inline">Editar</span>
                                </a>
                                <button class="btn btn-outline-danger btn-sm d-flex align-items-center delete-book" 
                                        data-id="{{ $book->id }}">
                                    <i class="bi bi-trash me-1"></i>
                                    <span class="d-none d-md-inline">Eliminar</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    
                    @if(count($books) === 0)
                    <tr>
                        <td colspan="4" class="text-center py-5">
                            <div class="py-4">
                                <i class="bi bi-book display-5 text-muted mb-3"></i>
                                <h5 class="text-muted">No hay libros registrados</h5>
                                <p class="text-muted mb-0">Comienza agregando tu primer libro</p>
                            </div>
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function(){

    $('#exportBooks').click(function(){
        const token = localStorage.getItem('token');
        if(!token){
            alert('No hay token de autenticación.');
            return;
        }

        // Redirige a la URL de export con autenticación vía token
        window.location.href = '/api/export/books?token=' + token;
    });

    $('.delete-book').click(function(){
        if(!confirm('¿Seguro que deseas eliminar este libro?')) return;

        let id = $(this).data('id');
        $.ajax({
            url: '/api/books/' + id,
            method: 'DELETE',
            headers: { 'Authorization': 'Bearer ' + localStorage.getItem('token') },
            success: function(){
                $('#book-' + id).remove();
                $('#message').html('<div class="alert alert-success">Libro eliminado correctamente.</div>');
            },
            error: function(){
                $('#message').html('<div class="alert alert-danger">Error al eliminar libro.</div>');
            }
        });
    });
});
</script>
@endsection
