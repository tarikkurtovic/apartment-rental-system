<?php
require 'vendor/autoload.php'; 

require_once __DIR__ . '/services/PaymentService.php';
Flight::register('paymentService', 'PaymentService');
require_once __DIR__ . '/routes/PaymentRoutes.php';

require_once __DIR__ . '/services/ReservationService.php';
Flight::register('reservationService', 'ReservationService');
require_once __DIR__ . '/routes/ReservationRoutes.php';

require_once __DIR__ . '/services/RoomService.php';
Flight::register('roomService', 'RoomService');
require_once __DIR__ . '/routes/RoomRoutes.php';

require_once __DIR__ . '/services/RoomTypeService.php';
Flight::register('roomTypeService', 'RoomTypeService');
require_once __DIR__ . '/routes/RoomTypeRoutes.php';

require_once __DIR__ . '/services/UserService.php';
Flight::register('userService', 'UserService');
require_once __DIR__ . '/routes/UserRoutes.php';

Flight::start();  
?>
