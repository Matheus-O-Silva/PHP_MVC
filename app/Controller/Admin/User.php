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


       //NOVA INSTÂNCIA DE USUÁRIO
       $ObUser = new EntityUser;
       $ObUser->nome = $nome;
       $ObUser->email = $email;
       $ObUser->senha = password_hash($senha,PASSWORD_DEFAULT);
       $ObUser->cadastrar();

       //REDIRECIONA O USUÁRIO
       $request->getRouter()->redirect('/admin/users/'.$ObUser->id.'/edit?status=created');
    }

    /**
     * Método responsável por retornar um formulário de edição de um usuário
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function getEditUser($request,$id)
    {
        //OBTÉM O USUÁRIO DO BANCO DE DADOS
        $ObUser = EntityUser::getUserById($id);
       
        //VALIDA A INSTÂNCIA
        if(!$ObUser instanceof EntityUser)
        {
            $request->getRouter()->redirect('/admin/users');
        }

        //CONTEÚDO DO FORMULÁRIO
        $content = View::render('admin/modules/users/form', [
            'title'    => 'Editar usuário',
            'nome'     => $ObUser->nome,
            'email' => $ObUser->email,
            'status'   => self::getStatus($request)
    ]);

        //RETORNA A PÁGINA COMPLETA
        return parent ::getPanel('Editar Usuário', $content, 'users');
    }

    /**
     * Método responsável por retornar gravar a atualização de um usuário
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function setEditUser($request,$id)
    {
        //OBTÉM O DEPOIMENTO DO BANCO DE DADOS
        $ObUser = EntityUser::getUserById($id);
       
        //VALIDA A INSTÂNCIA
        if(!$ObUser instanceof EntityUser)
        {
            $request->getRouter()->redirect('/admin/users');
        }

        //POST VARS
        $postVars = $request->getPostVars();
        $nome  = $postVars['nome'] ?? '';
        $email = $postVars['email'] ?? '';
        $senha  = $postVars['senha'] ?? '';

       //VALIDA O E-MAIL DO USUÁRIO
       $ObUserEmail = EntityUser::getUserByEmail($email);
       if($ObUserEmail instanceof EntityUser && $ObUserEmail->id != $id)
       {
        //REDIRECIONA O USUÁRIO
        $request->getRouter()->redirect('/admin/users/'.$id.'/edit?status=duplicated');
       }    

        //ATUALIZA A INSTÂNCIA
        $ObUser->nome = $nome;
        $ObUser->email = $email;
        $ObUser->senha = password_hash($senha, PASSWORD_DEFAULT);
        $ObUser->atualizar();
        
        //REDIRECIONA O USUÁRIO
        $request->getRouter()->redirect('/admin/users/'.$ObUser->id.'/edit?status=updated');
    }

    /**
     * Método responsável por retornar um formulário de exclusão de um usuário
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function getDeleteUser($request,$id)
    {
        //OBTÉM O USUÁRIO DO BANCO DE DADOS
        $ObUser = EntityUser::getUserById($id);
       
        //VALIDA A INSTÂNCIA
        if(!$ObUser instanceof EntityUser)
        {
            $request->getRouter()->redirect('/admin/users');
        }

        //CONTEÚDO DO FORMULÁRIO
        $content = View::render('admin/modules/users/delete', [
            'nome'     => $ObUser->nome,
            'email' => $ObUser->email
    ]);

        //RETORNA A PÁGINA COMPLETA
        return parent ::getPanel('Excluir usuário', $content, 'users');
    }

    /**
     * Método responsável por retornar excluir um usuário
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function setDeleteUser($request,$id)
    {
        //OBTÉM O USUÁRIO DO BANCO DE DADOS
        $ObUser = EntityUser::getUserById($id);
       
        //VALIDA A INSTÂNCIA
        if(!$ObUser instanceof EntityUser)
        {
            $request->getRouter()->redirect('/admin/users');
        }

        //EXCLUI O USUÁRIO
        $ObUser->excluir();
        
        //REDIRECIONA O USUÁRIO
        $request->getRouter()->redirect('/admin/users?status=deleted');
    }
}



?>