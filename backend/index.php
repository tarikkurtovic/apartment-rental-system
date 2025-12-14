<?php
require 'vendor/autoload.php'; 

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/database.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require_once __DIR__ . '/services/PaymentService.php';
require_once __DIR__ . '/services/ReservationService.php';
require_once __DIR__ . '/services/RoomService.php';
require_once __DIR__ . '/services/RoomTypeService.php';
require_once __DIR__ . '/services/UserService.php';
require_once __DIR__ . '/services/AuthService.php';


Flight::register('paymentService', 'PaymentService');
Flight::register('reservationService', 'ReservationService');
Flight::register('roomService', 'RoomService');
Flight::register('roomTypeService', 'RoomTypeService');
Flight::register('userService', 'UserService');
Flight::register('auth_service', 'AuthService');



Flight::route('/*', function () {

    $url = Flight::request()->url;

    if (
        strpos($url, '/auth/login') === 0 ||
        strpos($url, '/auth/register') === 0 ||
        strpos($url, '/public/v1/docs') === 0
    ) {
        return TRUE;
    }


    try {
        $token = Flight::request()->getHeader("Authentication");

        if(!$token)
               Flight::halt(401, "Missing authentication header");

           $decoded_token = JWT::decode($token, new Key(Config::JWT_SECRET(), 'HS256'));

           Flight::set('user', $decoded_token->user);
           Flight::set('jwt_token', $token);
           return TRUE;


    } catch (Exception $e) {
        Flight::halt(401, $e->getMessage());
    }
});

require_once __DIR__ . '/routes/AuthRoutes.php';
require_once __DIR__ . '/routes/PaymentRoutes.php';
require_once __DIR__ . '/routes/ReservationRoutes.php';
require_once __DIR__ . '/routes/RoomRoutes.php';
require_once __DIR__ . '/routes/RoomTypeRoutes.php';
require_once __DIR__ . '/routes/UserRoutes.php';

Flight::start();  
?>
