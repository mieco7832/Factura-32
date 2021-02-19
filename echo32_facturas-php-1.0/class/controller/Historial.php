<?php

include_once '../class/model/ConceptoFactura.php';
include_once '../class/model/DetalleFactura.php';

class Historial {

    public $ConceptoFactura, $DetalleFactura;

    function __construct() {
        $this->ConceptoFactura = new ConceptoFactura();
        $this->DetalleFactura = new DetalleFactura();
    }

    public function getFacturas() {
        $data = $this->ConceptoFactura->getHistorial();
        $invoice = "<div class='accordion' id='accordion'>";
        if (count($data) != 0) {
            foreach ($data as $k) {
                $invoice .= "<div class='card'><div class='card-header'><h2 class='mb-0'>";
                $invoice .= "<button class='btn btn-link collapsed' type='button' data-toggle='collapse' data-target='#collapse" . $k->numero_factura . "' aria-expanded='true' aria-controls='collapse" . $k->numero_factura . "'>";
                $invoice .= "#: " . sprintf("%'.09d", $k->numero_factura) . " Cliente:" . $k->nombre_cliente . " Fecha: " . $k->fecha;
                $invoice .= "</button></h2></div>";
                $invoice .= "<div id='collapse" . $k->numero_factura . "' class='collapse' aria-labelledby='heading" . $k->numero_factura . "' data-parent='#accordion'>";
                $invoice .= "<div class='card-body'>";
                $invoice .= "<table class='table'><thead><tr> <th>#</th> <th>Concepto</th> <th>Cantidad</th> <th>Precio/u</th> <th>Precio</th></tr></thead><tbody>";
                $sum = 1;
                $total = 0;
                foreach ($this->ConceptoFactura->getDetalles($k->numero_factura, $k->nombre_cliente, $k->fecha) as $kk) {
                    $invoice .= "<tr> <td>" . $sum . "</td> <td>" . $kk->nombre_concepto . "</td> <td>" . $kk->cantidad_concepto . "</td> <td>" . floatval($kk->precio_concepto) . "</td> <td>" . floatval($kk->precio_concepto * $kk->cantidad_concepto) . "</td> </tr>";
                    $sum++;
                    $total += floatval($kk->precio_concepto * $kk->cantidad_concepto);
                }
                $invoice .= "</tbody><tfoot><tr><th colspan='4'>Total</th><th>$ " . $total . "</th></tr></tfoot></table> <br> <button type='button' class='btn btn-success'>PDF</button></div></div></div>";
            }
        } else {
            $invoice .= "<h2>No Hay Registros</h2>";
        }

        echo $invoice .= "</div>";
    }

}

?>