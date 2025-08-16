<?php
class ClienteModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    // Obtener todos los clientes
    public function getAll() {
        $items = [];
        try {
            $query = $this->db->connect()->query("SELECT * FROM cliente");
            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $items[] = $row;
            }
            return $items;
        } catch(PDOException $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    // Obtener un cliente por ID
    public function getById($id_cliente) {
        try {
            $query = $this->db->connect()->prepare("SELECT * FROM cliente WHERE id_cliente = :id_cliente");
            $query->execute(['id_cliente' => $id_cliente]);
            return $query->fetch(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }

    // Insertar un nuevo cliente
    public function insert($datos) {
        try {
            $query = $this->db->connect()->prepare(
                'INSERT INTO cliente (nombre, correo, cedula) VALUES (:nombre, :correo, :cedula)'
            );
            $query->execute([
                'nombre'  => $datos['nombre'],
                'correo'  => $datos['correo'],
                'cedula'  => $datos['cedula']
            ]);
            return true;
        } catch(PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    // Actualizar cliente
    public function update($datos) {
        try {
            $sql = 'UPDATE cliente SET nombre = :nombre, correo = :correo, cedula = :cedula WHERE id_cliente = :id_cliente';
            $query = $this->db->connect()->prepare($sql);

            $params = [
                'nombre'     => $datos['nombre'],
                'correo'     => $datos['correo'],
                'cedula'     => $datos['cedula'],
                'id_cliente' => $datos['id_cliente']
            ];

            $query->execute($params);
            return true;
        } catch(PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}
?>
