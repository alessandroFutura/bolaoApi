<?php

    class Resultado
    {
        public static function getList()
        {
            $resultados = json_decode(file_get_contents(PATH_DATA. "resultados.json"));

            $ret = [];
            foreach($resultados as $resultado){
                $ret[$resultado->idJogo] = (Object)[
                    "idJogo" => $resultado->idJogo,
                    "placarMandante" => $resultado->placarMandante,
                    "placarVisitante" => $resultado->placarVisitante
                ];
            }

            return $ret;
        }
    }

?>