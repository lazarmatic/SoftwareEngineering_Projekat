<?php
require '../vendor/autoload.php'; //run autoloader

require_once './rest/services/bookService.php';
require_once './rest/services/bookRentalService.php';
require_once './rest/services/bookStoreService.php';
require_once './rest/services/bookReviewService.php';
require_once './rest/services/userService.php';
require_once './rest/services/authService.php';
require_once "./middleware/authMiddleware.php";
require_once "./data/Roles.php";





use Firebase\JWT\JWT;
use Firebase\JWT\Key;


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

Flight::register('bookService', 'bookService');
Flight::register('bookRentalService', 'bookRentalService');
Flight::register('bookStoreService', 'bookStoreService');
Flight::register('bookReviewService', 'bookReviewService');
Flight::register('userService', 'userService');
Flight::register('authService', "AuthService");
Flight::register('authMiddleware', "AuthMiddleware");


Flight::map('auth_middleware', function () {
    Flight::authMiddleware()->verifyToken(
        Flight::request()->getHeader("Authentication")
    );
});

Flight::map('authorize_role', function ($role) {
    Flight::authMiddleware()->authorizeRole($role);
});

Flight::map('authorize_roles', function ($roles) {
    Flight::authMiddleware()->authorizeRoles($roles);
});

Flight::map('authorize_permission', function ($permission) {
    Flight::authMiddleware()->authorizePermission($permission);
});


Flight::route('/*', function () {
    if (
        strpos(Flight::request()->url, '/auth/login') === 0 ||
        strpos(Flight::request()->url, '/auth/register') === 0
    ) {
        return TRUE;
    } else {
        try {
            $token = Flight::request()->getHeader("Authentication");
            if (!$token)
                Flight::halt(401, "Missing authentication header");


            $decoded_token = JWT::decode($token, new Key(Config::JWT_SECRET(), 'HS256'));


            Flight::set('user', $decoded_token->user);
            Flight::set('jwt_token', $token);
            return TRUE;
        } catch (\Exception $e) {
            Flight::halt(401, $e->getMessage());
        }
    }
});

require_once './rest/routes/authRoutes.php';
require_once './rest/routes/bookRoutes.php';
require_once './rest/routes/bookRentalRoutes.php';
require_once './rest/routes/bookStoreRoutes.php';
require_once './rest/routes/bookReviewRoutes.php';
require_once './rest/routes/userRoutes.php';


Flight::start();  //start FlightPHP
