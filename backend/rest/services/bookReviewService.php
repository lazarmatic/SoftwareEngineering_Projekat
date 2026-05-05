<?php
require_once 'baseService.php';
//require_once '../dao/reviewDao.php';
require_once 'C:\xampp\htdocs\webprojekat\backend\rest\dao\reviewDao.php';

class bookReviewService extends BaseService
{

    public function __construct()
    {
        $dao = new reviewDao();
        parent::__construct($dao);
    }

    public function getReviewByBookId($book_id)
    {
        return $this->dao->getReviewByBookId($book_id);
    }
    public function getReviewsByID($id)
    {
        return $this->dao->getReviewsByID($id);
    }
}
