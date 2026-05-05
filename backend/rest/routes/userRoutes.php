<?php

/**
 * @OA\Get(
 *     path="/users/{id}",
 *     tags={"users"},
 *     summary="Get user by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the user",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Returns user with the given ID"
 *     )
 * )
 */
Flight::route('GET /users/@id', function ($id) {
    Flight::auth_middleware();
    Flight::authorize_role(Roles::ADMIN);
    Flight::json(Flight::userService()->getUserByID($id));
});

/**
 * @OA\Get(
 *     path="/users/{email}",
 *     tags={"users"},
 *     summary="Get user by email",
 *     @OA\Parameter(
 *         name="email",
 *         in="path",
 *         required=true,
 *         description="email of the user",
 *         @OA\Schema(type="string", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Returns the user with the given email"
 *     )
 * )
 */
Flight::route('GET /users/@email', function ($email) {
    Flight::auth_middleware();
    Flight::authorize_role(Roles::ADMIN);
    $email = Flight::request()->query['email'] ?? null;
    Flight::json(Flight::userService()->getUserByEmail($email));
});
/**
 * @OA\Get(
 *      path="/users",
 *      tags={"users"},
 *      summary="Get all users",
 *      @OA\Response(
 *           response=200,
 *           description="Array of all users in the database"
 *      )
 * )
 */
Flight::route('GET /users', function () {
    Flight::auth_middleware();
    Flight::authorize_role(Roles::ADMIN);
    Flight::json(Flight::userService()->getAll());
});

/**
 * @OA\Post(
 *     path="/users",
 *     tags={"users"},
 *     summary="Add a new user",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"username", "full_name","email","phone","passw","role"},
 *             @OA\Property(property="username", type="string", example="username2"),
 *             @OA\Property(property="full_name", type="string", example="User Name"),
 *             @OA\Property(property="email", type="string", example="username2@gmail.com"),
 *             @OA\Property(property="phone", type="string", example="066111222"),
 *             @OA\Property(property="passw", type="string", example="userpassw123"),
 *             @OA\Property(property="role", type="string", example="Admin/User")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="New user created"
 *     )
 * )
 */
Flight::route('POST /users', function () {
    Flight::auth_middleware();
    //Flight::authorize_role(Roles::ADMIN);
    $data = Flight::request()->data->getData();
    Flight::json(Flight::userService()->create($data));
});

/**
 * @OA\Put(
 *     path="/users/{id}",
 *     tags={"users"},
 *     summary="Update an existing user by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="user ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"username", "full_name","email","phone","passw","role"},
 *             @OA\Property(property="username", type="string", example="username2"),
 *             @OA\Property(property="full_name", type="string", example="User Name"),
 *             @OA\Property(property="email", type="string", example="username2@gmail.com"),
 *             @OA\Property(property="phone", type="string", example="066111222"),
 *             @OA\Property(property="passw", type="string", example="userpassw123"),
 *             @OA\Property(property="role", type="string", example="User")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="user updated"
 *     )
 * )
 */
Flight::route('PUT /users/@id', function ($id) {
    Flight::auth_middleware();
    Flight::authorize_role(Roles::ADMIN);
    $data = Flight::request()->data->getData();
    Flight::json(Flight::userService()->update($id, $data));
});

/**
 * @OA\Delete(
 *     path="/users/{id}",
 *     tags={"users"},
 *     summary="Delete a user by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="user ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="user deleted"
 *     )
 * )
 */
Flight::route('DELETE /users/@id', function ($id) {
    Flight::auth_middleware();
    Flight::authorize_role(Roles::ADMIN);
    Flight::json(Flight::userService()->delete($id));
});
