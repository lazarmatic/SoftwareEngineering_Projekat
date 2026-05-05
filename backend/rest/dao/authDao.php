<?php
require_once __DIR__ . '/baseDao.php';
//require_once 'C:\xampp\htdocs\webprojekat\backend\rest\dao\baseDao.php';


class AuthDao extends BaseDao
{
    protected $table_name;


    public function __construct()
    {
        $this->table_name = "user";
        parent::__construct($this->table_name);
    }


    public function get_user_by_username($username)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE username = :username";
        return $this->query_unique($query, ['username' => $username]);
    }

    public function get_user_by_email($email)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = :email";
        return $this->query_unique($query, ['email' => $email]);
    }
}
