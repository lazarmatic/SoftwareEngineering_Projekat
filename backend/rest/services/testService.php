<?php
require_once 'bookService.php';
require_once 'bookRentalService.php';
require_once 'bookStoreService.php';
require_once 'bookReviewService.php';
require_once 'userService.php';

$book_rental_service = new bookRentalService();
$book_purchase_service = new bookStoreService();
$book_service = new bookService();
$book_review_service = new bookReviewService();
$user_service = new userService();

print_r($books_by_author = $book_service->getByBookAuthor('LazarMatic'));



//$book_delete = $book_service->delete(19);
// $book_update = $book_service->update(
//     19,
//     [
//         'title' => 'FRESHHH',
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
// $book_create = $book_service->create(
//     [
//         'title' => 'FRESHHH',
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
// $books_by_id = $book_service->getByID(9);
// $books_by_author = $book_service->getByBookAuthor('Lazar Matic');
// $books_by_title = $book_service->getByBookTitle('Moby Dick');
// print_r($books_by_id);


//$book_rental_delete = $book_rental_service->delete(17);
// $book_rental_update = $book_rental_service->update(
//     17,
//     [
//         'user_id' => 7,
//         'book_id' => 7,
//         'rental_date' => date('Y-m-d H:i:s'),
//         'return_date' => date('Y-m-d H:i:s'),
//         'status' => 'Returned'
//     ]
// );
// $book_rental_create = $book_rental_service->create(
//     [
//         'user_id' => 7,
//         'book_id' => 7,
//         'rental_date' => date('Y-m-d H:i:s'),
//         'return_date' => date('Y-m-d H:i:s'),
//         'status' => 'Rented'
//     ]
// );
// $book_rentals_by_id = $book_rental_service->getByID(11);
// $book_rentals_by_userID = $book_rental_service->getRentalByUserID(11);
// $book_rentals_by_bookID = $book_rental_service->getRentalByBookID(7);
// print_r($book_rentals_by_bookID);

//$book_purchase_delete = $book_purchase_service->delete(8);
// $book_purchase_update = $book_purchase_service->update(
//     8,
//     [
//         'user_id' => 7,
//         'book_id' => 15,
//         'purchase_date' => date('Y-m-d H:i:s'),
//         'quantity' => 5,
//         'total_price' => 45.99
//     ]
// );
// $book_purchase_create = $book_purchase_service->create(
//     [
//         'user_id' => 7,
//         'book_id' => 15,
//         'purchase_date' => date('Y-m-d H:i:s'),
//         'quantity' => 5,
//         'total_price' => 40.99
//     ]
// );
// $book_purchase_by_id = $book_purchase_service->getByID(7);
// $book_purchase_by_userID = $book_purchase_service->getPurchaseByUserID(7);
// $book_purchase_by_bookID = $book_purchase_service->getPurchaseByBookID(7);
// print_r($book_purchase_by_id);

//$book_review_delete = $book_review_service->delete(9);
// $book_review_update = $book_review_service->update(
//     9,
//     [
//         'user_id' => 11,
//         'book_id' => 9,
//         'review_text' => 'Review textci',
//         'review_date' => date('Y-m-d H:i:s')
//     ]
// );
// $book_review_create = $book_review_service->create(
//     [
//         'user_id' => 11,
//         'book_id' => 9,
//         'review_text' => 'Review text',
//         'review_date' => date('Y-m-d H:i:s')
//     ]
// );
// $book_review_by_id = $book_review_service->getByID(2);
// $book_review_by_bookID = $book_review_service->getReviewByBookID(7);
// print_r($book_review_by_id);

//$user_delete = $user_service->delete(14);
// $user_update = $user_service->update(
//     14,
//     [
//         'username' => 'dariopecelj',
//         'full_name' => 'Dario Pecelj',
//         'email' => 'dariooo11@gmail.com',
//         'phone' => '23423423',
//         'passw' => 'asdasd',
//         'role' => 'User',
//     ]
// );
// $user_create = $user_service->create(
//     [
//         'username' => 'dariopecelj',
//         'full_name' => 'Dario Pecelj',
//         'email' => 'dariooo@gmail.com',
//         'phone' => '23423423',
//         'passw' => 'asdasd',
//         'role' => 'User',
//     ]
// );

// $user_by_id = $user_service->getByID(2);
// $user_by_email = $user_service->getUserByEmail(7);
// print_r($user_by_email);
