<?php

use \App\Http\Response;
use \App\Controller\Admin;

//ROTA DE LISTAGEM DE DEPOIMENTOS
$obRouter->GET('/admin/testimonies',[
    'middlwares' => [
        'required-admin-login'
    ],
    function($request)
    {
        return new Response(200,Admin\Testimony::getTestimonies($request));
    }
]);

//ROTA DE CADASTRO DE UM NOVO DEPOIMENTO
$obRouter->GET('/admin/testimonies/new',[
    'middlwares' => [
        'required-admin-login'
    ],
    function($request)
    {
        return new Response(200,Admin\Testimony::getNewTestimony($request));
    }
]);

//ROTA DE CADASTRO DE UM NOVO DEPOIMENTO (POST)
$obRouter->post('/admin/testimonies/new',[
    'middlwares' => [
        'required-admin-login'
    ],
    function($request)
    {
        return new Response(200,Admin\Testimony::setNewTestimony($request));
    }
]);




?>