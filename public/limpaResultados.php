<?php

    include "../config/start.php";

    $resultados = json_decode(file_get_contents(PATH_DATA. "resultados.json"));
    foreach($resultados as $key => $resultado){
        $resultado->placarMandante = NULL;
        $resultado->placarVisitante = NULL;
    }
    file_put_contents(PATH_DATA. "resultados.json", json_encode($resultados));

?>