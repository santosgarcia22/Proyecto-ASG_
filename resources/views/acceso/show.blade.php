<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
.content {
    padding: 10px;


}
</style>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <!-- Información del vuelo -->
                    <div class="card-header bg-primary text-white">
                        <h1 class="h4">Información del vuelo</h1>
                        @foreach($acceso as $key => $item)
                        <h2 class="h6 mb-0">Número de vuelo: {{ $item->vuelo }}</h2>
                        @break {{-- Solo mostramos uno, ya que puede estar repetido --}}
                        @endforeach
                    </div>

                    <div class="card-body table-responsive">
                        <div class="btn-group" role="group" aria-label="Basic outlined example">
                            <a href="{{ route('admin.accesos.create') }}" class="btn btn-sm btn-primary me-1">
                                <i class="bi bi-pencil-square"></i> Registrar
                            </a>
                        </div>
                        <br>
                        <br>
                        <table id="tabla"
                            class="table table-bordered table-striped table-hover text-center align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Tipo</th>
                                    <th>Posición</th>
                                    <th>Ingreso</th>
                                    <th>Salida</th>
                                    <th>Sincronización</th>
                                    <th>Usuario</th>
                                    <th>Objetos</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($acceso as $item)
                                <tr>
                                    <td>{{ $item->numero_id }}</td>
                                    <td>{{ $item->nombre }}</td>
                                    <td>{{ $item->tipo }}</td>
                                    <td>{{ $item->posicion }}</td>
                                    <td>{{ $item->ingreso }}</td>
                                    <td>{{ $item->salida }}</td>
                                    <td>{{ $item->Sicronizacion }}</td>

                                    <td>{{ $item->id }}</td>
                                    <td>
                                        @if($item->objetos)
                                        <img src="{{ asset('storage/objetos/' . basename($item->objetos)) }}" alt="Imagen" style="max-width: 80px; max-height: 80px; object-fit: cover;">

                                        @else
                                        <span class="text-muted">No hay imagen</span>
                                        @endif
                                    </td>

                                    <td>
                                        <a href="{{ route('admin.accesos.edit', $item->numero_id) }}"
                                            class="btn btn-sm btn-primary me-1">
                                            <i class="bi bi-pencil-square"></i> Editar
                                        </a>

                                        <form action="{{ route('admin.accesos.destroy', $item->numero_id) }}"
                                            method="POST" style="display: inline-block;"
                                            onsubmit="return confirm('¿Estás seguro de eliminar este registro?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i> Eliminar
                                            </button>
                                        </form>

                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center">
                            {{ $acceso->links('pagination::bootstrap-5') }}
                        </div>

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