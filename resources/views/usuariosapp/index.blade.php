@extends('backend.menus.superior')

@section('content-admin-css')
<link href="{{ asset('css/adminlte.min.css') }}" type="text/css" rel="stylesheet" />
<link href="{{ asset('css/dataTables.bootstrap4.css') }}" type="text/css" rel="stylesheet" />
<link href="{{ asset('css/toastr.min.css') }}" type="text/css" rel="stylesheet" />
<link href="{{ asset('css/responsive.bootstrap4.min.css') }}" type="text/css" rel="stylesheet" />
<link href="{{ asset('css/buttons.bootstrap4.min.css') }}" type="text/css" rel="stylesheet" />
<link href="{{ asset('css/estiloToggle.css') }}" type="text/css" rel="stylesheet" />
<link href="{{ asset('css/buttons_estilo.css') }}" rel="stylesheet">
@stop

<style>
table {
    table-layout: fixed;
}

.card-success>.card-header {
    background: rgb(57, 155, 255) !important;
    color: #fff !important;
    border-radius: 8px 8px 0 0;
}
</style>





<div id="divcontenedor">
    <section class="content-header">
        <div class="container-fluid">
            <div class="col-sm-12">
                <h1>Usuarios App</h1>
            </div>
            <br>
            <button type="button"
                style="font-weight: bold; background-color:rgb(52, 131, 222); color: white !important;"
                onclick="modalAgregarApp()" class="button button-3d button-rounded button-pill button-small">
                <i class="fas fa-pencil-alt"></i>
                Nuevo Usuario App
            </button>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Lista</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Usuario</th>
                                            <th>Email</th>
                                            <th>Nombre Completo</th>
                                            <th>Activo</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($usuarios as $item)
                                        <tr>
                                            <td>{{ $item->id_usuario }}</td>
                                            <td>{{ $item->usuario }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ $item->nombre_completo }}</td>
                                            <td>
                                                @if($item->activo)
                                                <span class="badge badge-success">Activo</span>
                                                @else
                                                <span class="badge badge-danger">Inactivo</span>
                                                @endif
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-info"
                                                    onclick="verInformacion({{ $item->id_usuario }})">Editar</button>
                                            </td>
                                        </tr>
                                        @endforeach

                                        @if(count($usuarios) == 0)
                                        <tr>
                                            <td colspan="6" class="text-center">No hay registros</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Modal Agregar --}}
    <div class="modal fade" id="modalAgregarApp">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Nuevo Usuario App</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formulario-nuevoapp">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="form-group">
                                        <label>Nombre Completo</label>
                                        <input type="text" maxlength="100" autocomplete="off" class="form-control"
                                            id="nombreapp-nuevo" placeholder="Nombre completo">
                                    </div>

                                    <div class="form-group">
                                        <label>Usuario</label>
                                        <input type="text" maxlength="50" autocomplete="off" class="form-control"
                                            id="usuarioapp-nuevo" placeholder="Usuario">
                                    </div>

                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" maxlength="100" autocomplete="off" class="form-control"
                                            id="emailapp-nuevo" placeholder="Email">
                                    </div>

                                    <div class="form-group">
                                        <label>Contraseña</label>
                                        <input type="password" maxlength="16" autocomplete="off" class="form-control"
                                            id="passwordapp-nuevo" placeholder="Contraseña">
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="button" style="font-weight: bold; background-color: #28a745; color: white !important;"
                        class="button button-3d button-rounded button-pill button-small"
                        onclick="nuevoUsuarioApp()">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Editar --}}
    <div class="modal fade" id="modalEditarApp">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Editar Usuario App</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formulario-editarapp">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">

                                    <input type="hidden" id="idapp-editar">

                                    <div class="form-group">
                                        <label>Nombre Completo</label>
                                        <input type="text" maxlength="100" autocomplete="off" class="form-control"
                                            id="nombreapp-editar">
                                    </div>

                                    <div class="form-group">
                                        <label>Usuario</label>
                                        <input type="text" maxlength="50" autocomplete="off" class="form-control"
                                            id="usuarioapp-editar">
                                    </div>

                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" maxlength="100" autocomplete="off" class="form-control"
                                            id="emailapp-editar">
                                    </div>

                                    <div class="form-group">
                                        <label>Contraseña</label>
                                        <input type="password" maxlength="16" autocomplete="off" class="form-control"
                                            id="passwordapp-editar"
                                            placeholder="Contraseña (dejar vacío para no cambiar)">
                                    </div>

                                    <div class="form-group">
                                        <label>Disponibilidad</label><br>
                                        <label class="switch" style="margin-top:10px">
                                            <input type="checkbox" id="toggleapp-editar">
                                            <div class="slider round">
                                                <span class="on">Activo</span>
                                                <span class="off">Inactivo</span>
                                            </div>
                                        </label>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="button" style="font-weight: bold; background-color: #28a745; color: white !important;"
                        class="button button-3d button-rounded button-pill button-small"
                        onclick="actualizarUsuarioApp()">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</div>

@extends('backend.menus.footerjs')
@section('archivos-js')

<script>
$(document).ready(function() {
    var ruta = "{{ url('admin/usuariosapp/tabla') }}";
   // $('#tablaDatatable').load(ruta); // ✅ este ID sí existe
});


function recargarApp() {
    var ruta = "{{ url('admin/usuariosapp/tabla') }}";
    location.reload(); // ✅
}



function modalAgregarApp() {
    document.getElementById("formulario-nuevoapp").reset();
    $('#modalAgregarApp').modal('show');
}

function nuevoUsuarioApp() {
    var nombre = document.getElementById('nombreapp-nuevo').value;
    var usuario = document.getElementById('usuarioapp-nuevo').value;
    var email = document.getElementById('emailapp-nuevo').value;
    var password = document.getElementById('passwordapp-nuevo').value;

    if (nombre === '' || usuario === '' || email === '' || password === '') {
        toastr.error('Todos los campos son obligatorios');
        return;
    }

    openLoading();
    var formData = new FormData();
    formData.append('nombre_completo', nombre);
    formData.append('usuario', usuario);
    formData.append('email', email);
    formData.append('password', password);

    axios.post("{{ url('/admin/usuariosapp/nuevo') }}", formData)
        .then((response) => {
            closeLoading();
            if (response.data.success === 1) {
                toastr.error('El usuario o email ya existe');
            } else if (response.data.success === 2) {
                toastr.success('Agregado');
                $('#modalAgregarApp').modal('hide');
                recargarApp();
            } else {
                toastr.error('Error al guardar');
            }
        })
        .catch((error) => {
            closeLoading();
            toastr.error('Error al guardar');
        });
}

function verInfoUsuarioApp(id) {
    openLoading();
    document.getElementById("formulario-editarapp").reset();
    axios.post("{{ url('/admin/usuariosapp/info') }}", {
            id: id
        })
        .then((response) => {
            closeLoading();
            if (response.data.success === 1) {
                $('#modalEditarApp').modal('show');
                $('#idapp-editar').val(response.data.usuario.id_usuario);
                $('#nombreapp-editar').val(response.data.usuario.nombre_completo);
                $('#usuarioapp-editar').val(response.data.usuario.usuario);
                $('#emailapp-editar').val(response.data.usuario.email);

                $("#toggleapp-editar").prop("checked", response.data.usuario.activo === 1);
            } else {
                toastr.error('No encontrado');
            }
        })
        .catch((error) => {
            closeLoading();
            toastr.error('No encontrado');
        });
}

function actualizarUsuarioApp() {
    var id = document.getElementById('idapp-editar').value;
    var nombre = document.getElementById('nombreapp-editar').value;
    var usuario = document.getElementById('usuarioapp-editar').value;
    var email = document.getElementById('emailapp-editar').value;
    var password = document.getElementById('passwordapp-editar').value;
    var activo = document.getElementById('toggleapp-editar').checked ? 1 : 0;

    if (nombre === '' || usuario === '' || email === '') {
        toastr.error('Nombre, usuario y email son obligatorios');
        return;
    }

    openLoading();
    var formData = new FormData();
    formData.append('id_usuario', id);
    formData.append('nombre_completo', nombre);
    formData.append('usuario', usuario);
    formData.append('email', email);
    formData.append('password', password);
    formData.append('activo', activo);

    axios.post("{{ url('/admin/usuariosapp/editar') }}", formData)
        .then((response) => {
            closeLoading();
            if (response.data.success === 1) {
                toastr.error('El usuario o email ya existe');
            } else if (response.data.success === 2) {
                toastr.success('Actualizado');
                $('#modalEditarApp').modal('hide');
                recargarApp();
            } else {
                toastr.error('Error al actualizar');
            }
        })
        .catch((error) => {
            closeLoading();
            toastr.error('Error al actualizar');
        });
}
</script>
@stop