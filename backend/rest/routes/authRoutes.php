<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

Flight::group('/auth', function () {
    /**
     * @OA\Post(
     *     path="/auth/register",
     *     summary="Register new user.",
     *     description="Add a new user to the database.",
     *     tags={"auth"},
     *     security={
     *         {"ApiKey": {}}
     *     },
     *     @OA\RequestBody(
     *         description="Add new user",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"username", "full_name","email","phone","passw","role"},
     *             @OA\Property(property="username", type="string", example="username2"),
     *             @OA\Property(property="full_name", type="string", example="User Name"),
     *             @OA\Property(property="email", type="string", example="usernamee52@gmail.com"),
     *             @OA\Property(property="phone", type="string", example="066111222"),
     *             @OA\Property(property="passw", type="string", example="userpassw123"),
     *             @OA\Property(property="role", type="string", example="User")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User has been added."
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error."
     *     )
     * )
     */
    Flight::route("POST /register", function () {
        $data = Flight::request()->data->getData();


        $response = Flight::authService()->register($data);

        if ($response['success']) {
            Flight::json([
                'message' => 'User registered successfully',
                'data' => $response['data']
            ]);
        } else {
            Flight::halt(500, $response['error']);
        }
    });
    /**
     * @OA\Post(
     *      path="/auth/login",
     *      tags={"auth"},
     *      summary="Login to system using email and password",
     *      @OA\Response(
     *           response=200,
     *           description="Student data and JWT"
     *      ),
     *      @OA\RequestBody(
     *          description="Credentials",
     *          @OA\JsonContent(
     *              required={"email","password"},
     *              @OA\Property(property="email", type="string", example="username14@gmail.com", description="Student email address"),
     *              @OA\Property(property="passw", type="string", example="userpassw123", description="Student password")
     *          )
     *      )
     * )
     */
    Flight::route('POST /login', function () {
        $data = Flight::request()->data->getData();


        $response = Flight::authService()->login($data);

        if ($response['success']) {
            Flight::json([
                'message' => 'User logged in successfully',
                'data' => $response['data']
            ]);
        } else {
            Flight::halt(500, $response['error']);
        }
    });
});
