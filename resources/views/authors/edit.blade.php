@extends('layouts.app-auth')

@section('title', 'Editar Autor')

@section('content')
<div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
    <div class="d-flex align-items-center mb-3">
        <div class="bg-info bg-opacity-10 p-2 rounded-3 me-3">
            <i class="bi bi-person-badge text-info fs-4"></i>
        </div>
        <div>
            <h2 class="mb-0 fw-bold h4">Editar Autor</h2>
            <small class="text-muted">Actualizar información del autor</small>
        </div>
    </div>
    
    <a href="{{ url('authors') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Volver
    </a>
</div>

<div id="message" class="alert alert-dismissible fade show d-none mb-4"></div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-light py-3">
        <h5 class="mb-0">
            <i class="bi bi-pencil-square me-2 text-info"></i>
            Información del Autor
        </h5>
    </div>
    
    <div class="card-body">
        <form id="authorForm" novalidate>
            <div class="row mb-4">
                <div class="col-md-8 mb-3">
                    <label for="name" class="form-label fw-medium">
                        <i class="bi bi-person me-1 text-muted"></i>Nombre del Autor
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light">
                            <i class="bi bi-card-text"></i>
                        </span>
                        <input type="text" class="form-control" id="name" 
                               value="{{ $author->name }}" required
                               placeholder="Nombre completo del autor">
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label fw-medium">
                        <i class="bi bi-hash me-1 text-muted"></i>ID Autor
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light">
                            <i class="bi bi-tag"></i>
                        </span>
                        <input type="text" class="form-control bg-light" 
                               value="{{ $author->id }}" readonly>
                    </div>
                </div>
            </div>

            <!-- Estadísticas del autor (si están disponibles) -->
            @if(isset($author->books_count) && $author->books_count > 0)
            <div class="alert alert-info bg-info bg-opacity-10 border-info border-opacity-25">
                <div class="d-flex align-items-center">
                    <i class="bi bi-info-circle fs-5 text-info me-3"></i>
                    <div>
                        <h6 class="mb-1 fw-medium">Información del autor</h6>
                        <p class="mb-0 text-muted">
                            Este autor tiene <span class="fw-semibold">{{ $author->books_count }}</span> 
                            libro(s) registrado(s) en el sistema.
                        </p>
                    </div>
                </div>
            </div>
            @endif

            <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                <small class="text-muted">
                    <i class="bi bi-calendar me-1"></i>
                    Registrado: {{ $author->created_at->format('d/m/Y') ?? 'N/A' }}
                </small>
                
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-secondary" 
                            onclick="window.history.back()">
                        <i class="bi bi-x-circle me-1"></i>
                        Cancelar
                    </button>
                    
                    <button type="submit" class="btn btn-info text-white">
                        <i class="bi bi-check-circle me-1"></i>
                        Actualizar Autor
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){
    $('#authorForm').submit(function(e){
        e.preventDefault();
        $('#message').html('');

        let name = $('#name').val().trim();
        if(name === ''){
            $('#message').html('<div class="alert alert-danger">El nombre es obligatorio.</div>').removeClass("d-none");
            return;
        }

        $.ajax({
            url: '/api/authors/{{ $author->id }}',
            method: 'PUT',
            contentType: 'application/json',
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('token')
            },
            data: JSON.stringify({
                name: name
            }),
            success: function(){
                $('#message').html('<div class="alert alert-success">Autor actualizado exitosamente. Redirigiendo...</div>');
                setTimeout(() => window.location.href = '/authors', 1500);
            },
            error: function(xhr){
                let err = 'Error al actualizar autor.';
                if(xhr.responseJSON && xhr.responseJSON.errors){
                    err = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                }
                $('#message').html('<div class="alert alert-danger">'+err+'</div>');
            }
        });

    });
});
</script>
@endsection
