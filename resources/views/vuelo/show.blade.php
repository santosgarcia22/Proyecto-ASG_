<style>

    .container{
        
    }
</style>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- /.card-header -->
                       <h1>Información del vuelo</h1>
                    <div class="container">
                      
                    </div>

                    <div class="container">
                        <div class="btn-group" role="group" aria-label="Basic outlined example">
                            <a href="{{ route('admin.vuelo.create') }}" class="btn btn-sm btn-primary me-1">
                                <i class="bi bi-pencil-square"></i> Registrar
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="tabla" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 8%">#</th>
                                    <th style="width: 8%">Numero de vuelo</th>
                                    <th style="width: 8%">fecha</th>
                                    <th style="width: 8%">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($vuelo as $key => $item)
                                <tr>
                                    <td>{{$item->id_vuelo}}</td>
                                    <td>{{$item->numero_vuelo}}</td>
                                    <td>{{$item->fecha}}</td>

                                    <td>
                                        <a href="{{ route('admin.vuelo.edit', $item->id_vuelo )}}" class="btn btn-sm btn-primary me-1">
                                            <i class="bi bi-pencil-square"></i> <span class="btn-text">Editar</span>
                                        </a>
                                        <form action="{{route('admin.vuelo.destroy', $item->id_vuelo) }}" method="POST" style="display: inline-block;"
                                            onsubmit="return confirm('¿Estás seguro de eliminar este registro?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i> <span class="btn-text">Eliminar</span>
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


<script>
$(function() {
    $("#tabla").DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "pagingType": "full_numbers",
        "lengthMenu": [
            [10, 25, 50, 100, 150, -1],
            [10, 25, 50, 100, 150, "Todo"]
        ],
        "language": {

            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }

        },
        "responsive": true,
        "lengthChange": true,
        "autoWidth": false,
    });
});
</script>