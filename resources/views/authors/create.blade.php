@extends('layouts.app-auth')

@section('title', 'Nuevo Autor')

@section('content')
<div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
    <div class="d-flex align-items-center mb-3">
        <div class="bg-info bg-opacity-10 p-2 rounded-3 me-3">
            <i class="bi bi-person-plus text-info fs-4"></i>
        </div>
        <div>
            <h2 class="mb-0 fw-bold h4">Nuevo Autor</h2>
            <small class="text-muted">Registrar nuevo autor en el sistema</small>
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
            <i class="bi bi-person-badge me-2 text-info"></i>
            Información del Nuevo Autor
        </h5>
    </div>
    
    <div class="card-body">
        <form id="authorForm" novalidate>
            <div class="mb-4">
                <label for="name" class="form-label fw-medium">
                    <i class="bi bi-person me-1 text-muted"></i>Nombre del Autor
                </label>
                <div class="input-group">
                    <span class="input-group-text bg-light">
                        <i class="bi bi-card-text"></i>
                    </span>
                    <input type="text" class="form-control" id="name" 
                           required placeholder="Nombre completo del autor">
                </div>
                <div class="form-text text-muted">
                    <i class="bi bi-info-circle me-1"></i>
                    Ingresa el nombre completo del autor que deseas registrar
                </div>
            </div>

            <div class="alert alert-info bg-info bg-opacity-10 border-info border-opacity-25">
                <div class="d-flex align-items-center">
                    <i class="bi bi-lightbulb fs-5 text-info me-3"></i>
                    <div>
                        <h6 class="mb-1 fw-medium">Sugerencia</h6>
                        <p class="mb-0 text-muted">
                            Después de crear el autor, podrás asignarle libros desde la sección de gestión de libros.
                        </p>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                <small class="text-muted">
                    <i class="bi bi-clock-history me-1"></i>
                    Los autores se registran con la fecha actual
                </small>
                
                <div class="d-flex gap-2">
                    <button type="reset" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-clockwise me-1"></i>
                        Limpiar
                    </button>
                    
                    <button type="submit" class="btn btn-info text-white">
                        <i class="bi bi-plus-circle me-1"></i>
                        Guardar Autor
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
    $('#authorForm').submit(function(e){
        e.preventDefault();
        $('#message').html('');

        let name = $('#name').val().trim();
        if(name === ''){
            $('#message').html('<div class="alert alert-danger">El nombre es obligatorio.</div>').removeClass("d-none");
            return;
        }

        $.ajax({
            url: '/api/authors',
            method: 'POST',
            headers: { 'Authorization': 'Bearer ' + localStorage.getItem('token') },
            data: { name: name },
            success: function(){
                $('#message').html('<div class="alert alert-success">Autor creado exitosamente. Redirigiendo...</div>');
                setTimeout(() => window.location.href = '/authors', 1500);
            },
            error: function(xhr){
                let err = xhr.responseJSON?.errors?.name ?? 'Error al crear autor.';
                $('#message').html('<div class="alert alert-danger">'+err+'</div>');
            }
        });
    });
});
</script>
@endsection
