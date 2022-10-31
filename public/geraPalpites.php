<?php

    include "../config/start.php";

    $pessoas = json_decode(file_get_contents(PATH_DATA. "pessoas.json"));
    foreach($pessoas as $pessoa){
        $palpites = json_decode(file_get_contents(PATH_DATA. "palpites/{$pessoa->token}.json"));
        foreach($palpites as $key => $palpite){
            $palpite->placarMandante = rand(0,3);
            $palpite->placarVisitante = rand(0,3);
        }
        file_put_contents(PATH_DATA. "palpites/{$pessoa->token}.json", json_encode($palpites));
    }

?>