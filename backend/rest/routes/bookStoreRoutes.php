<?php


/**
 * @OA\Get(
 *     path="/bookPurchasesByID/{id}",
 *     tags={"bookPurchases"},
 *     summary="Get bookPurchases by id",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="id of the bookPurchases",
 *         @OA\Schema(type="string", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Returns the bookPurchases with the given id"
 *     )
 * )
 */
Flight::route('GET /bookPurchasesByID/@id', function ($bookPurchase_id) {
    Flight::auth_middleware();
    Flight::authorize_role(Roles::ADMIN);
    //$bookPurchase_id = Flight::request()->query['bookPurchase_id'] ?? null;
    Flight::json(Flight::bookStoreService()->getByPurchaseID($bookPurchase_id));
});

/**
 * @OA\Get(
 *     path="/bookPurchasesByUser/{user_id}",
 *     tags={"bookPurchases"},
 *     summary="Get book purchases by user ID",
 *     @OA\Parameter(
 *         name="user_id",
 *         in="path",
 *         required=true,
 *         description="ID of the user",
 *         @OA\Schema(type="integer", example=7)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Returns purchases made by a specific user"
 *     )
 * )
 */
Flight::route('GET /bookPurchasesByUser/@user_id', function ($user_id) {
    Flight::auth_middleware();
    Flight::authorize_role(Roles::ADMIN);
    $user_id = Flight::request()->query['user_id'] ?? null;
    Flight::json(Flight::bookStoreService()->getPurchaseByUserId($user_id));
});

/**
 * @OA\Get(
 *     path="/bookPurchasesByBook/{book_id}",
 *     tags={"bookPurchases"},
 *     summary="Get book purchases by book ID",
 *     @OA\Parameter(
 *         name="book_id",
 *         in="path",
 *         required=true,
 *         description="ID of the book",
 *         @OA\Schema(type="integer", example=7)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Returns purchases for a specific book"
 *     )
 * )
 */
Flight::route('GET /bookPurchasesByBook/@book_id', function ($book_id) {
    Flight::auth_middleware();
    Flight::authorize_role(Roles::ADMIN);
    $book_id = Flight::request()->query['book_id'] ?? null;
    Flight::json(Flight::bookStoreService()->getPurchaseByBookId($book_id));
});

/**
 * @OA\Get(
 *     path="/bookPurchases",
 *     tags={"bookPurchases"},
 *     summary="Get all book purchases",
 *     @OA\Response(
 *         response=200,
 *         description="Returns all book purchases"
 *     )
 * )
 */
Flight::route('GET /bookPurchases', function () {
    Flight::auth_middleware();
    //Flight::authorize_role(Roles::ADMIN);
    Flight::json(Flight::bookStoreService()->getAll());
});

/**
 * @OA\Post(
 *     path="/bookPurchases",
 *     tags={"bookPurchases"},
 *     summary="Add a new book purchase",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"user_id", "book_id", "purchase_date", "quantity", "total_price"},
 *             @OA\Property(property="user_id", type="integer", example=7),
 *             @OA\Property(property="book_id", type="integer", example=7),
 *             @OA\Property(property="purchase_date", type="string", format="date", example="2025-04-17"),
 *             @OA\Property(property="quantity", type="integer", example=2),
 *             @OA\Property(property="total_price", type="number", format="double", example=49.98)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="New book purchase created"
 *     )
 * )
 */
Flight::route('POST /bookPurchases', function () {
    Flight::auth_middleware();
    //Flight::authorize_role(Roles::ADMIN);
    $data = Flight::request()->data->getData();
    Flight::json(Flight::bookStoreService()->create($data));
});

/**
 * @OA\Put(
 *     path="/bookPurchases/{id}",
 *     tags={"bookPurchases"},
 *     summary="Update a book purchase by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the book purchase",
 *         @OA\Schema(type="integer", example=7)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"user_id", "book_id", "purchase_date", "quantity", "total_price"},
 *             @OA\Property(property="user_id", type="integer", example=7),
 *             @OA\Property(property="book_id", type="integer", example=7),
 *             @OA\Property(property="purchase_date", type="string", format="date", example="2025-04-16"),
 *             @OA\Property(property="quantity", type="integer", example=1),
 *             @OA\Property(property="total_price", type="number", format="double", example=25.99)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Book purchase updated"
 *     )
 * )
 */
Flight::route('PUT /bookPurchases/@id', function ($id) {
    Flight::auth_middleware();
    Flight::authorize_role(Roles::ADMIN);
    $data = Flight::request()->data->getData();
    Flight::json(Flight::bookStoreService()->update($id, $data));
});

/**
 * @OA\Delete(
 *     path="/bookPurchases/{id}",
 *     tags={"bookPurchases"},
 *     summary="Delete a book purchase by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the book purchase",
 *         @OA\Schema(type="integer", example=9)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Book purchase deleted"
 *     )
 * )
 */
Flight::route('DELETE /bookPurchases/@id', function ($id) {
    Flight::auth_middleware();
    Flight::authorize_role(Roles::ADMIN);
    Flight::json(Flight::bookStoreService()->delete($id));
});
