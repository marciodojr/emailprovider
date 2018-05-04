<?php

namespace IntecPhp\Controller;


use IntecPhp\Model\ResponseHandler;

class VueController
{

    public static function getData()
    {


        $trips = [];

        for($i = 0; $i < 30; $i++) {
            $trips[] = [
                'id' => $i,
                'imgSrc' => '/img/portfolio/escape-preview.png',
                'imgAlt' => 'Uma viagem ' . $i,
                'title' => 'Uma viagem feliz! ' . $i,
                'comment' => 'Este é o texto de comentário da imagem escape bla bla bla...' . $i
            ];
        }

        $rp = new ResponseHandler(200, 'Dados blalldlad', $trips);

        return $rp->printJson();
    }

}
