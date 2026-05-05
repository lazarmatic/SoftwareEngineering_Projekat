<?php
require_once 'baseDao.php';


class userDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct("user");
    }

    public function getUserByID($id)
    {
        $stmt = $this->connection->prepare("SELECT * FROM user WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }
    public function getUserByEmail($email)
    {
        $stmt = $this->connection->prepare("SELECT * FROM user WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch();
    }
}
