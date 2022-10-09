<?php

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");

    include "config.php";
    include "func.php";

    loadClass();

    $resultados = Resultado::getList();

?>