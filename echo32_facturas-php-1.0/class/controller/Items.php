<?php

include_once '../class/model/ConceptoFactura.php';
include_once '../class/model/DetalleFactura.php';

class Items {

    private $concepto, $precio, $cantidad, $tdCount, $clientName, $clientTel, $clientMail, $fecha, $nombre, $correo, $telefo, $direcc;
    public $ConceptoFactura, $DetalleFactura;

    function __construct() {
        $this->ConceptoFactura = new ConceptoFactura();
        $this->DetalleFactura = new DetalleFactura();
        $this->concepto = isset($_POST['concepto']) ? $_POST['concepto'] : null;
        $this->precio = isset($_POST['precio']) ? $_POST['precio'] : null;
        $this->cantidad = isset($_POST['cantidad']) ? $_POST['cantidad'] : null;
        $this->tdCount = isset($_POST['tdCount']) ? $_POST['tdCount'] : null;
        $this->clientName = isset($_POST['clientName']) ? $_POST['clientName'] : null;
        $this->clientTel = isset($_POST['clientTel']) ? $_POST['clientTel'] : null;
        $this->clientMail = isset($_POST['clientMail']) ? $_POST['clientMail'] : null;
        $this->fecha = isset($_POST['fecha']) ? $_POST['fecha'] : null;
        $this->nombre = isset($_POST['nombre']) ? $_POST['nombre'] : null;
        $this->correo = isset($_POST['correo']) ? $_POST['correo'] : null;
        $this->telefo = isset($_POST['telefo']) ? $_POST['telefo'] : null;
        $this->direcc = isset($_POST['direcc']) ? $_POST['direcc'] : null;
    }

    public function newItem() {
        $tbody = "<tr>";
        $tbody .= "<td class='counter-td' style='width:10%'>" . (intval($this->tdCount) + 1) . "</td>";
        $tbody .= "<td style='width:50%'>" . $this->concepto . "</td>";
        $tbody .= "<td style='width:10%'>" . $this->cantidad . "</td>";
        $tbody .= "<td style='width:10%'>" . floatval($this->precio) . "</td>";
        $tbody .= "<td class='sum' style='width:10%'>" . (floatval($this->precio) * intval($this->cantidad)) . "</td>";
        $tbody .= "<td class='acctions' style='width:10%'><button type='button' class='btn btn-danger action' onclick='remove(this)'>Remover</button></td>";
        $tbody .= "</tr>";
        echo $tbody;
    }

    public function getData() {
        $num = 1;
        foreach ($this->ConceptoFactura->getNumeroFactura() as $k) {
            if ($k->numero_factura > 0) {
                $num = $k->numero_factura + 1;
            }
        }
        $det = new DetalleFactura();
        foreach ($this->DetalleFactura->getDetalles() as $k) {
            $det->id_detalle_factura = $k->id_detalle_factura;
            $det->nombre_empresa = $k->nombre_empresa;
            $det->direccion_empresa = $k->direccion_empresa;
            $det->correo_empresa = $k->correo_empresa;
            $det->telefono_empresa = $k->telefono_empresa;
        }
        $invoice = "<div id='invoice'><div class='container'><div class='row'><div class='col'>";
        $invoice .= "<h2>Factura #" . sprintf("%'.09d", $num) . "</h2><p>" . $det->nombre_empresa . "</p><p>" . $det->direccion_empresa . "</p>";
        $invoice .= "<p>" . $det->telefono_empresa . "</p><p>" . $det->correo_empresa . "</p></div><div class='col'><div class='card text-center'>";
        $invoice .= "<div class='card-body'><img src='resources/img/logo.png' alt='' width='150'></div></div></div></div>";
        $invoice .= "<div class='row'><div class='col'><h4>Cliente</h4><p id='clientName'></p><p id='clientTel'></p><p id='clientMail'></p>";
        $invoice .= "</div><div class='col'><h4>Fecha</h4><div id='fecha'></div></div></div><div class='row'><div class='col'>";
        $invoice .= "<table class='table' id='factura-pdf'><thead><tr><th scope='col' style='width: 10%;'>#</th><th scope='col' style='width: 50%;'>Concepto</th>";
        $invoice .= "<th scope='col' style='width: 10%;'>Cantidad</th><th scope='col' style='width: 10%;'>Precio/u</th><th scope='col' style='width: 20%;'>Precio</th>";
        $invoice .= "</tr></thead><tbody></tbody><tfoot><tr><th colspan='4'>Total</th><th id='totalInvoice' >$ 0.00</th></tr></tfoot></table></div></div></div></div>";
        echo $invoice;
    }

    public function create() {
        $prev = new ConceptoFactura();
        $num = 1;
        foreach ($this->ConceptoFactura->getNumeroFactura() as $k) {
            if ($k->numero_factura > 0) {
                $num = $k->numero_factura + 1;
            }
        }
        $prev->nombre_concepto = $this->concepto;
        $prev->precio_concepto = $this->precio;
        $prev->cantidad_concepto = $this->cantidad;
        $prev->nombre_cliente = $this->clientName;
        $prev->numero_factura = $num;
        $prev->telefono_cliente = $this->clientTel;
        $prev->correo_cliente = $this->clientMail;
        $prev->fecha = $this->fecha;
        $prev->concepto_detalle = 1;
        $this->ConceptoFactura->create($prev);
    }

    public function getInfo() {
        $num = 1;
        foreach ($this->ConceptoFactura->getNumeroFactura() as $k) {
            if ($k->numero_factura > 0) {
                $num = $k->numero_factura + 1;
            }
        }
        $det = new DetalleFactura();
        foreach ($this->DetalleFactura->getDetalles() as $k) {
            $det->id_detalle_factura = $k->id_detalle_factura;
            $det->nombre_empresa = $k->nombre_empresa;
            $det->direccion_empresa = $k->direccion_empresa;
            $det->correo_empresa = $k->correo_empresa;
            $det->telefono_empresa = $k->telefono_empresa;
        }
        $detalles = "<div class='container'><div class='row'>";
        $detalles .= "<div class='col-xl-8'>";
        $detalles .= "<div class='row'><div class='col'>Nombre de la Empresa: " . $det->nombre_empresa . "<input type='text' id='input-name' value='" . $det->nombre_empresa . "' class='form-control' maxlength='50'></div></div><br>";
        $detalles .= "<div class='row'><div class='col'>Correo de la Empresa: " . $det->correo_empresa . "<input type='text' id='input-mail' value='" . $det->correo_empresa . "' class='form-control' maxlength='50'></div></div><br>";
        $detalles .= "<div class='row'><div class='col'>Telefono de la Empresa: " . $det->telefono_empresa . "<input type='tel' id='input-tel' value='' placeholder='" . $det->telefono_empresa . "' data-mask='0000 0000 0000' class='form-control'></div></div><br>";
        $detalles .= "<div class='row'><div class='col'>Dirección de la Empresa: " . $det->direccion_empresa . "<textarea id='input-direction' rows='5' class='form-control' maxlength='50'>" . $det->direccion_empresa . "</textarea></div></div>";
        $detalles .= "</div>";
        $detalles .= "<div class='col-xl-4 text-center'>";
        $detalles .= "<div class='row'><div class='col' id='img-div'><img calss='border rounded' src='resources/img/logo.png' width='200'></div></div>";
        $detalles .= "<div class='row'><div class='col'><br><div class='input-group'><div class='text-left'><label class='custom-file-label' for='input-img' id='title-img-input'>Cargar Imagen</label><input onchange='getLoad()' accept='image/png' type='file' class='custom-file-input' id='images' name='images'></div></div></div></div>";
        $detalles .= "<div class='row'><div class='col'><br><input type='button' onclick='loadImg()' class='btn btn-success' disabled id='img-ch' value='Cambiar Imagen'></div></div>";
        $detalles .= "<div class='row'><div class='col'><br><p>La imagen debe tener como extensión png, la pagina sera recargada para guardar los cambios</p></div></div>";
        $detalles .= "</div>";
        $detalles .= "</div></div>";
        echo $detalles;
    }

    public function getFile() {
        try {
            move_uploaded_file($_FILES["file"]["tmp_name"], "../resources/img/logo.png");
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function setInfo() {
        try {
            $this->DetalleFactura->update($this->nombre, $this->direcc, $this->correo, $this->telefo);
            echo $this->nombre . " " . $this->correo . " " . $this->telefo . " " . $this->direcc;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

}

?>