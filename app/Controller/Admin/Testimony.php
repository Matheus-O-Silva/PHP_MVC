<?php

namespace App\Controller\Admin;

use \App\Utils\View;
use \App\Model\Entity\Testimony as EntityTestimony;
use \WilliamCosta\DatabaseManager\Pagination;

class Testimony extends Page
{

    private static function getTestimonyItems($request,&$obPagination)
    {
        //DEPOIMENTOS
        $itens = '';

        //QUANTIDADE TOTAL DE REGISTRO
        $quantidadeTotal = EntityTestimony::getTestimonies(null,null,null,'COUNT(*) as qtd')->fetchObject()->qtd;

        //PÁGINA ATUAL
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;
        
        //INSTÂNCIA DE PAGINAÇÃO
        $obPagination = new Pagination($quantidadeTotal,$paginaAtual,5); 

        //RESULTADOS DA PÁGINA
        $results = EntityTestimony::getTestimonies(null,'id DESC',$obPagination->getLimit());

        //RENDERIZA O ITEM
        while($ObTestimony = $results->fetchObject(EntityTestimony::class))   
        {
            //VIEW DE DEPOIMENTOS
            $itens .= View::render('admin/modules/testimonies/item',[
                'id'       => $ObTestimony->id,
                'nome'     => $ObTestimony->nome,
                'mensagem' => $ObTestimony->mensagem,
                'data'     => date('d/m/Y H:i:s', strtotime($ObTestimony->data))
            ]);
        }

        //RETORNA OS DEPOIMENTOS
        return $itens;
    }

    /**
     * Método responsável por renderizar a view de listagem de depoimentos
     * @param Request $_REQUEST
     * @return string
     */
    public static function getTestimonies($request)
    {
        //CONTEÚDO DA HOME
        $content = View::render('admin/modules/testimonies/index', [
            'itens'      => self::getTestimonyItems($request,$obPagination),
            'pagination' => parent::getPagination($request,$obPagination)
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent ::getPanel('Depoimentos > Celerus', $content, 'testimonies');
    }

    /**
     * Método responsável por retornar o formulário de cadastro de um novo depoimento
     * @param Request $request
     * @return string
     */
    public static function getNewTestimony($request)
    {
       //CONTEÚDO DO FORMULÁRIO
       $content = View::render('admin/modules/testimonies/form', [
        'title' => 'Cadastrar Depoimento'
    ]);

        //RETORNA A PÁGINA COMPLETA
        return parent ::getPanel('Cadastrar depoimento', $content, 'testimonies');
    }

    /**
     * Método responsável por cadastrar um depoimento no DB
     * @param Request $request
     * @return string
     */
    public static function setNewTestimony($request)
    {
       //POST VARS
       $postVars = $request->getPostVars();
       
       //NOVA INSTÂNCIA DE DEPOIMENTO
       $ObTestimony = new EntityTestimony;
       $ObTestimony->nome = $postVars['nome'] ?? '';
       $ObTestimony->mensagem = $postVars['mensagem'] ?? '';
       $ObTestimony->cadastrar();

       //REDIRECIONA O USUÁRIO
       $request->getRouter()->redirect('/admin/testimonies/'.$ObTestimony->id.'/edit?status=created');
    }
}



?>