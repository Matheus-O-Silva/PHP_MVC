<?php

namespace App\Controller\Admin;

use \App\Utils\View;
use \App\Model\Entity\User as EntityUser;
use \WilliamCosta\DatabaseManager\Pagination;

class User extends Page
{

    /**
     * Mètodo responsável por obter a renderização dos itens de usuários para a página
     * @param Request $request
     * @param Pagination $obPagination
     * @return string
     */
    private static function getUserItems($request,&$obPagination)
    {
        //USUÁRIOS
        $itens = '';

        //QUANTIDADE TOTAL DE REGISTRO
        $quantidadeTotal = EntityUser::getUsers(null,null,null,'COUNT(*) as qtd')->fetchObject()->qtd;
         
        //PÁGINA ATUAL
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;
        
        //INSTÂNCIA DE PAGINAÇÃO
        $obPagination = new Pagination($quantidadeTotal,$paginaAtual,5); 

        //RESULTADOS DA PÁGINA
        $results = EntityUser::getUsers(null,'id DESC',$obPagination->getLimit());

        //RENDERIZA O ITEM
        while($ObUser = $results->fetchObject(EntityUser::class))   
        {
            //VIEW DE USUÁRIOS
            $itens .= View::render('admin/modules/users/item',[
                'id'       => $ObUser->id,
                'nome'     => $ObUser->nome,
                'email' => $ObUser->email
            ]);
        }

        //RETORNA OS DEPOIMENTOS
        return $itens;
    }

    /**
     * Método responsável por renderizar a view de listagem de usuários
     * @param Request $_REQUEST
     * @return string
     */
    public static function getUsers($request)
    {
        //CONTEÚDO DA HOME
        $content = View::render('admin/modules/users/index', [
            'itens'      => self::getUserItems($request,$obPagination),
            'pagination' => parent::getPagination($request,$obPagination),
            'status'     => self::getStatus($request)
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent ::getPanel('Usuários > Celerus', $content, 'users');
    }


    /**
     * Método responsável por retornar a mensagem de status
     * @param Request $request
     * @return string
     */
    private static function getStatus($request)
    {
        //QUERY PARAMS
        $queryParams = $request->getQueryParams();
        
        //STATUS
        if(!isset($queryParams['status'])) return '';

        //MENSAGENS DE STATUS
        switch ($queryParams['status'])
        {
            case 'created':
                return Alert::getSuccess('Usuário criado com sucesso!');
                break;
            case 'updated':
                return Alert::getSuccess('Dados do Usuário atualizados com sucesso!');
                break;
            case 'deleted':
                return Alert::getSuccess('Usuário excluído com sucesso!');
                break;
            case 'duplicated':
                return Alert::getError('O E-mail digitado já está sendo utilizado por outro usuário.');
                break;
        }
    }

    /**
     * Método responsável por retornar o formulário de cadastro de um novo usuário
     * @param Request $request
     * @return string
     */
    public static function getNewUser($request)
    {
       //CONTEÚDO DO FORMULÁRIO
       $content = View::render('admin/modules/users/form', [
        'title'    => 'Cadastrar usuário',
        'nome'     => '',
        'email'    => '',
        'status'   => self::getStatus($request)
    ]);

        //RETORNA A PÁGINA COMPLETA
        return parent ::getPanel('Cadastrar usuário', $content, 'users');
    }

    /**
     * Método responsável por cadastrar um usuário no DB
     * @param Request $request
     * @return string
     */
    public static function setNewUser($request)
    {
       //POST VARS
       $postVars = $request->getPostVars();
       $nome  = $postVars['nome'] ?? '';
       $email = $postVars['email'] ?? '';
       $senha  = $postVars['senha'] ?? '';

       //VALIDA O E-MAIL DO USUÁRIO
       $ObUser = EntityUser::getUserByEmail($email);
       if($ObUser instanceof EntityUser)
       {
        //REDIRECIONA O USUÁRIO
        $request->getRouter()->redirect('/admin/users/new?status=duplicated');
       }

       
       echo "<pre>";
       print_r($email);
       echo "</pre>";
       exit;   

       //NOVA INSTÂNCIA DE DEPOIMENTO
       $ObTestimony = new EntityTestimony;
       $ObTestimony->nome = $postVars['nome'] ?? '';
       $ObTestimony->mensagem = $postVars['mensagem'] ?? '';
       $ObTestimony->cadastrar();

       //REDIRECIONA O USUÁRIO
       $request->getRouter()->redirect('/admin/testimonies/'.$ObTestimony->id.'/edit?status=created');
    }

    /**
     * Método responsável por retornar um formulário de edição de um depoimento
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function getEditTestimony($request,$id)
    {
        //OBTÉM O DEPOIMENTO DO BANCO DE DADOS
        $ObTestimony = EntityTestimony::getTestimonyById($id);
       
        //VALIDA A INSTÂNCIA
        if(!$ObTestimony instanceof EntityTestimony)
        {
            $request->getRouter()->redirect('/admin/testimonies');
        }

        //CONTEÚDO DO FORMULÁRIO
        $content = View::render('admin/modules/testimonies/form', [
            'title'    => 'Editar Depoimento',
            'nome'     => $ObTestimony->nome,
            'mensagem' => $ObTestimony->mensagem,
            'status'   => self::getStatus($request)
    ]);

        //RETORNA A PÁGINA COMPLETA
        return parent ::getPanel('Editar depoimento', $content, 'testimonies');
    }

    /**
     * Método responsável por retornar gravar a atualização de um depoimento
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function setEditTestimony($request,$id)
    {
        //OBTÉM O DEPOIMENTO DO BANCO DE DADOS
        $ObTestimony = EntityTestimony::getTestimonyById($id);
       
        //VALIDA A INSTÂNCIA
        if(!$ObTestimony instanceof EntityTestimony)
        {
            $request->getRouter()->redirect('/admin/testimonies');
        }

        //POST VARS
        $postVars = $request->getPostVars();

        //ATUALIZA A INSTÂNCIA
        $ObTestimony->nome = $postVars['nome'] ?? $ObTestimony->nome;
        $ObTestimony->mensagem = $postVars['mensagem'] ?? $ObTestimony->mensagem;
        $ObTestimony->atualizar();
        
        //REDIRECIONA O USUÁRIO
        $request->getRouter()->redirect('/admin/testimonies/'.$ObTestimony->id.'/edit?status=updated');
    }

    /**
     * Método responsável por retornar um formulário de exclusão de um depoimento
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function getDeleteTestimony($request,$id)
    {
        //OBTÉM O DEPOIMENTO DO BANCO DE DADOS
        $ObTestimony = EntityTestimony::getTestimonyById($id);
       
        //VALIDA A INSTÂNCIA
        if(!$ObTestimony instanceof EntityTestimony)
        {
            $request->getRouter()->redirect('/admin/testimonies');
        }

        //CONTEÚDO DO FORMULÁRIO
        $content = View::render('admin/modules/testimonies/delete', [
            'nome'     => $ObTestimony->nome,
            'mensagem' => $ObTestimony->mensagem
    ]);

        //RETORNA A PÁGINA COMPLETA
        return parent ::getPanel('Excluir depoimento', $content, 'testimonies');
    }

    /**
     * Método responsável por retornar excluir um depoimento
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function setDeleteTestimony($request,$id)
    {
        //OBTÉM O DEPOIMENTO DO BANCO DE DADOS
        $ObTestimony = EntityTestimony::getTestimonyById($id);
       
        //VALIDA A INSTÂNCIA
        if(!$ObTestimony instanceof EntityTestimony)
        {
            $request->getRouter()->redirect('/admin/testimonies');
        }

        //EXCLUI O DEPOIMENTO
        $ObTestimony->excluir();
        
        //REDIRECIONA O USUÁRIO
        $request->getRouter()->redirect('/admin/testimonies?status=deleted');
    }
}



?>