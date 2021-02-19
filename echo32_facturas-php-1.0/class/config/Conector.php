<?php

class conector {

    public static function conectar() {
        $db = new PDO("mysql:host=localhost;dbname=factura_32", "****", "****");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    }
        
}

?>
