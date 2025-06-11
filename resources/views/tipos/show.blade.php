<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
.content {
    padding: 10px;
}

@media (max-width: 576px) {

    th,
    td {
        font-size: 12px;
        padding: 0.4rem;
    }

    /* Oculta columnas menos importantes en móvil */
    .col-sincronizacion,
    .col-usuario,
    .col-objetos {
        display: none;
    }

    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    @media (max-width: 576px) {
        td img {
            max-width: 40px !important;
            max-height: 40px !important;
        }
    }

    @media (max-width: 576px) {
        .btn-text {
            display: none;
        }
    }


}
</style>
<section class="content">
    <div class="container-fluid mt-3">

        <!-- Encabezado principal -->
        <div class="d-flex align-items-center mb-3">
            <h2 class="flex-grow-1 mb-0">Tipo</h2>
            <a href="{{ route('admin.tipo.create') }}" class="btn btn-primary">
                <i class="bi bi-pencil-square"></i> Nuevo Tipo
            </a>
        </div>

        <!-- Caja azul de filtro/listado -->
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex align-items-center">
                <span class="fw-bold">Lista de tipos </span>
                <form method="GET" action="{{ route('admin.tipo.index') }}"
                    class="ms-auto d-flex align-items-center">
                    <input type="text" name="busqueda" class="form-control form-control-sm me-2" placeholder="Buscar..."
                        value="{{ request('busqueda') }}">
                    <button type="submit" class="btn btn-light btn-sm">Buscar</button>
                </form>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tipo as $item)
                            <tr>
                                <td>{{ $item->id_tipo }}</td>
                                <td>{{ $item->nombre_tipo }}</td>
                                <td>
                                   <a  href="" 
                                        class="btn btn-sm btn-info me-1">
                                        <i class="bi bi-pencil-square"></i> Editar
                                    </a>
                                    <form action="" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i> Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center">No se encontraron registros</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pie de página: paginación y resumen 
                <div class="d-flex justify-content-between align-items-center mt-2">
                    <div>
                      
                    </div>
                    <div>
                       
                    </div>
                </div>-->
            </div>
        </div>
    </div>
</section>

@section('archivos-js')
<script src="{{ asset('js/axios.min.js') }}"></script>
<script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('js/toastr.min.js') }}"></script>

< @endsection