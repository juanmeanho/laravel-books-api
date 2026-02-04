@extends('layouts.app-auth')

@section('title', 'Editar Usuario')

@section('content')
<div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
    <div class="d-flex align-items-center mb-3">
        <div class="bg-primary bg-opacity-10 p-2 rounded-3 me-3">
            <i class="bi bi-person-gear text-primary fs-4"></i>
        </div>
        <div>
            <h2 class="mb-0 fw-bold h4">Editar Usuario</h2>
            <small class="text-muted">Actualizar información del usuario</small>
        </div>
    </div>
    
    <a href="{{ url('users') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Volver a Lista
    </a>
</div>

<div id="userMessage" class="alert alert-dismissible fade show d-none mb-4"></div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-light py-3">
        <h5 class="mb-0">
            <i class="bi bi-person-lines-fill me-2 text-primary"></i>
            Información del Usuario
        </h5>
    </div>
    
    <div class="card-body">
        <form id="editUserForm" novalidate>
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label fw-medium">
                        <i class="bi bi-person me-1 text-muted"></i>Nombre
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light">
                            <i class="bi bi-card-text"></i>
                        </span>
                        <input type="text" id="name" class="form-control" 
                               value="{{ $user->name }}" required
                               placeholder="Nombre completo del usuario">
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-medium">
                        <i class="bi bi-hash me-1 text-muted"></i>ID Usuario
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light">
                            <i class="bi bi-tag"></i>
                        </span>
                        <input type="text" class="form-control bg-light" 
                               value="{{ $user->id }}" readonly>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <label for="email" class="form-label fw-medium">
                    <i class="bi bi-envelope me-1 text-muted"></i>Email
                </label>
                <div class="input-group">
                    <span class="input-group-text bg-light">
                        <i class="bi bi-at"></i>
                    </span>
                    <input type="email" id="email" class="form-control" 
                           value="{{ $user->email }}" required
                           placeholder="ejemplo@correo.com">
                </div>
            </div>

            <div class="mb-4">
                <label for="password" class="form-label fw-medium">
                    <i class="bi bi-key me-1 text-muted"></i>Contraseña
                </label>
                <div class="input-group">
                    <span class="input-group-text bg-light">
                        <i class="bi bi-lock"></i>
                    </span>
                    <input type="password" id="password" class="form-control" 
                           minlength="6" placeholder="Nueva contraseña (opcional)">
                </div>
                <div class="form-text text-muted">
                    <i class="bi bi-info-circle me-1"></i>
                    Dejar vacío si no deseas cambiar la contraseña (mínimo 6 caracteres)
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                <small class="text-muted">
                    <i class="bi bi-calendar me-1"></i>
                    Registrado: {{ $user->created_at->format('d/m/Y') ?? 'N/A' }}
                </small>
                
                <div class="d-flex gap-2">
                    <button type="reset" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-clockwise me-1"></i>
                        Restablecer
                    </button>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-1"></i>
                        Guardar Cambios
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
    $('#editUserForm').submit(function(e){
        e.preventDefault();
        $('#userMessage').html('');

        var name = $('#name').val().trim();
        var email = $('#email').val().trim();
        var password = $('#password').val();
        var errors = [];

        if(name === '') errors.push('Nombre obligatorio');
        if(email === '' || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) errors.push('Email inválido');
        if(password && password.length < 6) errors.push('Contraseña mínima 6');

        if(errors.length){
            $('#userMessage').html(errors.map(err => '<div class="alert alert-danger">'+err+'</div>').join('')).removeClass("d-none");
            return;
        }

        $.ajax({
            url: '/api/users/{{ $user->id }}',
            method: 'PUT',
            contentType: 'application/json',
            headers: { 'Authorization': 'Bearer ' + localStorage.getItem('token') },
            data: JSON.stringify({name,email,password}),
            success: function(){
                $('#userMessage').html('<div class="alert alert-success">Usuario actualizado!</div>');
                setTimeout(()=> window.location.href='/users',1500);
            },
            error: function(xhr){
                let msg = 'Error al actualizar';
                if(xhr.responseJSON && xhr.responseJSON.errors){
                    msg = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                }
                $('#userMessage').html('<div class="alert alert-danger">'+msg+'</div>');
            }
        });
    });
});
</script>
@endsection
