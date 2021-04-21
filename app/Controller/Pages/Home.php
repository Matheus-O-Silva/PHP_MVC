<?php

namespace App\Controller\Pages;

//use \App\Utils\View;

class Home
{

    /**
         * Método responsável por retornar o conteúdo (view) da nossa home
         * @return string
         */
    public static function getHome()
    {
        return 'Olá, Mundo!';
        //return View::render('pages/home');
    }
}



?>