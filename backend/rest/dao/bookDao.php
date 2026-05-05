<?php
require_once 'baseDao.php';


class bookDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct("book");
    }


    public function getByBookID($book_id)
    {
        $stmt = $this->connection->prepare("SELECT * FROM book WHERE id = :book_id");
        $stmt->bindParam(':book_id', $book_id);
        $stmt->execute();
        return $stmt->fetch();
    }
    public function getByBookAuthor($book_author)
    {
        $stmt = $this->connection->prepare("SELECT * FROM book WHERE author = :book_author");
        $stmt->bindParam(':book_author', $book_author);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function getByBookTitle($book_title)
    {
        $stmt = $this->connection->prepare("SELECT * FROM book WHERE title = :book_title");
        $stmt->bindParam(':book_title', $book_title);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
