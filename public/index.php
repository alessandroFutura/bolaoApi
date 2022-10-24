<?php

    include "../config/start.php";

    GLOBAL $get, $post;

    switch($_GET["action"]){

        case "getJogo":

            Json::get(Jogo::get($_GET["idJogo"]));

        break;

        case "getPessoa":

            Json::get(Pessoa::get(
                $_GET["idPessoa"],
                @$_GET["chaveAcesso"] ? @$_GET["chaveAcesso"] : NULL
            ));

        break;

        case "getPessoas":

            Json::get(Pessoa::getList(@$_GET["chaveAcesso"] ? @$_GET["chaveAcesso"] : NULL));

        break;

        case "getCalendario":

            Json::get(Calendario::get());

        break;

    }

?>