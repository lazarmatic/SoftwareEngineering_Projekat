<?php
require_once 'baseService.php';
//require_once '../dao/bookStoreDao.php';
require_once 'C:\xampp\htdocs\webprojekat\backend\rest\dao\bookStoreDao.php';

class bookStoreService extends BaseService
{

    public function __construct()
    {
        $dao = new bookStoreDao();
        parent::__construct($dao);
    }

    public function getPurchaseByUserId($user_id)
    {
        return $this->dao->getPurchaseByUserId($user_id);
    }
    public function getPurchaseByBookId($book_id)
    {
        return $this->dao->getPurchaseByBookId($book_id);
    }
    public function getByPurchaseID($purchase_id)
    {
        return $this->dao->getByPurchaseID($purchase_id);
    }
}
