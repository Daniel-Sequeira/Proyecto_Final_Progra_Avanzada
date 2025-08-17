<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestión de Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php require(__DIR__ . '/../../layout/header.php'); ?>

    <div class="container my-4">
        <!-- Botón para abrir el modal -->
        <button type="button" class="btn btn-success mb-4" data-bs-toggle="modal"
            data-bs-target="#registroProductoModal">
            Registrar Producto
        </button>


        <!-- Modal -->
        <div class="modal fade" id="registroProductoModal" tabindex="-1" aria-labelledby="registroProductoModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="registroProductoModalLabel">Registrar Nuevo Producto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <form action="<?= constant('URL'); ?>producto/registrarProducto" method="POST">
                            <div class="mb-3">
                                <label for="marca" class="form-label">Marca</label>
                                <input type="text" id="marca" name="marca" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <textarea id="descripcion" name="descripcion" class="form-control" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="talla" class="form-label">Talla</label>
                                <input type="text" id="talla" name="talla" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="precio" class="form-label">Precio</label>
                                <input type="number" step="0.01" id="precio" name="precio" class="form-control"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="cantidad" class="form-label">Cantidad</label>
                                <input type="number" id="cantidad" name="cantidad" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="estado" class="form-label">Estado</label>
                                <select id="estado" name="estado" class="form-select" required>
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Registrar Producto</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de últimos 5 productos registrados -->
        <hr>
        <h2>Productos Registrados</h2>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Marca</th>
                    <th>Descripción</th>
                    <th>Talla</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Estado</th>
                    <th>Fecha Registro</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($this->productos)): ?>
                <?php foreach ($this->productos as $producto): ?>
                <tr>
                    <td><?= htmlspecialchars($producto['idProducto']) ?></td>
                    <td><?= htmlspecialchars($producto['marca']) ?></td>
                    <td><?= htmlspecialchars($producto['descripcion']) ?></td>
                    <td><?= htmlspecialchars($producto['talla']) ?></td>
                    <td><?= htmlspecialchars($producto['precio']) ?></td>
                    <td><?= htmlspecialchars($producto['cantidad']) ?></td>
                    <td><?= $producto['estado'] == 1 ? 'Activo' : 'Inactivo' ?></td>
                    <td><?= htmlspecialchars($producto['fecha_registro']) ?></td>
                    <td>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#modalEditarProducto"
                            data-id="<?= htmlspecialchars($producto['idProducto']) ?>"
                            data-marca="<?= htmlspecialchars($producto['marca']) ?>"
                            data-descripcion="<?= htmlspecialchars($producto['descripcion']) ?>"
                            data-talla="<?= htmlspecialchars($producto['talla']) ?>"
                            data-precio="<?= htmlspecialchars($producto['precio']) ?>"
                            data-cantidad="<?= htmlspecialchars($producto['cantidad']) ?>"
                            data-estado="<?= htmlspecialchars($producto['estado']) ?>">
                            Editar
                        </button>

                    </td>
                </tr>
                <?php endforeach; ?>
                <?php else: ?>
                <tr>
                    <td colspan="9" class="text-center">No hay productos registrados.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Paginación -->
        <?php if (!empty($this->totalPaginas) && $this->totalPaginas > 1): ?>
        <nav>
            <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $this->totalPaginas; $i++): ?>
                <li class="page-item <?= ($i == $this->paginaActual) ? 'active' : '' ?>">
                    <a class="page-link" href="<?= constant('URL'); ?>producto/index?page=<?= $i ?>"><?= $i ?></a>
                </li>
                <?php endfor; ?>
            </ul>
        </nav>
        <?php endif; ?>
        <div class="d-flex justify-content-end mt-3">
            <a href="<?= constant('URL'); ?>dashboard" class="btn btn-secondary">
                Regresar
            </a>
        </div>
    </div>

    <!-- Modal Bootstrap v5 -->
    <div class="modal fade" id="modalEditarProducto" tabindex="-1" aria-labelledby="modalEditarProductoLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="formEditarProducto" method="POST" action="<?php echo constant('URL'); ?>producto/actualizarProducto">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalEditarProductoLabel">Editar Producto</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="editarId" name="idProducto">
          <div class="mb-3">
            <label for="editarMarca" class="form-label">Marca</label>
            <input type="text" class="form-control" id="editarMarca" name="marca" required>
          </div>
          <div class="mb-3">
            <label for="editarDescripcion" class="form-label">Descripción</label>
            <input type="text" class="form-control" id="editarDescripcion" name="descripcion" required>
          </div>
          <div class="mb-3">
            <label for="editarTalla" class="form-label">Talla</label>
            <input type="text" class="form-control" id="editarTalla" name="talla" required>
          </div>
          <div class="mb-3">
            <label for="editarPrecio" class="form-label">Precio</label>
            <input type="number" step="0.01" class="form-control" id="editarPrecio" name="precio" required>
          </div>
          <div class="mb-3">
            <label for="editarCantidad" class="form-label">Cantidad</label>
            <input type="number" class="form-control" id="editarCantidad" name="cantidad" required>
          </div>
          <div class="mb-3">
            <label for="editarEstado" class="form-label">Estado</label>
            <select class="form-select" id="editarEstado" name="estado" required>
              <option value="1">Activo</option>
              <option value="0">Inactivo</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Actualizar</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </form>
  </div>
</div>


   <script>
document.addEventListener('DOMContentLoaded', function () {
  var modalEditar = document.getElementById('modalEditarProducto');
  modalEditar.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget;
    document.getElementById('editarId').value = button.getAttribute('data-id');
    document.getElementById('editarMarca').value = button.getAttribute('data-marca');
    document.getElementById('editarDescripcion').value = button.getAttribute('data-descripcion');
    document.getElementById('editarTalla').value = button.getAttribute('data-talla');
    document.getElementById('editarPrecio').value = button.getAttribute('data-precio');
    document.getElementById('editarCantidad').value = button.getAttribute('data-cantidad');
    document.getElementById('editarEstado').value = button.getAttribute('data-estado');
  });
});
</script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>