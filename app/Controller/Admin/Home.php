<?php

namespace App\Controller\Admin;

use \App\Utils\View;

class Home extends Page
{
    /**
     * Método responsável por renderizar a view de home do painel
     * @param Request $_REQUEST
     * @return string
     */
    public static function getHome()
    {
        //CONTEÚDO DA HOME
        $content = View::render('admin/modules/home/index', []);

        //RETORNA A PÁGINA COMPLETA
        return parent ::getPanel('Home > Celerus', $content, 'home');
    }
}



?>