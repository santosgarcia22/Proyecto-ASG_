<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- /.card-header -->
                     <div class="container">
                        <h1>Información del vuelo</h1>
                        <h2>Numero de vuelo</h2>
                     </div>
                    <div class="card-body">
                        <table id="tabla" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th style="width: 4%">#</th>
                                <th style="width: 8%">Nombre</th>
                                <th style="width: 8%">Tipo</th>
                                <th style="width: 8%">Posición</th>
                                <th style="width: 8%">Ingreso</th>
                                <th style="width: 8%">Salida</th>
                                <th style="width: 8%">Sincronización</th>
                                <th style="width: 8%">Usuario</th>
                                <th style="width: 8%">ID</th>
                                <th style="width: 8%">Objetos</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($acceso as $key => $item)
                                <tr>
                                    <td>{{$item->numero_id}}</td>
                                    <td>{{$item->nombre}}</td>
                                    <td>{{$item->tipo}}</td>
                                    <td>{{$item->posicion}}</td>
                                    <td>{{$item->ingreso}}</td>
                                    <td>{{$item->salida}}</td>
                                    <td>{{$item->Sincronizacion}}</td>
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->objetos}}</td>
                                

                                   
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
    $(function () {
        $("#tabla").DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "pagingType": "full_numbers",
            "lengthMenu": [[10, 25, 50, 100, 150, -1], [10, 25, 50, 100, 150, "Todo"]],
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
            "responsive": true, "lengthChange": true, "autoWidth": false,
        });
    });


</script>
