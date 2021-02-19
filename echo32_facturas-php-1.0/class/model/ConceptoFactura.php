<?php

/**
 * Description of ConceptoFactura
 *
 * @author Echo
 */
class ConceptoFactura {

    public $CNX;
    public $id_concepto;
    public $nombre_concepto;
    public $precio_concepto;
    public $cantidad_concepto;
    public $numero_factura;
    public $nombre_cliente;
    public $telefono_cliente;
    public $correo_cliente;
    public $fecha;
    public $concepto_detalle;

    function __construct() {
        try {
            $this->CNX = conector::conectar();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function getNumeroFactura() {
        try {
            $sql = "SELECT numero_factura FROM concepto_factura ORDER BY id_concepto DESC LIMIT 1";
            $smt = $this->CNX->prepare($sql);
            $smt->execute();
            return $smt->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function create(ConceptoFactura $data) {
        try {
            $sql = "INSERT INTO concepto_factura(nombre_concepto, precio_concepto, cantidad_concepto, numero_factura, nombre_cliente, telefono_cliente, correo_cliente, fecha, concepto_detalle) VALUES(?,?,?,?,?,?,?,?,?)";
            $this->CNX->prepare($sql)->execute(array($data->nombre_concepto, $data->precio_concepto, $data->cantidad_concepto, $data->numero_factura, $data->nombre_cliente, $data->telefono_cliente, $data->correo_cliente, $data->fecha, $data->concepto_detalle));
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function getHistorial() {
        try {
            $sql = "SELECT numero_factura, nombre_cliente, fecha FROM concepto_factura GROUP BY fecha ORDER BY nombre_cliente";
            $smt = $this->CNX->prepare($sql);
            $smt->execute();
            return $smt->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function getDetalles($factura, $cliente, $date) {
        try {
            $sql = "SELECT nombre_concepto, precio_concepto, cantidad_concepto FROM concepto_factura WHERE numero_factura = ? AND nombre_cliente = ? AND fecha = ? ORDER BY fecha";
            $smt = $this->CNX->prepare($sql);
            $smt->execute([$factura, $cliente, $date]);
            return $smt->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

}
