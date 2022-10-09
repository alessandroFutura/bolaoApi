<?php

    include "../../config/start.php";

    $calendario = Calendario::getList();
    $pessoas = Pessoa::getList();

    Json::get((Object)[
        "pessoas" => $pessoas,
        "calendario" => $calendario
    ]);

?>