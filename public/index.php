<?php

    include "../config/start.php";

    GLOBAL $get, $post;

    switch($_GET["action"]){

        case "getJogo":

            Json::get(Jogo::get($_GET["idJogo"]));

        break;

        case "getPessoa":

            Json::get(Pessoa::get($_GET["idPessoa"]));

        break;

        case "getPessoas":

            Json::get(Pessoa::getList());

            break;

        case "getCalendario":

            Json::get(Calendario::get());

        break;

    }

?>