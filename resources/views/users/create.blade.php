@extends('layouts.app-auth')

@section('title', 'Crear Usuario')

@section('content')
<div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
    <div class="d-flex align-items-center mb-3">
        <div class="bg-primary bg-opacity-10 p-2 rounded-3 me-3">
            <i class="bi bi-person-plus text-primary fs-4"></i>
        </div>
        <div>
            <h2 class="mb-0 fw-bold h4">Nuevo Usuario</h2>
            <small class="text-muted">Registrar nuevo usuario en el sistema</small>
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
            <i class="bi bi-person-plus me-2 text-primary"></i>
            Información del Nuevo Usuario
        </h5>
    </div>
    
    <div class="card-body">
        <form id="createUserForm" novalidate>
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label fw-medium">
                        <i class="bi bi-person me-1 text-muted"></i>Nombre Completo
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light">
                            <i class="bi bi-card-text"></i>
                        </span>
                        <input type="text" id="name" class="form-control" 
                               required placeholder="Nombre completo del usuario">
                    </div>
                    <div class="form-text text-muted">
                        <i class="bi bi-info-circle me-1"></i>
                        Ingresa el nombre completo del usuario
                    </div>
                </div>

                <div class="col-md-6 mb-3">
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
                <label for="email" class="form-label fw-medium">
                    <i class="bi bi-envelope me-1 text-muted"></i>Correo Electrónico
                </label>
                <div class="input-group">
                    <span class="input-group-text bg-light">
                        <i class="bi bi-at"></i>
                    </span>
                    <input type="email" id="email" class="form-control" 
                           required placeholder="ejemplo@correo.com">
                </div>
                <div class="form-text text-muted">
                    <i class="bi bi-shield-check me-1"></i>
                    El email será utilizado para el inicio de sesión
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
                           required minlength="6" placeholder="Mínimo 6 caracteres">
                </div>
                <div class="form-text text-muted">
                    <i class="bi bi-exclamation-triangle me-1"></i>
                    La contraseña debe tener al menos 6 caracteres
                </div>
            </div>

            <div class="alert alert-primary bg-primary bg-opacity-10 border-primary border-opacity-25">
                <div class="d-flex align-items-center">
                    <i class="bi bi-lightbulb fs-5 text-primary me-3"></i>
                    <div>
                        <h6 class="mb-1 fw-medium">Recomendación</h6>
                        <p class="mb-0 text-muted">
                            Una vez creado el usuario, podrá iniciar sesión con el email y contraseña proporcionados.
                        </p>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                <small class="text-muted">
                    <i class="bi bi-clock-history me-1"></i>
                    Los usuarios se registran con la fecha y hora actual
                </small>
                
                <div class="d-flex gap-2">
                    <button type="reset" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-clockwise me-1"></i>
                        Limpiar
                    </button>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-1"></i>
                        Crear Usuario
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
    $('#createUserForm').submit(function(e){
        e.preventDefault();

        $('#userMessage').html('');
        var name = $('#name').val().trim();
        var email = $('#email').val().trim();
        var password = $('#password').val();

        var errors = [];
        if(name === '') errors.push('Nombre obligatorio');
        if(email === '' || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) errors.push('Email inválido');
        if(password.length < 6) errors.push('Contraseña mínima 6');

        if(errors.length){
            $('#userMessage').html(errors.map(err => '<div class="alert alert-danger">'+err+'</div>').join('')).removeClass("d-none");
            return;
        }

        $.ajax({
            url: '/api/users',
            method: 'POST',
            contentType: 'application/json',
            headers: { 'Authorization': 'Bearer ' + localStorage.getItem('token') },
            data: JSON.stringify({name,email,password}),
            success: function(){
                $('#userMessage').html('<div class="alert alert-success">Usuario creado!</div>');
                setTimeout(()=> window.location.href='/users',1500);
            },
            error: function(xhr){
                let msg = 'Error al crear';
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
