<?php

    class Jogo
    {
        public static function get($idJogo)
        {
            GLOBAL $resultados;

            $pessoas = json_decode(file_get_contents(PATH_DATA. "pessoas.json"));
            $calendario = json_decode(file_get_contents(PATH_DATA. "calendario.json"));

            $ret = NULL;
            foreach($calendario as $day){
                foreach($day->jogos as $jogo){
                    if($jogo->idJogo == $idJogo){
                        $ret = $jogo;
                        $ret->imagemMandante = getImage((Object)[
                            "image_id" => $jogo->timeMandante,
                            "image_dir" => "flags"
                        ]);
                        $ret->imagemVisitante = getImage((Object)[
                            "image_id" => $jogo->timeVisitante,
                            "image_dir" => "flags"
                        ]);
                        $ret->data = $day->data;
                        $ret->placarMandante = $resultados[$jogo->idJogo]->placarMandante;
                        $ret->placarVisitante = $resultados[$jogo->idJogo]->placarVisitante;

                        $ret->pessoas = [];
                        foreach($pessoas as $pessoa){
                            $data = result($pessoa->chaveAcesso, $idJogo);
                            $ret->pessoas[] = (Object)[
                                "imagem" => getImage((Object)[
                                    "image_id" => $pessoa->idPessoa,
                                    "image_dir" => "people"
                                ]),
                                "idPessoa" => $pessoa->idPessoa,
                                "nmPessoa" => $pessoa->nmPessoa,
                                "qtPontuacao" => $data->palpites[0]->qtPontuacao,
                                "dsPontuacao" => $data->palpites[0]->dsPontuacao,
                                "corPontuacao" => $data->palpites[0]->corPontuacao,
                                "placarMandante" => $data->palpites[0]->placarMandante,
                                "placarVisitante" => $data->palpites[0]->placarVisitante
                            ];
                        }

                        usort($ret->pessoas, function($a, $b){
                            return $a->qtPontuacao == $b->qtPontuacao ? (
                                $a->nmPessoa > $b->nmPessoa
                            ) : $a->qtPontuacao < $b->qtPontuacao;
                        });
                    }
                }
            }

            return $ret;
        }
    }

?>