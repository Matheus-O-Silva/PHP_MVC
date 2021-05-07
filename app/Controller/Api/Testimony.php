<?php

namespace App\Controller\Api;

use \App\Model\Entity\Testimony as EntityTestimony;
use \WilliamCosta\DatabaseManager\Pagination;

class Testimony extends Api
{
    /**
     * Método responsável por obter a renderização dos itens de depoimentos para a página
     * @param Request $request
     * @param Pagination $obPagination
     * @return string
     */
    private static function getTestimonyItems($request,&$obPagination)
    {
        //DEPOIMENTOS
        $itens = [];

        //QUANTIDADE TOTAL DE REGISTRO
        $quantidadeTotal = EntityTestimony::getTestimonies(null,null,null,'COUNT(*) as qtd')->fetchObject()->qtd;
        
        //PÁGINA ATUAL
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;
        
        //INSTÂNCIA DE PAGINAÇÃO
        $obPagination = new Pagination($quantidadeTotal,$paginaAtual,3);

        //RESULTADOS DA PÁGINA
        $results = EntityTestimony::getTestimonies(null,'id DESC',$obPagination->getLimit());

        //RENDERIZA O ITEM
        while($ObTestimony = $results->fetchObject(EntityTestimony::class))
        {
            //VIEW DE DEPOIMENTOS
            $itens[] =  [
                'id'       => (int)$ObTestimony->id,
                'nome'     => $ObTestimony->nome,
                'mensagem' => $ObTestimony->mensagem,
                'data'     => $ObTestimony->data
            ];
        }

        //RETORNA OS DEPOIMENTOS
        return $itens;
    }    

    /**
     * Método responsável por retornar os depoimentos cadastrados
     * @param Request $_REQUEST
     * @return array
     */
    public static function getTestimonies($request)
    {
        return [
            'depoimentos'   => self::getTestimonyItems($request,$obPagination),
            'paginacao'     => parent::getPagination($request,$obPagination)
        ];
    }
}

?>