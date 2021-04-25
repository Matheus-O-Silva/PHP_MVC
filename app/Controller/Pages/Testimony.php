<?php

namespace App\Controller\Pages;

use App\Utils\View;

class Testimony extends Page
{

    /**
    * Método responsável por retornar o conteúdo (view) de depoimentos
    * @return string
    */
    public static function getTestimonies()
    {
        
        //RETORNA A VIEW DE DEPOIMENTOS
        $content = View::render('pages/testimonies', [
         
        ]);
        
        //RETORNA A VIEW DA PÁGINA
        return parent::getPage('DEPOIMENTOS', $content);
        
    }

    /**
         * Método responsável por cadastrar um depoimento
         * @param Request $request
         * @return string
         */
        public static function insertTestimony($request)
        {
            //DADOS RECEBIDOS VIA POST
            $postVars= $request->getPostVars();

            echo '<pre>';
            print_r($postVars);
            echo '</pre>';
            exit;

            return self::getTestimonies();
            
        }

}



?>