<?php

use \App\Http\Response;
use \App\Controller\Admin;

//ROTA ADMIN
$obRouter->GET('/admin',[
    'middlwares' => [
        'required-admin-login'
    ],
    function($request)
    {
        return new Response(200,Admin\Home::getHome($request));
    }
]);

?>