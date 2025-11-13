<?php
require_once __DIR__ . '/ReservationService.php';

$reservation_service = new ReservationService();

try {
    
    $reservation_data = [
        'user_id' => 35,
        'room_id' => 2,
        'check_in' => '2025-11-10',
        'check_out' => '2025-11-12',
        'guests' => 5
    ];
    $reservation_service->createReservation($reservation_data);
    echo "Reservation created successfully!\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
