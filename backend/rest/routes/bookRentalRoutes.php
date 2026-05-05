<?php

/**
 * @OA\Get(
 *     path="/bookRentalsByID/{id}",
 *     tags={"bookRentals"},
 *     summary="Get bookRental by id",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="id of the bookRental",
 *         @OA\Schema(type="string", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Returns the bookRental with the given id"
 *     )
 * )
 */
Flight::route('GET /bookRentalsByID/@id', function ($bookRental_id) {
    Flight::auth_middleware();
    Flight::authorize_role(Roles::ADMIN);
    //$bookRental_id = Flight::request()->query['bookRental_id'] ?? null;
    Flight::json(Flight::bookRentalService()->getByRentalID($bookRental_id));
});
/**
 * @OA\Get(
 *     path="/bookRentalsByUser/{user_id}",
 *     tags={"bookRentals"},
 *     summary="Get book rentals by user ID",
 *     @OA\Parameter(
 *         name="user_id",
 *         in="path",
 *         required=true,
 *         description="ID of the user",
 *         @OA\Schema(type="integer", example=7)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Returns rentals made by a specific user"
 *     )
 * )
 */

Flight::route('GET /bookRentalsByUser/@user_id', function ($user_id) {
    Flight::auth_middleware();
    Flight::authorize_role(Roles::ADMIN);
    //$user_id = Flight::request()->query['user_id'] ?? null;
    Flight::json(Flight::bookRentalService()->getRentalByUserId($user_id));
});


/**
 * @OA\Get(
 *     path="/bookRentalsByBook/{book_id}",
 *     tags={"bookRentals"},
 *     summary="Get book rentals by book ID",
 *     @OA\Parameter(
 *         name="book_id",
 *         in="path",
 *         required=true,
 *         description="ID of the book",
 *         @OA\Schema(type="integer", example=7)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Returns rentals for a specific book"
 *     )
 * )
 */

Flight::route('GET /bookRentalsByBook/@book_id', function ($book_id) {
    Flight::auth_middleware();
    Flight::authorize_role(Roles::ADMIN);
    //$book_id = Flight::request()->query['book_id'] ?? null;
    Flight::json(Flight::bookRentalService()->getRentalByBookId($book_id));
});


/**
 * @OA\Get(
 *     path="/bookRentals",
 *     tags={"bookRentals"},
 *     summary="Get all book rentals",
 *     @OA\Response(
 *         response=200,
 *         description="Returns all book rentals"
 *     )
 * )
 */

Flight::route('GET /bookRentals', function () {
    Flight::auth_middleware();
    //Flight::authorize_role([Roles::USER, Roles::ADMIN]);
    Flight::json(Flight::bookRentalService()->getAll());
});


/**
 * @OA\Post(
 *     path="/bookRentals",
 *     tags={"bookRentals"},
 *     summary="Add a new book rental",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"user_id", "book_id", "rental_date", "return_date", "status"},
 *             @OA\Property(property="user_id", type="integer", example=7),
 *             @OA\Property(property="book_id", type="integer", example=7),
 *             @OA\Property(property="rental_date", type="string", format="date", example="2025-04-17"),
 *             @OA\Property(property="return_date", type="string", format="date", example="2025-05-01"),
 *             @OA\Property(property="status", type="string", enum={"Rented", "Returned"}, example="Rented")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="New book rental created"
 *     )
 * )
 */
Flight::route('POST /bookRentals', function () {
    Flight::auth_middleware();
    //Flight::authorize_role([Roles::USER, Roles::ADMIN]);
    $data = Flight::request()->data->getData();
    Flight::json(Flight::bookRentalService()->create($data));
});



/**
 * @OA\Put(
 *     path="/bookRentals/{id}",
 *     tags={"bookRentals"},
 *     summary="Update a book rental by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the book rental",
 *         @OA\Schema(type="integer", example=11)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"user_id", "book_id", "rental_date", "return_date", "status"},
 *             @OA\Property(property="user_id", type="integer", example=7),
 *             @OA\Property(property="book_id", type="integer", example=7),
 *             @OA\Property(property="rental_date", type="string", format="date", example="2025-04-16"),
 *             @OA\Property(property="return_date", type="string", format="date", example="2025-04-30"),
 *             @OA\Property(property="status", type="string", enum={"Rented", "Returned"}, example="Returned")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Book rental updated"
 *     )
 * )
 */
Flight::route('PUT /bookRentals/@id', function ($id) {
    Flight::auth_middleware();
    Flight::authorize_role(Roles::ADMIN);
    $data = Flight::request()->data->getData();
    Flight::json(Flight::bookRentalService()->update($id, $data));
});

/**
 * @OA\Delete(
 *     path="/bookRentals/{id}",
 *     tags={"bookRentals"},
 *     summary="Delete a book rental by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the book rental",
 *         @OA\Schema(type="integer", example=13)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Book rental deleted"
 *     )
 * )
 */
Flight::route('DELETE /bookRentals/@id', function ($id) {
    Flight::auth_middleware();
    Flight::authorize_role(Roles::ADMIN);
    Flight::json(Flight::bookRentalService()->delete($id));
});
