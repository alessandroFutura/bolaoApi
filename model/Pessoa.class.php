<?php

    Class Pessoa
    {
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
                $pessoa->palpites = $data->palpites;
            }

            usort($pessoas, function($a, $b){
                return $a->pontos < $b->pontos;
            });

            return $pessoas;
        }
    }

?>