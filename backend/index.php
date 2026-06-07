<?php
die("INDEX LOADED");
require '../vendor/autoload.php'; //run autoloader

require_once __DIR__ . '/rest/services/bookService.php';
require_once __DIR__ . '/rest/services/bookRentalService.php';
require_once __DIR__ . '/rest/services/bookStoreService.php';
require_once __DIR__ . '/rest/services/bookReviewService.php';
require_once __DIR__ . '/rest/services/userService.php';
require_once __DIR__ . '/rest/services/authService.php';
require_once __DIR__ . '/middleware/authMiddleware.php';
require_once __DIR__ . '/data/roles.php';

// Factory Pattern - Import ServiceFactory
require_once __DIR__ . '/rest/factory/ServiceFactory.php';





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

    $url = Flight::request()->url;

    if (
        $url === '/' ||
        $url === '/favicon.ico' ||
        strpos($url, '/auth/login') === 0 ||
        strpos($url, '/auth/register') === 0
    ) {
        return TRUE;
    }

    $token = Flight::request()->getHeader("Authentication");

    if (!$token) {
        Flight::halt(401, "Missing authentication header");
    }

    try {
        $decoded_token = JWT::decode(
            $token,
            new Key(Config::JWT_SECRET(), 'HS256')
        );

        Flight::set('user', $decoded_token->user);
        Flight::set('jwt_token', $token);

        return TRUE;
    } catch (\Exception $e) {
        Flight::halt(401, $e->getMessage());
    }
});
require_once './rest/routes/authRoutes.php';
require_once './rest/routes/bookRoutes.php';
require_once './rest/routes/bookRentalRoutes.php';
require_once './rest/routes/bookStoreRoutes.php';
require_once './rest/routes/bookReviewRoutes.php';
require_once './rest/routes/userRoutes.php';


Flight::start();  //start FlightPHP
