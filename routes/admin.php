<?php

use \App\Http\Response;
use \App\Controller\Admin;

//ROTA ADMIN
$obRouter->GET('/admin',[
    function()
    {
        return new Response(200,'Admin');
    }
]);

//ROTA LOGIN
$obRouter->GET('/admin/login',[
    'middlewares' => [
        'required-admin-logout'
    ],
    function($request)
    {
        return new Response(200,Admin\Login::getLogin($request));
    }
]);



//ROTA LOGIN (POST)
$obRouter->post('/admin/login',[
    'middlewares' => [
        'required-admin-logout'
    ],
    function($request)
    {  
        return new Response(200,Admin\Login::setLogin($request));
    }
]);


//ROTA LOGOUT
$obRouter->GET('/admin/logout',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request)
    {
        return new Response(200,Admin\Login::setLogout($request));
    }
]);


?>