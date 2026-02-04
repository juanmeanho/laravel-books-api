@extends('layouts.app-auth')

@section('title', 'Autores')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
    <div class="d-flex align-items-center mb-3">
        <div class="bg-info bg-opacity-10 p-2 rounded-3 me-3">
            <i class="bi bi-person-badge text-info fs-3"></i>
        </div>
        <div>
            <h2 class="mb-0 fw-bold h4">Autores</h2>
            <small class="text-muted">Gestión de autores</small>
        </div>
    </div>
    
    <div class="d-flex flex-wrap gap-2">
        <button id="exportAuthors" class="btn btn-outline-info d-flex align-items-center">
            <i class="bi bi-download me-1"></i>
            <span class="d-none d-sm-inline">Exportar</span>
        </button>
        
        <a href="{{ url('authors/create') }}" class="btn btn-info d-flex align-items-center text-white">
            <i class="bi bi-plus-lg me-1"></i>
            <span class="d-none d-sm-inline">Nuevo</span>
        </a>
    </div>
</div>

<div id="message"></div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-info text-white py-3">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="bi bi-person-badge me-2"></i>Lista de Autores
            </h5>
            <div>
                <span class="badge bg-light text-info">Total: {{ count($authors) }}</span>
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
                            <i class="bi bi-person me-1 text-muted"></i>Nombre
                        </th>
                        <th>
                            <i class="bi bi-book me-1 text-muted"></i>Libros
                        </th>
                        <th class="text-end pe-4">
                            <i class="bi bi-gear me-1 text-muted"></i>Acciones
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($authors as $author)
                    <tr id="author-{{ $author->id }}">
                        <td class="ps-4">
                            <span class="badge bg-info bg-opacity-10 text-info">{{ $author->id }}</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div>
                                    <div class="fw-medium">{{ $author->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div>
                                    <div class="fw-medium">{{ $author->books_count }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="text-end pe-4">
                            <div class="btn-group" role="group">
                                <a href="{{ route('authors.edit', $author->id) }}" 
                                   class="btn btn-outline-primary btn-sm d-flex align-items-center me-1">
                                    <i class="bi bi-pencil me-1"></i>
                                    <span class="d-none d-md-inline">Editar</span>
                                </a>
                                <button class="btn btn-outline-danger btn-sm d-flex align-items-center delete-author" 
                                        data-id="{{ $author->id }}">
                                    <i class="bi bi-trash me-1"></i>
                                    <span class="d-none d-md-inline">Eliminar</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    
                    @if(count($authors) === 0)
                    <tr>
                        <td colspan="4" class="text-center py-5">
                            <div class="py-4">
                                <i class="bi bi-person-badge display-5 text-muted mb-3"></i>
                                <h5 class="text-muted">No hay autores registrados</h5>
                                <p class="text-muted mb-0">Comienza agregando tu primer autor</p>
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

    // Eliminar autor
    $('.delete-author').click(function(){
        if(!confirm('¿Seguro que deseas eliminar este autor?')) return;

        let id = $(this).data('id');
        $.ajax({
            url: '/api/authors/' + id,
            method: 'DELETE',
            headers: { 'Authorization': 'Bearer ' + localStorage.getItem('token') },
            success: function(){
                $('#author-' + id).remove();
                $('#message').html('<div class="alert alert-success">Autor eliminado correctamente.</div>');
            },
            error: function(){
                $('#message').html('<div class="alert alert-danger">Error al eliminar autor.</div>');
            }
        });
    });

    // Exportar autores
    $('#exportAuthors').click(function(){
        const token = localStorage.getItem('token');
        if(!token){
            alert('No hay token de autenticación.');
            return;
        }
        window.location.href = '/api/export/authors?token=' + token;
    });

});
</script>
@endsection
