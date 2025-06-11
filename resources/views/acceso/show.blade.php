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

    @media (max-width: 768px) {
        .d-flex.flex-wrap.gap-2.w-100 {
            flex-direction: column !important;
            align-items: stretch !important;
        }
    }


}
</style>
<section class="content">
    <div class="container-fluid mt-3">

        @if($numeroVuelo)
        <div class="alert alert-info mb-2">
            Mostrando accesos para el vuelo <b>{{ $numeroVuelo }}</b>
        </div>
        @endif

        <!-- Encabezado principal -->
        <!-- <div class="d-flex align-items-center mb-3">
            <h2 class="flex-grow-1 mb-0">Accesos</h2>
            <a href="{{ route('admin.accesos.create') }}" class="btn btn-primary">
                <i class="bi bi-pencil-square"></i> Nuevo Acceso
            </a>
        </div> -->

        <!-- Filtro de búsqueda y por vuelo -->
        <!-- <div class="card-header bg-primary text-white d-flex align-items-center">
            <span class="fw-bold">Lista de Accesos</span>
            <form method="GET" action="{{ route('admin.accesos.index') }}"
                class="ms-auto d-flex align-items-center gap-2">
                <input type="text" name="busqueda" class="form-control form-control-sm" placeholder="Buscar..."
                    value="{{ request('busqueda') }}">
                <select name="numero_vuelo" class="form-select form-select-sm w-auto" onchange="this.form.submit()">
                    <option value="">-- Todos los vuelos --</option>
                    @foreach($vuelos as $vuelo)
                    <option value="{{ $vuelo->numero_vuelo }}"
                        {{ request('numero_vuelo') == $vuelo->numero_vuelo ? 'selected' : '' }}>
                        {{ $vuelo->numero_vuelo }}
                    </option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-light btn-sm">Buscar</button>
            </form>
        </div> -->

        <!-- Caja azul de filtro/listado -->
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex align-items-center">
                <span class="fw-bold">Lista de Accesos</span>
                <!-- <form method="GET" action="{{ route('admin.accesos.index') }}"
                    class="ms-auto d-flex align-items-center">
                    <input type="text" name="busqueda" class="form-control form-control-sm me-2" placeholder="Buscar..."
                        value="{{ request('busqueda') }}">
                    <button type="submit" class="btn btn-light btn-sm">Buscar</button>
                </form> -->
            </div>

            <div class="card-body">
                <div class="mb-2 d-flex justify-content-between align-items-center">
                    <!-- Selector de cantidad de registros por página -->
                    <form method="GET" action="{{ route('admin.accesos.index') }}" class="d-flex align-items-center">
                        <label class="me-2 mb-0">Mostrar</label>
                        <select name="per_page" onchange="this.form.submit()" class="form-select form-select-sm w-auto">
                            @foreach([5, 10, 25, 50, 100] as $size)
                            <option value="{{ $size }}" {{ request('per_page', 5) == $size ? 'selected' : '' }}>
                                {{ $size }}</option>
                            @endforeach
                        </select>
                        <label class="ms-2 mb-0">registros</label>
                        @if(request('busqueda'))
                        <input type="hidden" name="busqueda" value="{{ request('busqueda') }}">
                        @endif
                        @if(request('numero_vuelo'))
                        <input type="hidden" name="numero_vuelo" value="{{ request('numero_vuelo') }}">
                        @endif

                    </form>
                </div>

                <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
                    <form method="GET" action="{{ route('admin.accesos.index') }}" class="d-flex flex-wrap gap-2 w-100">
                        <!-- Input de búsqueda -->
                        <input type="text" name="busqueda" class="form-control form-control-sm" placeholder="Buscar..."
                            value="{{ request('busqueda') }}" style="max-width: 210px;">

                        <!-- Select de vuelo -->
                        <select name="numero_vuelo" class="form-select form-select-sm" style="max-width: 170px;"
                            onchange="this.form.submit()">
                            <option value="">-- Todos los vuelos --</option>
                            @foreach($vuelos as $vuelo)
                            <option value="{{ $vuelo->numero_vuelo }}"
                                {{ request('numero_vuelo') == $vuelo->numero_vuelo ? 'selected' : '' }}>
                                {{ $vuelo->numero_vuelo }}
                            </option>
                            @endforeach
                        </select>

                        <!-- Botón Buscar -->
                        <button type="submit" class="btn btn-primary btn-sm px-4">
                            <i class="bi bi-search"></i> Buscar
                        </button>
                    </form>

                    <!-- Nuevo Acceso (opcional, muévelo a la derecha) -->
                    <a href="{{ route('admin.accesos.create') }}" class="btn btn-outline-primary btn-sm ms-auto">
                        <i class="bi bi-pencil-square"></i> Nuevo Acceso
                    </a>
                </div>


                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Tipo</th>
                                <th>Posición</th>
                                <th>Ingreso</th>
                                <th>Salida</th>
                                <th>Usuario</th>
                                <th>Vuelo</th>
                                <th>Objetos</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($acceso as $item)
                            <tr>
                                <td>{{ $item->numero_id }}</td>
                                <td>{{ $item->nombre }}</td>
                                <td>{{ $item->nombre_tipo }}</td>
                                <td>{{ $item->posicion }}</td>
                                <td>{{ $item->ingreso }}</td>
                                <td>{{ $item->salida }}</td>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->numero_vuelo }}</td>
                                <td>
                                    @if($item->objetos)
                                    <img src="{{ asset('storage/objetos/' . basename($item->objetos)) }}" alt="Imagen"
                                        style="max-width: 50px; max-height: 50px; object-fit: cover;">
                                    @else
                                    <span class="text-muted">No hay imagen</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.accesos.edit', $item->numero_id) }}"
                                        class="btn btn-sm btn-info me-1">
                                        <i class="bi bi-pencil-square"></i> Editar
                                    </a>
                                    <form action="{{ route('admin.accesos.destroy', $item->numero_id) }}" method="POST"
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

                <!-- Pie de página: paginación y resumen -->
                <div class="d-flex justify-content-between align-items-center mt-2">
                    <div>
                        Mostrando registros del {{ $acceso->firstItem() }} al {{ $acceso->lastItem() }} de un total de
                        {{ $acceso->total() }} registros
                    </div>
                    <div>
                        {{ $acceso->appends(request()->all())->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@section('archivos-js')
<script src="{{ asset('js/axios.min.js') }}"></script>
<script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('js/toastr.min.js') }}"></script>

<script>
// Supón que tienes un botón con la clase 'btn-eliminar'
$('.btn-eliminar').on('click', function(e) {
    e.preventDefault();
    var form = $(this).closest('form');
    confirmarEliminacion(function() {
        form.submit();
    });
});

@if(session('success')) <
    script >
    mostrarExito("{{ session('success') }}");
</script>

@endif
<script>
// CSRF para Axios
axios.defaults.headers.common['X-CSRF-TOKEN'] =
    document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// Eliminar acceso con confirmación
$(document).on('click', '.btn-eliminar', function() {
    let id = $(this).data('id');
    console.log("CLICK detectado, ID:", id);

    let boton = $(this);

    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción no se puede deshacer",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar'
    }).then((result) => {
        if (result.isConfirmed) {
            axios.delete(`/admin/acceso/${id}`)
                .then(function(response) {
                    console.log("Respuesta:", response.data);
                    if (response.data.res === true) {
                        toastr.success("Registro eliminado");
                        boton.closest('tr').remove();
                    } else {
                        toastr.error("No se pudo eliminar");
                    }
                })
                .catch(function(error) {
                    console.error("ERROR AXIOS:", error);
                    toastr.error("Error en la eliminación");
                });
        }
    });
});
</script>


@endsection