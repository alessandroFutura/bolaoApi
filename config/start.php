<?php

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");

    include "config.php";
    include "func.php";

    loadClass();

    $resultados = Resultado::getList();
    $cupDate = new DateTime(DATA_INICIO_COPA);

?>