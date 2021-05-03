<?php

namespace App\Model\Entity;

use \WilliamCosta\DatabaseManager\Database;

class User
{
    /**
     * ID do usuário
     * @var integer
     */
    public $id;

    /**
     * Nome do usuário
     * @var string
     */
    public $nome;

    /**
     * E-mail do usuário
     * @var string
     */
    public $email;

    /**
     * Senha do usuário
     * @var string
     */
    public $senha;

    /**
     * Método responsável por retornar um usuário com base em seu e-mail
     * @var string $email
     * @return User
     */
    public static function getUserByEmail($email)
    {
        return(new Database('usuarios'))->select('email = "'.$email.'"')->fetchObject(self::class);
    }

    /**
     * Método resposável por retornar usuários
     * @param string $where
     * @param string $order
     * @param string $limit
     * @param string @field
     * @return PDOstatement
     */
    public static function getUsers($where = null, $order = null,$limit = null, $fields = '*')
    {
        return(new Database('usuarios'))->select($where,$order,$limit,$fields);
    }
}