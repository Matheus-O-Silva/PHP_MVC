<?php

require __DIR__ .'/vendor/autoload.php';

use \App\Http\Router;
use \App\Utils\View;
use  \WilliamCosta\DotEnv\Environment;

//CARREGA VARIÁVEIS DE AMBIENTE
Environment::load(__DIR__);

//DEFINE A CONSTANTE DE IRL DO PROJETO
define('URL', getenv('URL'));

//DEFINE O VALOR PADR]AP DAS VARIÁVEIS
View::init([
    'URL' => URL
]);

//INICIA O ROUTER
$obRouter = new Router(URL);

//INCLUI AS ROTAS DE PÁGINAS
include __DIR__.'/routes/pages.php';

//IMPRIME O RESPONSE DA ROTA
$obRouter->run()
         ->sendResponse();
?>