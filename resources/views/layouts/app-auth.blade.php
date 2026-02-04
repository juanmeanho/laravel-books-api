<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Laravel Books API')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">
    <div class="container-fluid">
        <!-- Logo/Brand con icono -->
        <a class="navbar-brand d-flex align-items-center fw-bold" href="/dashboard">
            <i class="bi bi-book me-2"></i>
            Books API
        </a>

        <!-- Botón toggle para móviles -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" 
                aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Contenido del navbar -->
        <div class="collapse navbar-collapse" id="navbarContent">
            <!-- Menú de navegación -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center text-white" href="/dashboard">
                        <i class="bi bi-speedometer2 me-1 d-none d-sm-inline"></i>
                        Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center text-white" href="/users">
                        <i class="bi bi-people me-1 d-none d-sm-inline"></i>
                        Usuarios
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center text-white" href="/authors">
                        <i class="bi bi-person-badge me-1 d-none d-sm-inline"></i>
                        Autores
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center text-white" href="/books">
                        <i class="bi bi-book me-1 d-none d-sm-inline"></i>
                        Libros
                    </a>
                </li>
            </ul>

            <div class="d-flex align-items-center">
                <button id="logoutBtn" class="btn btn-outline-light">
                    <i class="bi bi-box-arrow-right me-1"></i>
                    Salir
                </button>
            </div>
        </div>
    </div>
</nav>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

<div class="container mt-4">
    @yield('content')
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
(function(){

    const token = localStorage.getItem('token');

    if(!token){
        window.location.href = '/login';
        return;
    }

    $.ajax({
        url: '/api/me',
        method: 'GET',
        headers: {
            'Authorization': 'Bearer ' + token
        },
        error: function () {
            localStorage.removeItem('token');
            window.location.href = '/login';
        }
    });

    $('#logoutBtn').on('click', function(){

        $.ajax({
            url:'/api/logout',
            method:'POST',
            headers:{
                'Authorization':'Bearer ' + token
            },
            complete:function(){
                localStorage.removeItem('token');
                window.location.href='/login';
            }
        });

    });

})();
</script>

</body>
</html>
