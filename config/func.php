<?php

    function loadClass()
    {
        spl_autoload_register(function($className){
            if(file_exists(PATH_CLASS . "{$className}.class.php")){
                require_once PATH_CLASS . "{$className}.class.php";
                return;
            }
            if(file_exists(PATH_MODEL . "{$className}.class.php")){
                require_once PATH_MODEL . "{$className}.class.php";
                return;
            }
        });
    }

    function getImage($params)
    {
        $uri = URI_FILES;
        $file = "{$params->image_dir}/{$params->image_id}";
        $path = PATH_FILES . "{$file}";

        //$rand = "?" . rand(1000,9999);
        $rand = "";
        $types = ["svg", "jpg"];

        $ret = NULL;
        foreach($types as $type){
            if(file_exists("{$path}.{$type}")){
                $ret = "{$uri}{$file}.{$type}{$rand}";
            }
        }

        return $ret;
    }

    function result($token, $idJogo=NULL)
    {
        GLOBAL $resultados;

        $pontuacao = json_decode(file_get_contents(PATH_DATA. "pontuacao.json"));

        $ret = (Object)[
            "pontos" => 0,
            "acertos" => 0,
            "palpites" => json_decode(file_get_contents(PATH_DATA. "palpites/{$token}.json"))
        ];

        if(@$idJogo){
            foreach($ret->palpites as $palpite){
                if($palpite->idJogo == $idJogo){
                    $ret->palpites = [$palpite];
                }
            }
        }

        foreach($ret->palpites as $palpite){

            $resultado = $resultados[$palpite->idJogo];
            $keyPontuacao = 6;

            if(
                !is_null($palpite->placarVisitante) &&
                !is_null($palpite->placarVisitante) &&
                !is_null($resultado->placarMandante) &&
                !is_null($resultado->placarVisitante)
            ){
                // ACERTO DO PLACAR EXATO
                if(
                    $palpite->placarMandante == $resultado->placarMandante &&
                    $palpite->placarVisitante == $resultado->placarVisitante
                ){
                    $ret->acertos ++;
                    $keyPontuacao = 0;
                }
                // ACERTO DO ESCORE DO TIME VENCEDOR
                else if(
                    (
                        $resultado->placarMandante > $resultado->placarVisitante &&
                        $palpite->placarMandante > $palpite->placarVisitante &&
                        $palpite->placarMandante == $resultado->placarMandante
                    )
                    ||
                    (
                        $resultado->placarVisitante > $resultado->placarMandante &&
                        $palpite->placarVisitante > $palpite->placarVisitante &&
                        $palpite->placarVisitante == $resultado->placarVisitante
                    )
                ){
                    $keyPontuacao = 1;
                }
                // ACERTO DO EMPATE NÃO EXATO
                else if(
                    $palpite->placarMandante == $palpite->placarVisitante &&
                    $resultado->placarMandante == $resultado->placarVisitante
                ){
                    $keyPontuacao = 2;
                }
                // ACERTO DO ESCORE DO TIME PERDEDOR
                else if(
                    (
                        $resultado->placarMandante > $resultado->placarVisitante &&
                        $palpite->placarVisitante == $resultado->placarVisitante &&
                        $palpite->placarMandante != $palpite->placarVisitante
                    )
                    ||
                    (
                        $resultado->placarVisitante > $resultado->placarMandante &&
                        $palpite->placarMandante == $resultado->placarMandante &&
                        $palpite->placarMandante != $palpite->placarVisitante
                    )
                ){
                    $keyPontuacao = 3;
                }
                // ACERTO DA DIFERENÇA DE GOLS ENTRE O VENCEDOR E O PERDEDOR
                else if(
                    $resultado->placarVisitante != $resultado->placarMandante &&
                    (
                        $palpite->placarMandante - $palpite->placarVisitante
                        ==
                        $resultado->placarMandante - $resultado->placarVisitante
                    )
                ){
                    $keyPontuacao = 4;
                }
                // ACERTO APENAS DO TIME VENCEDOR
                else if(
                    (
                        $resultado->placarMandante > $resultado->placarVisitante &&
                        $palpite->placarMandante > $palpite->placarVisitante
                    )
                    ||
                    (
                        $resultado->placarVisitante > $resultado->placarMandante &&
                        $palpite->placarVisitante > $palpite->placarMandante
                    )
                ){
                    $keyPontuacao = 5;
                }
            }

            $palpite->idPontuacao = $pontuacao[$keyPontuacao]->idPontuacao;
            $palpite->qtPontuacao = $pontuacao[$keyPontuacao]->qtPontuacao;
            $palpite->dsPontuacao = $pontuacao[$keyPontuacao]->dsPontuacao;
            $palpite->corPontuacao = $pontuacao[$keyPontuacao]->corPontuacao;
            $ret->pontos += $palpite->qtPontuacao;
        }

        return $ret;
    }

?>