<?php
class ProductoModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    // Insertar un nuevo producto
    public function insert($datos) {
    try {
        // Buscar si el producto ya existe (por marca, descripcion, talla y precio)
        $query = $this->db->connect()->prepare(
            'SELECT idProducto, cantidad FROM producto 
             WHERE marca = :marca AND descripcion = :descripcion AND talla = :talla AND precio = :precio'
        );
        $query->execute([
            'marca'       => $datos['marca'],
            'descripcion' => $datos['descripcion'],
            'talla'       => $datos['talla'],
            'precio'      => $datos['precio'],
        ]);

        $producto = $query->fetch();

        if ($producto) {
            // Si existe, actualiza la cantidad sumando la nueva
            $updateQuery = $this->db->connect()->prepare(
                'UPDATE producto SET cantidad = cantidad + :cantidad WHERE idProducto = :idProducto'
            );
            $updateQuery->execute([
                'cantidad'   => $datos['cantidad'],
                'idProducto' => $producto['idProducto']
            ]);
            return $producto['idProducto']; // Devuelve el ID del producto actualizado
        } else {
            // Si no existe, inserta un nuevo registro
            $insertQuery = $this->db->connect()->prepare(
                'INSERT INTO producto (marca, descripcion, talla, precio, cantidad, estado)
                VALUES (:marca, :descripcion, :talla, :precio, :cantidad, :estado)'
            );
            $insertQuery->execute([
                'marca'       => $datos['marca'],
                'descripcion' => $datos['descripcion'],
                'talla'       => $datos['talla'],
                'precio'      => $datos['precio'],
                'cantidad'    => $datos['cantidad'],
                'estado'      => $datos['estado']
            ]);
            return $this->db->connect()->lastInsertId();
        }
    } catch(PDOException $e) {
        error_log($e->getMessage());
        return false;
    }
}


    // Obtener producto por ID
    public function getById($idProducto) {
        try {
            $query = $this->db->connect()->prepare("SELECT * FROM producto WHERE idProducto = :idProducto");
            $query->execute(['idProducto' => $idProducto]);
            return $query->fetch(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }

    // Actualizar producto
    public function update($datos) {
        try {
            $sql = 'UPDATE producto SET 
                marca = :marca,
                descripcion = :descripcion,
                talla = :talla,
                precio = :precio,
                cantidad = :cantidad,
                estado = :estado
                WHERE idProducto = :idProducto';

            $query = $this->db->connect()->prepare($sql);
            $params = [
                'marca'       => $datos['marca'],
                'descripcion' => $datos['descripcion'],
                'talla'       => $datos['talla'],
                'precio'      => $datos['precio'],
                'cantidad'    => $datos['cantidad'],
                'estado'      => $datos['estado'],
                'idProducto'  => $datos['idProducto']
                
            ];
            $query->execute($params);
            return true;
        } catch(PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function getUltimosProductos($limit = 5, $offset = 0) {
    try {
        $query = $this->db->connect()->prepare(
            "SELECT * FROM producto ORDER BY fecha_registro DESC LIMIT :limit OFFSET :offset"
        );
        $query->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $query->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        error_log($e->getMessage());
        return [];
    }
}

public function getTotalProductos() {
    try {
        $query = $this->db->connect()->query("SELECT COUNT(*) as total FROM producto");
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['total'] : 0;
    } catch(PDOException $e) {
        error_log($e->getMessage());
        return 0;
    }
}

public function getAllProductos() {
    try {
        $query = $this->db->connect()->query("SELECT * FROM producto WHERE estado = 1");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        error_log($e->getMessage());
        return [];
    }
}


public function buscarProductosPorMarca($marca) {
    $sql = "SELECT * FROM producto WHERE estado = 1 AND marca LIKE :marca";
    $query = $this->db->connect()->prepare($sql);
    $query->execute(['marca' => '%' . $marca . '%']);
    return $query->fetchAll(PDO::FETCH_ASSOC);
}



}
?>