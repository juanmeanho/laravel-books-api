@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="row justify-content-center align-items-center min-vh-100">
    <div class="col-md-5 col-lg-5">
        <div class="card border-0 shadow-lg rounded-4">
            <div class="card-body p-4 p-md-5">
                <div class="text-center mb-4">
                    <h2 class="fw-bold text-primary">Iniciar Sesión</h2>
                </div>

                <div id="loginMessage"></div>

                <div id="loginMessage" class="alert d-none" role="alert"></div>

                <form id="loginForm" novalidate>
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
                                   placeholder="Tu contraseña" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold rounded-3">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Ingresar
                    </button>
                </form>

                <div class="d-flex align-items-center my-1">
                    <hr class="flex-grow-1">
                    <span class="px-3 text-muted small">o</span>
                    <hr class="flex-grow-1">
                </div>

                <div class="text-center">
                    <p class="text-muted mb-3">¿No tienes una cuenta?</p>
                    <a href="{{ url('register') }}" class="btn btn-outline-primary w-100 py-2 rounded-3">
                        <i class="bi bi-person-plus me-2"></i>Crear cuenta nueva
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

    $('#loginForm').on('submit', function(e){
        e.preventDefault();

        $('#loginMessage').html('');

        var email = $('#email').val().trim();
        var password = $('#password').val();

        var errors = [];

        if(email === '') errors.push('El correo es obligatorio.');
        else if(!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) errors.push('Ingresa un correo válido.');

        if(password === '') errors.push('La contraseña es obligatoria.');

        if(errors.length > 0){
            $('#loginMessage').html(errors.map(function(err){
                return '<div class="alert alert-danger">'+err+'</div>';
            }).join(''));
            return;
        }

        $.ajax({
            url: '/api/login',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({email: email, password: password}),
            success: function(data){
                $('#loginMessage').html('<div class="alert alert-success">Login exitoso! Redirigiendo...</div>');
                localStorage.setItem('token', data.token);

                setTimeout(function(){
                    window.location.href = '/'; 
                }, 1500);
            },
            error: function(xhr){
                var backendError = '';
                if(xhr.responseJSON && xhr.responseJSON.error){
                    backendError = xhr.responseJSON.error;
                } else {
                    backendError = 'Ocurrió un error en el login';
                }
                $('#loginMessage').html('<div class="alert alert-danger">'+backendError+'</div>');
            }
        });

    });

});
</script>
@endsection
