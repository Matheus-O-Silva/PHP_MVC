<?php

namespace App\Controller\Pages;

use App\Utils\View;

class Home extends Page
{

    /**
    * Método responsável por retornar o conteúdo (view) da home
    * @return string
    */
    public static function getHome()
    {
        //RETORNA A VIEW DA HOME
        $content = View::render('pages/home', [
            'name' => 'Matheus',
            'description' => 'Web Developer',

        ]);
        
        //RETORNA A VIEW DA PÁGINA
        return parent::getPage('Celerus', $content);
    }

}



?>