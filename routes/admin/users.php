<?php

use \App\Http\Response;
use \App\Controller\Admin;

//ROTA DE LISTAGEM DE USUÁRIOS
$obRouter->GET('/admin/users',[
    'middlwares' => [
        'required-admin-login'
    ],
    function($request)
    {
        return new Response(200,Admin\User::getUsers($request));
    }
]);

//ROTA DE CADASTRO DE UM NOVO USUÁRIO
$obRouter->GET('/admin/users/new',[
    'middlwares' => [
        'required-admin-login'
    ],
    function($request)
    {
        return new Response(200,Admin\User::getNewUser($request));
    }
]);

//ROTA DE CADASTRO DE UM NOVO USUÁRIO (POST)
$obRouter->post('/admin/users/new',[
    'middlwares' => [
        'required-admin-login'
    ],
    function($request)
    {
        return new Response(200,Admin\User::setNewUser($request));
    }
]);

//ROTA DE EDIÇÃO DE UM USUÁRIO
$obRouter->GET('/admin/users/{id}/edit',[
    'middlwares' => [
        'required-admin-login'
    ],
    function($request,$id)
    {
        return new Response(200,Admin\Testimony::getEditTestimony($request,$id));
    }
]);

//ROTA DE EDIÇÃO DE UM USUÁRIO (POST)
$obRouter->post('/admin/users/{id}/edit',[
    'middlwares' => [
        'required-admin-login'
    ],
    function($request,$id)
    {
        return new Response(200,Admin\Testimony::setEditTestimony($request,$id));
    }
]);

//ROTA DE EXCLUSÃO DE UM USUÁRIO
$obRouter->GET('/admin/users/{id}/delete',[
    'middlwares' => [
        'required-admin-login'
    ],
    function($request,$id)
    {
        return new Response(200,Admin\Testimony::getDeleteTestimony($request,$id));
    }
]);

//ROTA DE EXCLUSÃO DE UM USUÁRIO (POST)
$obRouter->post('/admin/users/{id}/delete',[
    'middlwares' => [
        'required-admin-login'
    ],
    function($request,$id)
    {
        return new Response(200,Admin\Testimony::setDeleteTestimony($request,$id));
    }
]);




?>