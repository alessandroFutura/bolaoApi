<?php

    include "../config/start.php";

    $pessoas = json_decode(file_get_contents(PATH_DATA. "pessoas.json"));
    foreach($pessoas as $pessoa){
        $palpites = json_decode(file_get_contents(PATH_DATA. "palpites/{$pessoa->token}.json"));
        foreach($palpites as $key => $palpite){
            $palpite->placarMandante = NULL;
            $palpite->placarVisitante = NULL;
        }
        file_put_contents(PATH_DATA. "palpites/{$pessoa->token}.json", json_encode($palpites));
    }

?>