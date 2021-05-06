<?php

namespace App\Controller\Api;

class Api
{
    /**
     * Método responsável por retornar os detalhes da API
     * @param Request $_REQUEST
     * @return array
     */
    public static function getDetails($request)
    {
        return [
            'nome'   => 'API - WDEV',
            'versao' => 'v1.0.0',
            'autor'  => 'Matheus de Oliveira',
            'email'  => 'matheus@celerus.com'
        ];
    }
}

?>