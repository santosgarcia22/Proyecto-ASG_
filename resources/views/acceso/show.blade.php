<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <!-- Información del vuelo -->
                    <div class="card-header bg-success text-white">
                        <h1 class="h4">Información del vuelo</h1>
                        @foreach($acceso as $key => $item)
                            <h2 class="h6 mb-0">Número de vuelo: {{ $item->numero_vuelo }}</h2>
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
                        <table id="tabla" class="table table-bordered table-striped table-hover text-center align-middle">
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
                                        <td>{{ $item->objetos }}</td>
                                        <td>
                                            <a href="/" class="btn btn-sm btn-primary me-1">
                                                <i class="bi bi-pencil-square"></i> Editar
                                            </a>
                                            <form action="/" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este registro?')">
                                                    <i class="bi bi-trash"></i> Eliminar
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
