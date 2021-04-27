<?php

namespace App\Http\Middleware;

class maintenance
{
    /**
     * Método responsável por executar o middleware
     * @param Request $request
     * @param Closure next
     * @return Response
     */
    public function handle($request, $next)
    {
        echo "<pre>";
        print_r($request);
        echo "</pre>";
        exit;
    }
}




?>