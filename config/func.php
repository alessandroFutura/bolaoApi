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

    function result($chaveAcesso)
    {
        GLOBAL $resultados;

        $pontuacao = json_decode(file_get_contents(PATH_DATA. "pontuacao.json"));

        $ret = (Object)[
            "pontos" => 0,
            "acertos" => 0,
            "palpites" => json_decode(file_get_contents(PATH_DATA. "palpites/{$chaveAcesso}.json"))
        ];

        foreach($ret->palpites as $palpite){

            $resultado = $resultados[$palpite->idJogo];

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
                    $palpite->qtPontuacao = $pontuacao[0]->qtPontuacao;
                    $palpite->dsPontuacao = $pontuacao[0]->dsPontuacao;
                }
                // ACERTO DO ESCORE DO TIME VENCEDOR
                else if(
                    (
                        $palpite->placarMandante > $resultado->placarVisitante &&
                        $palpite->placarMandante == $resultado->placarMandante
                    )
                    ||
                    (
                        $palpite->placarVisitante > $resultado->placarMandante &&
                        $palpite->placarVisitante == $resultado->placarVisitante
                    )
                ){
                    $palpite->qtPontuacao = $pontuacao[1]->qtPontuacao;
                    $palpite->dsPontuacao = $pontuacao[1]->dsPontuacao;
                }
                // ACERTO DA DIFERENÇA DE GOLS ENTRE O VENCEDOR E O PERDEDOR
                else if(
                    abs($palpite->placarMandante - $palpite->placarVisitante)
                    ==
                    abs($resultado->placarMandante - $resultado->placarVisitante)
                ){
                    $palpite->qtPontuacao = $pontuacao[2]->qtPontuacao;
                    $palpite->dsPontuacao = $pontuacao[2]->dsPontuacao;
                }
                // ACERTO DO EMPATE NÃO EXATO
                else if(
                    $palpite->placarMandante == $palpite->placarVisitante &&
                    $resultado->placarMandante == $resultado->placarVisitante
                ){
                    $palpite->qtPontuacao = $pontuacao[3]->qtPontuacao;
                    $palpite->dsPontuacao = $pontuacao[3]->dsPontuacao;
                }
                // ACERTO DO ESCORE DO TIME PERDEDOR
                else if(
                    (
                        $resultado->placarMandante > $resultado->placarVisitante &&
                        $palpite->placarVisitante == $resultado->placarVisitante
                    )
                    ||
                    (
                        $resultado->placarVisitante > $resultado->placarMandante &&
                        $palpite->placarMandante == $resultado->placarMandante
                    )
                ){
                    $palpite->qtPontuacao = $pontuacao[4]->qtPontuacao;
                    $palpite->dsPontuacao = $pontuacao[4]->dsPontuacao;
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
                    $palpite->qtPontuacao = $pontuacao[5]->qtPontuacao;
                    $palpite->dsPontuacao = $pontuacao[5]->dsPontuacao;
                }
                else {
                    $palpite->qtPontuacao = $pontuacao[6]->qtPontuacao;
                    $palpite->dsPontuacao = $pontuacao[6]->dsPontuacao;
                }
                $ret->pontos += $palpite->qtPontuacao;
            }
        }

        return $ret;
    }

?>