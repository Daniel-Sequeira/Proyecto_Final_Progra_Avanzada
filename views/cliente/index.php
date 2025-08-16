<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Clientes</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <?php require(__DIR__ . '/../../layout/header.php') ?>
    <div class="container my-4">
        <h1 class="mb-4">Gestión de Clientes</h1>

        <!-- Botón para mostrar el modal de registro -->
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalCliente">
            Registrar Nuevo Cliente
        </button>

        <!-- Tabla de clientes -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Cédula</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($this->clientes as $cliente): ?>
                <tr>
                    <td><?= htmlspecialchars($cliente['id_cliente']) ?></td>
                    <td><?= htmlspecialchars($cliente['nombre']) ?></td>
                    <td><?= htmlspecialchars($cliente['correo']) ?></td>
                    <td><?= htmlspecialchars($cliente['cedula']) ?></td>
                    <td>
                        <!-- Editar botón (puedes abrir un modal con los datos actuales) -->
                        <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal"
                            data-bs-target="#modalEditarCliente" 
                            data-id="<?= $cliente['id_cliente'] ?>"
                            data-nombre="<?= htmlspecialchars($cliente['nombre'], ENT_QUOTES) ?>"
                            data-correo="<?= htmlspecialchars($cliente['correo'], ENT_QUOTES) ?>"
                            data-cedula="<?= htmlspecialchars($cliente['cedula'], ENT_QUOTES) ?>">
                            Editar
                        </button>
                    </td>
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

    <!-- Modal de Registro de Cliente -->
    <div class="modal fade" id="modalCliente" tabindex="-1" aria-labelledby="modalClienteLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalClienteLabel">Registrar Nuevo Cliente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?php echo constant('URL');?>cliente/registrarCliente" method="POST">
                    <div class="modal-body">
                        <div class="form-group mb-2">
                            <label for="cedula">Cédula</label>
                            <input type="text" id="cedula" name="cedula" class="form-control" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="nombre">Nombre</label>
                            <input type="text" id="nombre" name="nombre" class="form-control" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="correo">Correo</label>
                            <input type="email" id="correo" name="correo" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de Edición de Cliente -->
    <div class="modal fade" id="modalEditarCliente" tabindex="-1" aria-labelledby="modalEditarClienteLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="<?= constant('URL'); ?>cliente/actualizarCliente" method="POST" id="formEditarCliente">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditarClienteLabel">Editar Cliente</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id_cliente" id="edit_id_cliente">
                        <div class="form-group mb-2">
                            <label>Cédula</label>
                            <input type="text" name="cedula" id="edit_cedula" class="form-control" required>
                        </div>
                        <div class="form-group mb-2">
                            <label>Nombre</label>
                            <input type="text" name="nombre" id="edit_nombre" class="form-control" required>
                        </div>
                        <div class="form-group mb-2">
                            <label>Correo</label>
                            <input type="email" name="correo" id="edit_correo" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

<!-- Bootstrap 5 JS + jQuery (solo si necesitas para validaciones adicionales, para la versión Modal en Bootstrap 5, puedes omitir jQuery si ya no lo usas) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Set datos para modal de edición de cliente
    var modalEditar = document.getElementById('modalEditarCliente');
    modalEditar.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        document.getElementById('edit_id_cliente').value = button.getAttribute('data-id');
        document.getElementById('edit_nombre').value = button.getAttribute('data-nombre');
        document.getElementById('edit_correo').value = button.getAttribute('data-correo');
        document.getElementById('edit_cedula').value = button.getAttribute('data-cedula');
    });

    // Consulta API por cédula si la quieres usar
    document.getElementById('cedula').addEventListener('blur', function() {
        var cedula = this.value.trim();
        if(/^[0-9]{9}$/.test(cedula)) {
            fetch(`https://api.hacienda.go.cr/fe/ae?identificacion=${cedula}`)
                .then(response => response.json())
                .then(data => {
                    if(data.nombre && data.nombre.length > 0) {
                        var $nombre = document.getElementById('nombre');
                        if($nombre.value !== '' && $nombre.value !== data.nombre) {
                            if(confirm(`La cédula ${cedula} corresponde a "${data.nombre}". ¿Desea actualizar el nombre?`)) {
                                $nombre.value = data.nombre;
                            }
                        } else if($nombre.value === '') {
                            $nombre.value = data.nombre;
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