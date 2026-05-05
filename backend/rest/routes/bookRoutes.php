<?php

/**
 * @OA\Get(
 *     path="/booksByID/{id}",
 *     tags={"books"},
 *     summary="Get book by id",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="id of the book",
 *         @OA\Schema(type="string", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Returns the book with the given id"
 *     )
 * )
 */
Flight::route('GET /booksbyID/@id', function ($book_id) {
    Flight::auth_middleware();
    //$book_id = Flight::request()->query['book_id'] ?? null;
    Flight::json(Flight::bookService()->getByID($book_id));
});

/**
 * @OA\Get(
 *     path="/booksByAuthor/{author}",
 *     tags={"books"},
 *     summary="Get book by author",
 *     @OA\Parameter(
 *         name="author",
 *         in="path",
 *         required=true,
 *         description="author of the book",
 *         @OA\Schema(type="string", example="George Orwell")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Returns the book with the given author"
 *     )
 * )
 */
Flight::route('GET /booksByAuthor/@author', function ($book_author) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    $book_author = Flight::request()->query['book_author'] ?? null;
    Flight::json(Flight::bookService()->getByBookAuthor($book_author));
});

/**
 * @OA\Get(
 *     path="/books",
 *     tags={"books"},
 *     summary="Get all books",
 *     @OA\Response(
 *         response=200,
 *         description="Returns all books"
 *     )
 * )
 */
Flight::route('GET /books', function () {
    Flight::auth_middleware();
    Flight::json(Flight::bookService()->getAll());
});

/**
 * @OA\Post(
 *     path="/books",
 *     tags={"books"},
 *     summary="Add a new book",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"title", "author","rent_price","buy_price","description_short","description_long","stock_quantity","available_for_rent","available_for_purchase"},
 *             @OA\Property(property="title", type="string", example="Moby Dick"),
 *             @OA\Property(property="author", type="string", example="LazarMatic"),
 *             @OA\Property(property="rent_price", type="double", example="5.99"),
 *             @OA\Property(property="buy_price", type="double", example="25.99"),
 *             @OA\Property(property="description_short", type="string", example="shortDescription"),
 *             @OA\Property(property="description_long", type="string", example="longdescription"),
 *             @OA\Property(property="stock_quantity", type="integer", example="20"),
 *             @OA\Property(property="available_for_rent", type="boolean", example="1"),
 *             @OA\Property(property="available_for_purchase", type="boolean", example="0")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="New book created"
 *     )
 * )
 */
Flight::route('POST /books', function () {
    Flight::auth_middleware();
    Flight::authorize_role(Roles::ADMIN);
    $data = Flight::request()->data->getData();
    Flight::json(Flight::bookService()->create($data));
});

/**
 * @OA\Put(
 *     path="/books/{id}",
 *     tags={"books"},
 *     summary="Update an existing book by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="book ID",
 *         @OA\Schema(type="integer", example=7)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"title", "author","rent_price","buy_price","description_short","description_long","stock_quantity","available_for_rent","available_for_purchase"},
 *             @OA\Property(property="title", type="string", example="Moby Dick"),
 *             @OA\Property(property="author", type="string", example="LazarMatic"),
 *             @OA\Property(property="rent_price", type="double", example="5.99"),
 *             @OA\Property(property="buy_price", type="double", example="25.99"),
 *             @OA\Property(property="description_short", type="string", example="shortDescription"),
 *             @OA\Property(property="description_long", type="string", example="longdescription"),
 *             @OA\Property(property="stock_quantity", type="integer", example="20"),
 *             @OA\Property(property="available_for_rent", type="boolean", example="1"),
 *             @OA\Property(property="available_for_purchase", type="boolean", example="0")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="book updated"
 *     )
 * )
 */
Flight::route('PUT /books/@id', function ($id) {
    Flight::auth_middleware();
    Flight::authorize_role(Roles::ADMIN);
    $data = Flight::request()->data->getData();
    Flight::json(Flight::bookService()->update($id, $data));
});

/**
 * @OA\Delete(
 *     path="/books/{id}",
 *     tags={"books"},
 *     summary="Delete a book by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="book ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="book deleted"
 *     )
 * )
 */
Flight::route('DELETE /books/@id', function ($id) {
    Flight::auth_middleware();
    Flight::authorize_role(Roles::ADMIN);
    Flight::json(Flight::bookService()->delete($id));
});
