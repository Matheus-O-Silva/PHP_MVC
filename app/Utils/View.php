<?php

namespace App\Utils;

class View
{

    /**
     * Método responsável por retornar o conteúdo de uma view
     *  @param string $view
     *  @param string 
     */
    private static function getContentView($view)
    {
        $file = __DIR__ .'/../../resourcers/view/'.$view.'.html';
        return file_exists($file) ? file_get_contents($file) : '';
    }

    /**
     * Método responsável por retornar o conteúdo renderizado de uma view
     * @param string $view
     * @param string
     */
    public static function render($view)
    {
        //CONTEÚDO DA VIEW
        $contentView = self::getContentView($view);

        //RETORNA O COTEÚDO RENDERIZADO
        return $contentView;
    }
}


?>