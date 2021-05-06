<?php

namespace App\Controller\Api;

class Testimony extends Api
{
    /**
     * Método responsável por retornar os depoimentos cadastrados
     * @param Request $_REQUEST
     * @return array
     */
    public static function getTestimonies($request)
    {
        return [
            'depoimentos'   => [],
            'paginacao'     => []
        ];
    }
}

?>