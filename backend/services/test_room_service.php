<?php
require_once __DIR__ . '../RoomService.php';

$room_service = new RoomService();

try {
   
    $room_data = [
        'number' => '308',
        'title' => 'Ocean View Suite',
        'description' => 'Spacious room with ocean view',
        'max_guests' => 3,
        'price_per_night' => 150,
        'room_type_id' => 2
    ];
    $room_service->createRoom($room_data);
    echo "Room created successfully!\n";

    $room = $room_service->getByNumber('308');
    echo "Room fetched by number:\n";
    print_r($room);

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
