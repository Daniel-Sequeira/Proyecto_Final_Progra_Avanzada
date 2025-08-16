<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Empleados</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body>
    <?php require(__DIR__ . '/../../layout/header.php') ?>
    <div class="container my-4">
        <h1 class="mb-4">Gestión de Empleados</h1>

        <!-- Botón para mostrar el modal de registro -->
        <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#modalEmpleado">
            Registrar Nuevo Empleado
        </button>

        <!-- Tabla de empleados -->

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Cédula</th>
                    <th>Rol</th>
                    <th>Estado</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($this ->empleados as $empleado): ?>
                <tr>
                    <td><?= htmlspecialchars($empleado['id_empleado']) ?></td>
                    <td><?= htmlspecialchars($empleado['nombre']) ?></td>
                    <td><?= htmlspecialchars($empleado['correo']) ?></td>
                    <td><?= htmlspecialchars($empleado['telefono']) ?></td>
                    <td><?= htmlspecialchars($empleado['cedula']) ?></td>
                    <td><?= htmlspecialchars($empleado['id_rol']) ?></td>
                    <td>
                        <?php if($empleado['estado'] == 1): ?>
                        <span class="badge badge-success">Habilitado</span>
                        <?php else: ?>
                        <span class="badge badge-secondary">Deshabilitado</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <!-- Cambio de estado -->
                        <form action="<?= constant('URL'); ?>empleado/cambiarEstado" method="POST"
                            style="display:inline;">
                            <input type="hidden" name="id_empleado" value="<?= $empleado['id_empleado'] ?>">
                            <input type="hidden" name="nuevo_estado" value="<?= $empleado['estado'] == 1 ? 0 : 1 ?>">
                            <button class="btn btn-sm <?= $empleado['estado'] == 1 ? 'btn-warning' : 'btn-success' ?>"
                                title="Cambiar Estado">
                                <?= $empleado['estado'] == 1 ? 'Deshabilitar' : 'Habilitar' ?>
                            </button>
                        </form>
                        <!-- Editar (esto puede también abrir otro modal o link a un formulario de edición) -->
                        <button type="button" class="btn btn-sm btn-info" data-toggle="modal"
                            data-target="#modalEditarEmpleado" data-id="<?= $empleado['id_empleado'] ?>"
                            data-nombre="<?= htmlspecialchars($empleado['nombre'], ENT_QUOTES) ?>"
                            data-correo="<?= htmlspecialchars($empleado['correo'], ENT_QUOTES) ?>"
                            data-telefono="<?= htmlspecialchars($empleado['telefono'], ENT_QUOTES) ?>"
                            data-cedula="<?= htmlspecialchars($empleado['cedula'], ENT_QUOTES) ?>"
                            data-estado="<?= $empleado['estado'] ?>" data-id_rol="<?= $empleado['id_rol'] ?>">
                            Editar
                        </button>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="d-flex justify-content-end mt-3">
            <a href="<?= constant('URL'); ?>dashboard" class="btn btn-secondary">
                Regresar
            </a>
        </div>
    </div>


    <!-- Modal de Registro de Empleado -->
    <div class="modal fade" id="modalEmpleado" tabindex="-1" role="dialog" aria-labelledby="modalEmpleadoLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEmpleadoLabel">Registrar Nuevo Empleado</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php echo constant('URL');?>empleado/registrarEmpleado" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="cedula">Cédula</label>
                            <input type="text" id="cedula" name="cedula" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" id="nombre" name="nombre" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="correo">Correo</label>
                            <input type="email" id="correo" name="correo" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="telefono">Teléfono</label>
                            <input type="text" id="telefono" name="telefono" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="contrasena">Contraseña</label>
                            <input type="password" id="contrasena" name="contrasena" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="estado">Estado</label>
                            <select id="estado" name="estado" class="form-control" required>
                                <option value="1">Habilitado</option>
                                <option value="0">Deshabilitado</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="id_rol">Rol</label>
                            <input type="text" id="id_rol" name="id_rol" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--Modal de Edición de Empleado -->
    <div class="modal fade" id="modalEditarEmpleado" tabindex="-1" role="dialog"
        aria-labelledby="modalEditarEmpleadoLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="<?= constant('URL'); ?>empleado/actualizarEmpleado" method="POST" id="formEditarEmpleado">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditarEmpleadoLabel">Editar Empleado</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id_empleado" id="edit_id_empleado">
                        <div class="form-group">
                            <label>Cédula</label>
                            <input type="text" name="cedula" id="edit_cedula" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" name="nombre" id="edit_nombre" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Correo</label>
                            <input type="email" name="correo" id="edit_correo" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Teléfono</label>
                            <input type="text" name="telefono" id="edit_telefono" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Estado</label>
                            <select name="estado" id="edit_estado" class="form-control" required>
                                <option value="1">Habilitado</option>
                                <option value="0">Deshabilitado</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Rol</label>
                            <input type="text" name="id_rol" id="edit_id_rol" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>
                                <input type="checkbox" id="check_cambiar_contrasena">
                                Cambiar contraseña
                            </label>
                            <input type="password" class="form-control" name="contrasena" id="edit_contrasena" disabled
                                placeholder="Nueva contraseña">
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <!-- Bootstrap JS + jQuery (requeridos por modal) -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script>
    $(function() {
        // Cuando el campo de cédula pierde el foco, consultamos la API
        $('#cedula').on('blur', function() {
            var cedula = $(this).val().trim();
            // Valida: 9 dígitos
            if (/^[0-9]{9}$/.test(cedula)) {
                fetch(`https://api.hacienda.go.cr/fe/ae?identificacion=${cedula}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.nombre && data.nombre.length > 0) {
                            var $nombre = $('#nombre');
                            if ($nombre.val() !== '' && $nombre.val() !== data.nombre) {
                                if (confirm(
                                        `La cédula ${cedula} corresponde a "${data.nombre}". ¿Desea actualizar el nombre?`
                                        )) {
                                    $nombre.val(data.nombre);
                                }
                            } else if ($nombre.val() === '') {
                                $nombre.val(data.nombre);
                            }
                        } else {
                            alert('No se encontró información para la cédula proporcionada.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Hubo un error al consultar la cédula.');
                    });
            }
        });
    });
    </script>

</body>

</html>