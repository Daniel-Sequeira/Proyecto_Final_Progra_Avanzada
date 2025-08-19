<?php

class CarritoModel extends Model {

     public function __construct() {
        parent::__construct();
    }

    // Guarda una factura y retorna el ID generado
    public function insertFactura($data) {
        $query = $this->db->connect()->prepare(
            "INSERT INTO factura (fecha_emision, id_cliente, id_empleado, estado)
            VALUES (NOW(), :id_cliente, :id_empleado, :estado)"
        );
        $query->execute([
            'id_cliente'  => $data['id_cliente'],
            'id_empleado' => $data['id_empleado'],
            'estado'      => $data['estado']
        ]);
        return $this->connect()->db->lastInsertId();
    }

    // Guarda un detalle de factura (llama por cada producto en el carrito)
    public function insertDetalleFactura($data) {
        $query = $this->connect()->db->prepare(
            "INSERT INTO detalle_factura
                (id_factura, id_producto, cantidad, precio, descuento, impuesto, subtotal, total_impuestos, total_general)
             VALUES
                (:id_factura, :id_producto, :cantidad, :precio, :descuento, :impuesto, :subtotal, :total_impuestos, :total_general)"
        );
        $query->execute([
            'id_factura'      => $data['id_factura'],
            'id_producto'     => $data['id_producto'],
            'cantidad'        => $data['cantidad'],
            'precio'          => $data['precio'],
            'descuento'       => $data['descuento'],
            'impuesto'        => $data['impuesto'],
            'subtotal'        => $data['subtotal'],
            'total_impuestos' => $data['total_impuestos'],
            'total_general'   => $data['total_general']
        ]);
    }

    // Obtener una factura por su ID
    public function getFacturaById($id_factura) {
        $query = $this->db->connect()->prepare("SELECT * FROM factura WHERE id_factura = :id");
        $query->execute(['id' => $id_factura]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    // Obtener los detalles de una factura
    public function getDetallesFactura($id_factura) {
        $query = $this->db->connect()->prepare("SELECT * FROM detalle_factura WHERE id_factura = :id");
        $query->execute(['id' => $id_factura]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Historial de todas las facturas
    public function getHistorialFacturas() {
        $query = $this->db->connect()->query("SELECT * FROM factura ORDER BY fecha_emision DESC");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Opcional: obtener facturas por cliente
    public function getFacturasPorCliente($id_cliente) {
        $query = $this->db->connect()->prepare("SELECT * FROM factura WHERE id_cliente = :id_cliente ORDER BY fecha_emision DESC");
        $query->execute(['id_cliente' => $id_cliente]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
