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
    function($request)
    {
        return new Response(200,Admin\Login::getLogin($request));
    }
]);


?>