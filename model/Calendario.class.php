<?php

    Class Calendario
    {
        public static function get()
        {
            GLOBAL $cupDate, $resultados;

            $calendario = json_decode(file_get_contents(PATH_DATA. "calendario.json"));

            foreach($calendario as $day){
                foreach($day->jogos as $jogo){
                    $jogo->imagemMandante = getImage((Object)[
                        "image_id" => $jogo->timeMandante,
                        "image_dir" => "flags"
                    ]);
                    $jogo->imagemVisitante = getImage((Object)[
                        "image_id" => $jogo->timeVisitante,
                        "image_dir" => "flags"
                    ]);
                    $jogo->placarMandante = $resultados[$jogo->idJogo]->placarMandante;
                    $jogo->placarVisitante = $resultados[$jogo->idJogo]->placarVisitante;
                    $jogo->habilitado = (int)date("Ymd") >= (int)$cupDate->format("Ymd");
                }
            }

            return $calendario;
        }
    }

?>