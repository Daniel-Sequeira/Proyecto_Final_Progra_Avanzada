<?php 
class EmpleadoModel extends Model {

    public function __construct() {
        parent::__construct();
    }
    // Obtener todos los empleados
    public function getAll() {
        $items = [];
        try {
            $query = $this->db->connect()->query("SELECT * FROM empleado");
            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $items[] = $row;
            }
            return $items;
        } catch(PDOException $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    // Obtener un empleado por ID
    public function getById($id) {
        try {
            $query = $this->db->connect()->prepare("SELECT * FROM empleado WHERE id_empleado = :id_empleado");
            $query->execute(['id_empleado' => $id_empleado]);
            return $query->fetch(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }

    // Cambia el estado (habilitar/deshabilitar)
    public function cambiarEstado($id_empleado, $estado) {
        try {
            $query = $this->db->connect()->prepare("UPDATE empleado SET estado = :estado WHERE id_empleado = :id_empleado");
            $query->execute(['estado' => $estado, 'id_empleado' => $id_empleado]);
            return true;
        } catch(PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    // Insertar un nuevo empleado
    public function insert($datos) {
        try {
            $query = $this->db->connect()->prepare(
                'INSERT INTO empleado (nombre, correo, telefono, cedula, contrasena, estado, id_rol) 
                 VALUES (:nombre, :correo, :telefono, :cedula, :contrasena, :estado, :id_rol)'
            );
            $query->execute([
                'nombre'      => $datos['nombre'],
                'correo'      => $datos['correo'],
                'telefono'    => $datos['telefono'],
                'cedula'      => $datos['cedula'],
                'contrasena'  => password_hash($datos['contrasena'], PASSWORD_DEFAULT),
                'estado'      => $datos['estado'],
                'id_rol'      => $datos['id_rol']
            ]);
            return true;
        } catch(PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    // Actualizar empleado
   public function update($datos) {
    try {
        $sql = 'UPDATE empleado SET 
            nombre = :nombre, 
            correo = :correo, 
            telefono = :telefono, 
            cedula = :cedula, 
            estado = :estado, 
            id_rol = :id_rol';

        // Solo si viene nueva contraseña
        if (!empty($datos['contrasena'])) {
            $sql .= ', contrasena = :contrasena';
        }

        $sql .= ' WHERE id_empleado = :id_empleado';

        $query = $this->db->connect()->prepare($sql);

        // Bind de variables
        $params = [
            'nombre'      => $datos['nombre'],
            'correo'      => $datos['correo'],
            'telefono'    => $datos['telefono'],
            'cedula'      => $datos['cedula'],
            'estado'      => $datos['estado'],
            'id_rol'      => $datos['id_rol'],
            'id_empleado' => $datos['id_empleado']
        ];
        if (!empty($datos['contrasena'])) {
            $params['contrasena'] = password_hash($datos['contrasena'], PASSWORD_DEFAULT);
        }
        $query->execute($params);
        return true;
    } catch(PDOException $e) {
        error_log($e->getMessage());
        return false;
    }
    }
}

?>