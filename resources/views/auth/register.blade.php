@extends('layouts.app')

@section('title', 'Registro de Usuario')

@section('content')
<div class="row justify-content-center align-items-center min-vh-100">
    <div class="col-md-5 col-lg-5">
        <div class="card border-0 shadow-lg rounded-4">
            <div class="card-body p-4 p-md-5">
                <div class="text-center mb-4">
                    <h2 class="fw-bold text-primary">Crear Cuenta</h2>
                </div>

                <div id="registerMessage"></div>

                <div id="registerMessage" class="alert d-none" role="alert"></div>

                <form id="registerForm" novalidate>
                    <div class="mb-3">
                        <label for="name" class="form-label fw-medium">
                            <i class="bi bi-person me-2"></i>Nombre completo
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="bi bi-person-badge text-muted"></i>
                            </span>
                            <input type="text" class="form-control border-start-0" id="name" 
                                   placeholder="Tu nombre completo" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label fw-medium">
                            <i class="bi bi-envelope me-2"></i>Correo electrónico
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="bi bi-at text-muted"></i>
                            </span>
                            <input type="email" class="form-control border-start-0" id="email" 
                                   placeholder="ejemplo@correo.com" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label fw-medium">
                            <i class="bi bi-lock me-2"></i>Contraseña
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="bi bi-key text-muted"></i>
                            </span>
                            <input type="password" class="form-control border-start-0 pe-5" id="password" 
                                   placeholder="Mínimo 6 caracteres" required minlength="6">
                            </button>
                        </div>
                        <div class="form-text">La contraseña debe tener al menos 6 caracteres</div>
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label fw-medium">
                            <i class="bi bi-lock-fill me-2"></i>Confirmar contraseña
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="bi bi-key-fill text-muted"></i>
                            </span>
                            <input type="password" class="form-control border-start-0 pe-5" id="password_confirmation" 
                                   placeholder="Repite tu contraseña" required>
                            </button>
                        </div>
                        <div id="passwordMatch" class="form-text"></div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold rounded-3 mb-1">
                        <i class="bi bi-person-plus me-2"></i>Crear cuenta
                    </button>
                </form>

                <div class="d-flex align-items-center my-3">
                    <hr class="flex-grow-1">
                    <span class="px-3 text-muted small">¿Ya tienes cuenta?</span>
                    <hr class="flex-grow-1">
                </div>

                <div class="text-center">
                    <a href="{{ url('login') }}" class="btn btn-outline-primary w-100 py-2 rounded-3">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Iniciar sesión
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function(){

    $('.navbar').hide();

    $('#registerForm').on('submit', function(e){
        e.preventDefault();

        $('#registerMessage').html(''); 

        var name = $('#name').val().trim();
        var email = $('#email').val().trim();
        var password = $('#password').val();
        var password_confirmation = $('#password_confirmation').val();

        var errors = [];

        if(name === '') errors.push('El nombre es obligatorio.');
        if(email === '' || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) errors.push('Ingresa un correo válido.');
        if(password.length < 6) errors.push('La contraseña debe tener al menos 6 caracteres.');
        if(password !== password_confirmation) errors.push('Las contraseñas no coinciden.');

        if(errors.length > 0){
            $('#registerMessage').html(errors.map(function(err){
                return '<div class="alert alert-danger">'+err+'</div>';
            }).join(''));
            return;
        }

        $.ajax({
            url: '/api/register',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                name: name,
                email: email,
                password: password,
                password_confirmation: password_confirmation
            }),
            success: function(data){
                $('#registerMessage').html('<div class="alert alert-success">Usuario registrado con éxito!</div>');
                localStorage.setItem('token', data.token);
                setTimeout(function(){
                    window.location.href = '/login';
                }, 2500);
            },
            error: function(xhr){
                var backendErrors = '';
                if(xhr.responseJSON.errors){
                    $.each(xhr.responseJSON.errors, function(key, msgs){
                        backendErrors += msgs.join('<br>') + '<br>';
                    });
                } else if(xhr.responseJSON.error){
                    backendErrors = xhr.responseJSON.error;
                }
                $('#registerMessage').html('<div class="alert alert-danger">'+backendErrors+'</div>');
            }
        });

    });

});
</script>
@endsection
