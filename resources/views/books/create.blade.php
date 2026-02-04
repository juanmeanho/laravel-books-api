@extends('layouts.app-auth')

@section('title', 'Nuevo Libro')

@section('content')
<div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
    <div class="d-flex align-items-center mb-3">
        <div class="bg-success bg-opacity-10 p-2 rounded-3 me-3">
            <i class="bi bi-plus-square text-success fs-4"></i>
        </div>
        <div>
            <h2 class="mb-0 fw-bold h4">Nuevo Libro</h2>
            <small class="text-muted">Agregar nuevo libro al catálogo</small>
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
            <i class="bi bi-book-plus me-2 text-success"></i>
            Información del Nuevo Libro
        </h5>
    </div>
    
    <div class="card-body">
        <form id="bookForm" novalidate>
            <div class="row mb-4">
                <div class="col-md-8 mb-3">
                    <label for="title" class="form-label fw-medium">
                        <i class="bi bi-bookmark me-1 text-muted"></i>Título del Libro
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light">
                            <i class="bi bi-card-text"></i>
                        </span>
                        <input type="text" class="form-control" id="title" 
                               required placeholder="Ingresa el título completo del libro">
                    </div>
                    <div class="form-text text-muted">
                        <i class="bi bi-info-circle me-1"></i>
                        Título completo del libro (campo obligatorio)
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label fw-medium">
                        <i class="bi bi-calendar me-1 text-muted"></i>Fecha de Registro
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light">
                            <i class="bi bi-calendar-check"></i>
                        </span>
                        <input type="text" class="form-control bg-light" 
                               value="{{ now()->format('d/m/Y') }}" readonly>
                    </div>
                    <div class="form-text text-muted">Fecha automática del sistema</div>
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
                            <option value="{{ $author->id }}">
                                {{ $author->name }}
                                @if(isset($author->books_count))
                                    ({{ $author->books_count }} libro(s))
                                @endif
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-text text-muted">
                    <i class="bi bi-people me-1"></i>
                    Selecciona el autor de este libro. Si no existe, créalo primero en la sección de autores.
                </div>
            </div>

            <div class="alert alert-success bg-success bg-opacity-10 border-success border-opacity-25">
                <div class="d-flex align-items-center">
                    <i class="bi bi-lightbulb fs-5 text-success me-3"></i>
                    <div>
                        <h6 class="mb-1 fw-medium">Recomendación</h6>
                        <p class="mb-0 text-muted">
                            Completa todos los campos para tener un registro más completo del libro en el sistema.
                        </p>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                <small class="text-muted">
                    <i class="bi bi-clock-history me-1"></i>
                    Los libros se registran con la fecha y hora actual
                </small>
                
                <div class="d-flex gap-2">
                    <button type="reset" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-clockwise me-1"></i>
                        Limpiar
                    </button>
                    
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-plus-circle me-1"></i>
                        Guardar Libro
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
            $('#message').html('<div class="alert alert-danger">Todos los campos son obligatorios.</div>').removeClass("d-none");
            return;
        }

        $.ajax({
            url: '/api/books',
            method: 'POST',
            headers: { 'Authorization': 'Bearer ' + localStorage.getItem('token') },
            data: { title: title, author_id: author_id },
            success: function(){
                $('#message').html('<div class="alert alert-success">Libro creado exitosamente. Redirigiendo...</div>');
                setTimeout(() => window.location.href = '/books', 1500);
            },
            error: function(xhr){
                let err = xhr.responseJSON?.errors?.title ?? 'Error al crear libro.';
                $('#message').html('<div class="alert alert-danger">'+err+'</div>');
            }
        });
    });
});
</script>
@endsection
