<?php
require_once 'dao/userDao.php';
require_once 'dao/bookDao.php';
require_once 'dao/reviewDao.php';
require_once 'dao/bookStoreDao.php';
require_once 'dao/bookRentalDao.php';


$userDao = new userDao();
$bookDao = new bookDao();
$reviewDao = new reviewDao();
$bookStoreDao = new bookStoreDao();
$bookRentalDao = new bookRentalDao();

print_r($bookDao->getByBookAuthor('LazarMatic'));

//$userDao->delete(5);

// $userDao->update(5, [
//     'username' => 'dariopecelj',
//     'full_name' => 'Dario Pecelj',
//     'email' => 'darionew@gmail.com',
//     'phone' => '23423423',
//     'passw' => 'asdasd',
//     'role' => 'User',
// ]);
 
// $userDao->insert([
//     'username' => 'dariopecelj',
//     'full_name' => 'Dario Pecelj',
//     'email' => 'dario@gmail.com',
//     'phone' => '23423423',
//     'passw' => 'asdasd',
//     'role' => 'User',
// ]);


//print_r($reviewDao->getReviewByBookId(9));

// $reviewDao->delete(5);

// $reviewDao->update(5, [
//     'user_id' => 11,
//     'book_id' => 9,
//     'review_text' => 'Review text that is a little longer',
//     'review_date' => date('Y-m-d H:i:s')
// ]);

// $reviewDao->insert([
//     'user_id' => 11,
//     'book_id' => 9,
//     'review_text' => 'Review text',
//     'review_date' => date('Y-m-d H:i:s')
// ]);

//print_r($bookStoreDao->getPurchaseByBookId(11));

//$bookStoreDao->delete(6);

// $bookStoreDao->update(
//     6,
//     [
//         'user_id' => 11,
//         'book_id' => 11,
//         'purchase_date' => date('Y-m-d H:i:s'),
//         'quantity' => 5,
//         'total_price' => 40.99
//     ]
// );

// $bookStoreDao->insert(
//     [
//         'user_id' => 7,
//         'book_id' => 7,
//         'purchase_date' => date('Y-m-d H:i:s'),
//         'quantity' => 5,
//         'total_price' => 40.99
//     ]
// );



// print_r($bookRentalDao->getRentalByBookId(11));

// $bookRentalDao->delete(14);

// $bookRentalDao->update(
//     15,
//     [
//         'user_id' => 11,
//         'book_id' => 11,
//         'rental_date' => date('Y-m-d H:i:s'),
//         'return_date' => date('Y-m-d H:i:s'),
//         'status' => 'Returned'
//     ]
// );

// $bookRentalDao->insert(
//     [
//         'user_id' => 7,
//         'book_id' => 7,
//         'rental_date' => date('Y-m-d H:i:s'),
//         'return_date' => date('Y-m-d H:i:s'),
//         'status' => 'Returned'
//     ]
// );

// print_r($bookDao->getByBookID(22));
// $bookDao->delete(23);
// $bookDao->insert(
//     [
//         'title' => 'nnnnnnajnovija',
//         'author' => 'Lazar Matic',
//         'rent_price' => 5.99,
//         'buy_price' => 12.99,
//         'description_short' => 'short description',
//         'description_long' => 'long description',
//         'stock_quantity' => 4,
//         'available_for_rent' => 1,
//         'available_for_purchase' => 0
//     ]
// );
// $bookDao->update(
//     11,
//     [
//         'title' => 'najnovija',
//         'author' => 'Lazar Matic',
//         'rent_price' => 5.99,
//         'buy_price' => 12.99,
//         'description_short' => 'short description',
//         'description_long' => 'long description',
//         'stock_quantity' => 4,
//         'available_for_rent' => 1,
//         'available_for_purchase' => 0
//     ]
// );