@extends('backend.menus.superior')

@section('content-admin-css')
    <link href="{{ asset('css/adminlte.min.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/dataTables.bootstrap4.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/toastr.min.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/buttons_estilo.css') }}" rel="stylesheet">
@stop

<style>
.card-home {
    border-left: 3px solid #399bff;
    box-shadow: 0 2px 12px #399bff22;
}
.card-icon-home {
    font-size: 2.5rem;
    color: #399bff;
    margin-right: 5px;
}
</style>

<section class="content-header">
    <div class="container-fluid">
        <h1 class="mb-1">Bienvenido a AirSecurity</h1>
        <h5 class="text-muted">Sistema integral de control de accesos y seguridad aeroportuaria</h5>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <!-- Tarjetas estadísticas -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card card-home">
                    <div class="card-body d-flex align-items-center">
                        <i class="fas fa-user-shield card-icon-home"></i>
                        <div>
                            <h6 class="mb-0">Personal autorizado</h6>
                            <span class="h2">{{ $totalUsuarios ?? '1' }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-home">
                    <div class="card-body d-flex align-items-center">
                        <i class="fas fa-door-open card-icon-home"></i>
                        <div>
                            <h6 class="mb-0">Accesos hoy</h6>
                            <span class="h2">{{ $accesosHoy ?? '3' }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-home">
                    <div class="card-body d-flex align-items-center">
                        <i class="fas fa-plane card-icon-home"></i>
                        <div>
                            <h6 class="mb-0">Vuelos registrados</h6>
                            <span class="h2">{{ $totalVuelos ?? '1' }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-home">
                    <div class="card-body d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle card-icon-home"></i>
                        <div>
                            <h6 class="mb-0">Alertas activas</h6>
                            <span class="h2">{{ $alertas ?? '0' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Gráfico de accesos por día --> 
        <div class="row mb-4">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title mb-0">Histórico de accesos (últimos 7 días)</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="graficoAccesos" style="height:240px"></canvas>
                    </div>
                </div>
            </div>  
            <!-- Frase motivacional y accesos rápidos -->
            <div class="col-md-4 d-flex flex-column justify-content-between">
                <div class="alert alert-info">
                    <b>“La seguridad es un trabajo en equipo. Gracias por ser parte del compromiso AirSecurity.”</b>
                </div>
                <div>
                    <a href="{{ route('admin.accesos.index') }}" class="btn btn-primary mb-2 w-100">
                        <i class="fas fa-id-badge"></i> Ver todos los accesos
                    </a>
                    <a href="{{ route('admin.vuelo.index') }}" class="btn btn-outline-primary w-100">
                        <i class="fas fa-plane"></i> Gestión de vuelos
                    </a>
                </div>
            </div>
        </div>
        <!-- Últimos accesos -->
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title mb-0">Últimos accesos registrados</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Tipo</th>
                            <th>Ingreso</th>
                            <th>Salida</th>
                            <th>Vuelo</th>
                            <th>Posición</th>
                            <th>Sincronización</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($accesosRecientes ?? [] as $item)
                        <tr>
                            <td>{{ $item->numero_id }}</td>
                            <td>{{ $item->nombre }}</td>
                            <td>{{ $item->tipo }}</td>
                            <td>{{ $item->ingreso }}</td>
                            <td>{{ $item->salida }}</td>
                            <td>{{ $item->vuelo ?? '-' }}</td>
                            <td>{{ $item->posicion }}</td>
                            <td>{{ $item->Sicronizacion }}</td>
                        </tr>
                        @endforeach
                        @if(empty($accesosRecientes) || count($accesosRecientes) == 0)
                        <tr>
                            <td colspan="8" class="text-center text-muted">No hay accesos recientes registrados.</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

@section('archivos-js')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Ejemplo de datos, puedes pasarlos desde el backend si lo prefieres
    var ctx = document.getElementById('graficoAccesos').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($dias ?? ['Lun','Mar','Mié','Jue','Vie','Sáb','Dom']) !!},
            datasets: [{
                label: 'Accesos',
                data: {!! json_encode($accesosPorDia ?? [12, 15, 9, 18, 10, 17, 11]) !!},
                fill: true,
                backgroundColor: 'rgba(57, 155, 255, 0.2)',
                borderColor: 'rgba(57, 155, 255, 1)',
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
});
</script>
@stop

@extends('backend.menus.footerjs')
@section('archivos-js')

    <script src="{{ asset('js/jquery.dataTables.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.js') }}" type="text/javascript"></script>

    <script src="{{ asset('js/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/axios.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('js/alertaPersonalizada.js') }}"></script>


    <!-- incluir tabla -->
    <script type="text/javascript">
        $(document).ready(function(){
            var ruta = "{{ URL::to('/admin/roles/tabla') }}";
            $('#tablaDatatable').load(ruta);
            document.getElementById("divcontenedor").style.display = "block";
        });
    </script>

    <script>

        function verInformacion(id){
            window.location.href="{{ url('/admin/roles/lista/permisos') }}/"+id;
        }

        // ver todos los permisos que existen
        function vistaPermisos(){
            window.location.href="{{ url('/admin/roles/permisos/lista') }}";
        }

        function modalAgregar(){
            document.getElementById("formulario-nuevo").reset();
            $('#modalAgregar').modal('show');
        }

        function modalBorrar(id){
            // se obtiene el id del Rol a eliminar globalmente

            $('#idborrar').val(id);
            $('#modalBorrar').modal('show');
        }

        function borrar(){
            openLoading()
            // se envia el ID del Rol
            var idrol = document.getElementById('idborrar').value;

            var formData = new FormData();
            formData.append('idrol', idrol);

            axios.post(url+'/roles/borrar-global', formData, {
            })
                .then((response) => {
                    closeLoading()
                    $('#modalBorrar').modal('hide');

                    if(response.data.success === 1){
                        toastr.success('Rol global eliminado');
                        recargar();
                    }else{
                        toastr.error('Error al eliminar');
                    }
                })
                .catch((error) => {
                    closeLoading();
                    toastr.error('Error al eliminar');
                });
        }

        function agregarRol(){
            var nombre = document.getElementById('nombre-nuevo').value;

            if(nombre === ''){
                toastr.error('Nombre es requerido')
                return;
            }

            if(nombre.length > 30){
                toastr.error('Máximo 30 caracteres para Nombre')
                return;
            }

            openLoading()
            var formData = new FormData();
            formData.append('nombre', nombre);

            axios.post(url+'/permisos/nuevo-rol', formData, {
            })
                .then((response) => {
                    closeLoading()

                    if (response.data.success === 1) {
                        toastr.error('Rol Repetido', 'Cambiar de nombre');
                    }
                    else if(response.data.success === 2){
                        $('#modalAgregar').modal('hide');
                        recargar();
                    }
                    else {
                        toastr.error('Error al guardar');
                    }
                })
                .catch((error) => {
                    closeLoading()
                    toastr.error('Error al guardar');
                });
        }

        function recargar(){
            var ruta = "{{ url('/admin/roles/tabla') }}";
            $('#tablaDatatable').load(ruta);
        }


        // PARA ACTUALIZAR TABLA DE COSTOS
        function actualizarTabla(){

            openLoading()

            axios.post(url+'/actualizartabla', {
            })
                .then((response) => {
                    closeLoading()

                    if (response.data.success === 1) {
                        toastr.success('completado');
                    }
                    else {
                        toastr.error('Error al guardar');
                    }
                })
                .catch((error) => {
                    closeLoading()
                    toastr.error('Error al guardar');
                });
        }

    </script>



@stop