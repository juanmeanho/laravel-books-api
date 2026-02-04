@extends('layouts.app-auth')

@section('title','Dashboard')

@section('content')

<div class="container-fluid py-4">
    <!-- Header mejorado -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-primary mb-1">
                <i class="bi bi-speedometer2 me-2"></i>Panel Principal
            </h2>
        </div>
    </div>

    <!-- Tarjetas de módulos -->
    <div class="row g-4">
        <!-- Usuarios -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 hover-shadow">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0">
                        <i class="bi bi-people-fill me-2"></i>Usuarios
                    </h5>
                </div>
                <div class="card-body d-flex flex-column">
                    <div class="mb-3">
                        <p class="text-muted mb-2">Gestión completa de usuarios del sistema</p>
                        <div class="d-flex align-items-center">
                            <span class="badge bg-primary">
                                <i class="bi bi-person-x me-1"></i>Total:  {{ $totalUsers }}
                            </span>
                        </div>
                    </div>
                    <div class="mt-auto">
                        <a href="/users" class="btn btn-outline-primary w-100 d-flex align-items-center justify-content-center">
                            <i class="bi bi-arrow-right-circle me-2"></i>Gestionar Usuarios
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Autores -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 hover-shadow">
                <div class="card-header bg-info text-white py-3">
                    <h5 class="mb-0">
                        <i class="bi bi-person-badge me-2"></i>Autores
                    </h5>
                </div>
                <div class="card-body d-flex flex-column">
                    <div class="mb-3">
                        <p class="text-muted mb-2">Gestión de autores y sus obras</p>
                        <div class="d-flex align-items-center">
                            <span class="badge bg-info me-2">
                                <i class="bi bi-person-badge me-1"></i>Total:  {{ $totalAuthors }}
                            </span>
                        </div>
                    </div>
                    <div class="mt-auto">
                        <a href="/authors" class="btn btn-outline-info w-100 d-flex align-items-center justify-content-center">
                            <i class="bi bi-arrow-right-circle me-2"></i>Ver Autores
                        </a>
                    </div>
                </div>
            </div>
        </div>

                <!-- Libros -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 hover-shadow">
                <div class="card-header bg-success text-white py-3">
                    <h5 class="mb-0">
                        <i class="bi bi-book-half me-2"></i>Libros
                    </h5>
                </div>
                <div class="card-body d-flex flex-column">
                    <div class="mb-3">
                        <p class="text-muted mb-2">Catálogo y gestión de libros disponibles</p>
                        <div class="d-flex align-items-center">
                            <span class="badge bg-success me-2">
                                <i class="bi bi-book-half me-1"></i>Total:  {{ $totalBooks }}
                            </span>
                        </div>
                    </div>
                    <div class="mt-auto">
                        <a href="/books" class="btn btn-outline-success w-100 d-flex align-items-center justify-content-center">
                            <i class="bi bi-arrow-right-circle me-2"></i>Explorar Libros
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

<style>
    .hover-shadow {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .hover-shadow:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .card-header {
        border-radius: 0.375rem 0.375rem 0 0 !important;
    }
</style>

@endsection
