<?php

    include "../config/start.php";



    switch($_GET["action"]){

        case "getDataCopa":

            Json::get(DATA_INICIO_COPA);

        break;

        case "getJogo":

            Json::get(Jogo::get($_GET["idJogo"]));

        break;

        case "getPessoa":

            Json::get(Pessoa::get(
                $_GET["idPessoa"],
                @$_GET["token"] ? @$_GET["token"] : NULL
            ));

        break;

        case "getPessoas":

            Json::get(Pessoa::getList(@$_GET["token"] ? @$_GET["token"] : NULL));

        break;

        case "getCalendario":

            Json::get(Calendario::get());

        break;

        case "saveResultado":

            $post = json_decode(file_get_contents("php://input"));

            Palpite::save($post);

            Json::get($post);

        break;

    }

?>