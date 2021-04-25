<?php

use \App\Http\Response;
use \App\Controller\Pages;

//ROTA HOME
$obRouter->GET('/',[
    function()
    {
        return new Response(200,Pages\Home::getHome());
    }
]);

//ROTA SOBRE
$obRouter->GET('/sobre',[
    function()
    {
        return new Response(200,Pages\About::getAbout());
    }
]);

//ROTA DE DEPOIMENTOS
$obRouter->GET('/depoimentos',[
    function()
    {
        return new Response(200,Pages\Testimony::getTestimonies());
    }
]);

?>