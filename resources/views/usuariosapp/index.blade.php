@extends('backend.menus.superior')

@section('content-admin-css')
<link href="{{ asset('css/adminlte.min.css') }}" rel="stylesheet" />
@stop

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Usuarios App</h4>
        </div>
        <div class="card-body">
            <a href="#" class="btn btn-primary mb-3">
                <i class="bi bi-person-plus"></i> Nuevo Usuario App
            </a>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Nombre completo</th>
                            <th>Activo</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($usuarios as $usuario)
                        <tr>
                            <td>{{ $usuario->id_usuario }}</td>
                            <td>{{ $usuario->usuario }}</td>
                            <td>{{ $usuario->email }}</td>
                            <td>{{ $usuario->nombre_completo }}</td>
                            <td>
                                @if ($usuario->activo)
                                    <span class="badge bg-success">Activo</span>
                                @else
                                    <span class="badge bg-secondary">Inactivo</span>
                                @endif
                            </td>
                            <td>
                                <a href="#" class="btn btn-sm btn-info">
                                    <i class="bi bi-pencil-square"></i> Editar
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $usuarios->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
