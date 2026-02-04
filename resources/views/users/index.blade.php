@extends('layouts.app-auth')

@section('title', 'Usuarios')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
    <div class="d-flex align-items-center mb-3 mb-md-0">
        <div class="bg-info bg-opacity-10 p-2 rounded-3 me-3">
            <i class="bi bi-people-fill text-primary fs-3"></i>
        </div>
        <div>
            <h2 class="mb-0 fw-bold h4">Usuarios</h2>
            <small class="text-muted">Administración del sistema</small>
        </div>
    </div>

    <a href="{{ url('users/create') }}" class="btn btn-primary d-flex align-items-center">
        <i class="bi bi-plus-lg me-1"></i>
        <span class="d-none d-sm-inline">Nuevo</span>
    </a>
    
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-primary text-white py-3">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="bi bi-people-fill me-2"></i>Lista de Usuarios
            </h5>
            <div>
                <span class="badge bg-light text-primary">Total: {{ count($users) }}</span>
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
                            <i class="bi bi-envelope me-1 text-muted"></i>Email
                        </th>
                        <th class="text-end pe-4">
                            <i class="bi bi-gear me-1 text-muted"></i>Acciones
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td class="ps-4">
                            <span class="badge bg-primary bg-opacity-10 text-primary">{{ $user->id }}</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div>
                                    <div class="fw-medium">{{ $user->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <span>{{ $user->email }}</span>
                            </div>
                        </td>
                        <td class="text-end pe-4">
                            <div class="btn-group" role="group">
                                <a href="{{ url('users/'.$user->id.'/edit') }}" 
                                   class="btn btn-outline-primary btn-sm d-flex align-items-center me-1">
                                    <i class="bi bi-pencil me-1"></i>
                                    <span class="d-none d-md-inline">Editar</span>
                                </a>
                                <button class="btn btn-outline-danger btn-sm d-flex align-items-center delete-user" 
                                        data-id="{{ $user->id }}">
                                    <i class="bi bi-trash me-1"></i>
                                    <span class="d-none d-md-inline">Eliminar</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    
                    @if(count($users) === 0)
                    <tr>
                        <td colspan="4" class="text-center py-5">
                            <div class="py-4">
                                <i class="bi bi-people display-5 text-muted mb-3"></i>
                                <h5 class="text-muted">No hay usuarios registrados</h5>
                                <p class="text-muted mb-0">Comienza agregando tu primer usuario</p>
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
    $('.delete-user').click(function(){
        if(!confirm('¿Eliminar usuario?')) return;
        var id = $(this).data('id');

        $.ajax({
            url: '/api/users/' + id,
            method: 'DELETE',
            headers: { 'Authorization': 'Bearer ' + localStorage.getItem('token') },
            success: function(){
                alert('Usuario eliminado');
                location.reload();
            },
            error: function(){
                alert('Error al eliminar');
            }
        });
    });
});
</script>
@endsection
