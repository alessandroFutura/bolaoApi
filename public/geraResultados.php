<?php

    include "../config/start.php";

    $limite = 48;

    $resultados = json_decode(file_get_contents(PATH_DATA. "resultados.json"));
    foreach($resultados as $key => $resultado){
        if($key+1 <= $limite){
            $resultado->placarMandante = rand(0,3);
            $resultado->placarVisitante = rand(0,3);
        }
    }
    file_put_contents(PATH_DATA. "resultados.json", json_encode($resultados));

?>