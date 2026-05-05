<?php
require_once 'baseService.php';
//require_once '../dao/userDao.php';
require_once 'C:\xampp\htdocs\webprojekat\backend\rest\dao\userDao.php';

class userService extends BaseService
{

    public function __construct()
    {
        $dao = new userDao();
        parent::__construct($dao);
    }

    public function getUserByID($id)
    {
        return $this->dao->getUserByID($id);
    }
    public function getUserByEmail($email)
    {
        return $this->dao->getUserByEmail($email);
    }
}
