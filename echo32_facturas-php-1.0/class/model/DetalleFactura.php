<?php

/**
 * Description of DetalleFactura
 *
 * @author Echo
 */
class DetalleFactura {

    public $CNX;
    public $id_detalle_factura;
    public $nombre_empresa;
    public $direccion_empresa;
    public $correo_empresa;
    public $telefono_empresa;

    function __construct() {
        try {
            $this->CNX = conector::conectar();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function getDetalles() {
        try {
            $sql = "SELECT id_detalle_factura, nombre_empresa, direccion_empresa, correo_empresa, telefono_empresa FROM detalle_factura";
            $smt = $this->CNX->prepare($sql);
            $smt->execute();
            return $smt->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
    
    public function update($nombre, $correo, $telefo, $direcc){
        try {
        $sql = "UPDATE detalle_factura SET nombre_empresa= ?, direccion_empresa = ?, correo_empresa = ?, telefono_empresa = ? WHERE id_detalle_factura = 1";
        $this->CNX->prepare($sql)->execute([$nombre, $correo, $telefo, $direcc]);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
    
}
