<?php

    class Palpite
    {
        public static function save($params)
        {
            $palpites = json_decode(file_get_contents(PATH_DATA. "palpites/{$params->token}.json"));

            foreach($palpites as &$palpite){
                if($palpite->idJogo == $params->idJogo){
                    if(isset($params->placarMandante)){
                        $palpite->placarMandante = $params->placarMandante;
                    }
                    if(isset($params->placarVisitante)){
                        $palpite->placarVisitante = $params->placarVisitante;
                    }
                }
            }

            file_put_contents(PATH_DATA. "palpites/{$params->token}.json", json_encode($palpites));
        }
    }

?>