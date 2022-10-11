<?php

    Class Pessoa
    {
        public static function get($idPessoa)
        {
            $pessoas = json_decode(file_get_contents(PATH_DATA. "pessoas.json"));

            $ret = NULL;

            foreach($pessoas as $pessoa){
                if($pessoa->idPessoa == $idPessoa) {
                    $ret = (Object)[];
                    $ret->imagem = getImage((Object)[
                        "image_id" => $pessoa->idPessoa,
                        "image_dir" => "people"
                    ]);
                    $ret->nmPessoa = $pessoa->nmPessoa;

                    $data = result($pessoa->chaveAcesso);
                    $calendario = Calendario::get();

                    $ret->pontos = $data->pontos;
                    $ret->acertos = $data->acertos;

                    $palpites = [];
                    foreach($data->palpites as $palpite){
                        $palpites[$palpite->idJogo] = $palpite;
                    }

                    $ret->jogos = [];
                    foreach($calendario as $dia){
                        foreach($dia->jogos as $jogo){
                            $ret->jogos[] = (Object)[
                                "data" => $dia->data,
                                "grupo" => $jogo->grupo,
                                "idJogo" => $jogo->idJogo,
                                "horario" => $jogo->horario,
                                "estadio" => $jogo->estadio,
                                "timeMandante" => $jogo->timeMandante,
                                "timeVisitante" => $jogo->timeVisitante,
                                "imagemMandante" => $jogo->imagemMandante,
                                "placarMandante" => $jogo->placarMandante,
                                "imagemVisitante" => $jogo->imagemVisitante,
                                "placarVisitante" => $jogo->placarVisitante,
                                "dsPontuacao" => $palpites[$jogo->idJogo]->dsPontuacao,
                                "qtPontuacao" => $palpites[$jogo->idJogo]->qtPontuacao,
                                "corPontuacao" => $palpites[$jogo->idJogo]->corPontuacao,
                                "palpitePlacarMandante" => $palpites[$jogo->idJogo]->placarMandante,
                                "palpitePlacarVisitante" => $palpites[$jogo->idJogo]->placarVisitante
                            ];
                        }
                    }
                }
            }

            return $ret;
        }

        public static function getList()
        {
            $pessoas = json_decode(file_get_contents(PATH_DATA. "pessoas.json"));

            foreach($pessoas as $pessoa){
                $pessoa->imagem = getImage((Object)[
                    "image_id" => $pessoa->idPessoa,
                    "image_dir" => "people"
                ]);
                $data = result($pessoa->chaveAcesso);
                $pessoa->pontos = $data->pontos;
                $pessoa->acertos = $data->acertos;
                unset($pessoa->chaveAcesso);
            }

            usort($pessoas, function($a, $b){
                return $a->pontos == $b->pontos ? (
                    $a->acertos < $b->acertos
                ) : $a->pontos < $b->pontos;
            });

            return $pessoas;
        }
    }

?>