@extends('layouts.app-auth')

@section('title', 'Editar Libro')

@section('content')
<div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
    <div class="d-flex align-items-center mb-3">
        <div class="bg-success bg-opacity-10 p-2 rounded-3 me-3">
            <i class="bi bi-book text-success fs-4"></i>
        </div>
        <div>
            <h2 class="mb-0 fw-bold h4">Editar Libro</h2>
            <small class="text-muted">Actualizar información del libro</small>
        </div>
    </div>
    
    <a href="{{ route('books.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Volver
    </a>
</div>

<div id="message" class="alert alert-dismissible fade show d-none mb-4"></div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-light py-3">
        <h5 class="mb-0">
            <i class="bi bi-pencil-square me-2 text-success"></i>
            Información del Libro
        </h5>
    </div>
    
    <div class="card-body">
        <form id="bookForm" novalidate>
            <div class="row">
                <div class="col-md-8 mb-3">
                    <label for="title" class="form-label fw-medium">
                        <i class="bi bi-bookmark me-1 text-muted"></i>Título
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light">
                            <i class="bi bi-card-text"></i>
                        </span>
                        <input type="text" class="form-control" id="title" 
                               value="{{ $book->title }}" required
                               placeholder="Ingresa el título del libro">
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label fw-medium">
                        <i class="bi bi-hash me-1 text-muted"></i>ID Libro
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light">
                            <i class="bi bi-tag"></i>
                        </span>
                        <input type="text" class="form-control bg-light" 
                               value="{{ $book->id }}" readonly>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <label for="author_id" class="form-label fw-medium">
                    <i class="bi bi-person-badge me-1 text-muted"></i>Autor
                </label>
                <div class="input-group">
                    <span class="input-group-text bg-light">
                        <i class="bi bi-person"></i>
                    </span>
                    <select id="author_id" class="form-control" required>
                        <option value="">Seleccione un autor</option>
                        @foreach($authors as $author)
                            <option value="{{ $author->id }}" 
                                    {{ $author->id == $book->author_id ? 'selected' : '' }}>
                                {{ $author->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                <small class="text-muted">
                    <i class="bi bi-info-circle me-1"></i>
                    Edita y guarda los cambios del libro
                </small>
                
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-secondary" 
                            onclick="window.history.back()">
                        <i class="bi bi-x-circle me-1"></i>
                        Cancelar
                    </button>
                    
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle me-1"></i>
                        Actualizar
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function(){
    $('#bookForm').submit(function(e){
        e.preventDefault();
        $('#message').html('');

        let title = $('#title').val().trim();
        let author_id = $('#author_id').val();

        if(title === '' || author_id === ''){
            alert("aaa")
            $('#message').html('<div class="alert alert-danger">Todos los campos son obligatorios.</div>').removeClass("d-none");
            return;
        }

        $.ajax({
            url: '/api/books/{{ $book->id }}',
            method: 'PUT',
            contentType: 'application/json',
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('token')
            },
            data: JSON.stringify({
                title: title,
                author_id: author_id
            }),
            success: function(){
                $('#message').html('<div class="alert alert-success">Libro actualizado exitosamente. Redirigiendo...</div>');
                setTimeout(() => window.location.href = '/books', 1500);
            },
            error: function(xhr){
                let msg = 'Error al actualizar libro.';
                if(xhr.responseJSON && xhr.responseJSON.errors){
                    msg = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                }
                $('#message').html('<div class="alert alert-danger">'+msg+'</div>');
            }
        });

    });
});
</script>
@endsection
