<?php
require_once __DIR__ . '/RoomTypeService.php';

$room_type_service = new RoomTypeService();

try {
    
    $room_type_data = [
        'name' => 'Deluxe apartment',
        'description' => 'Luxury apartment with a private balcony'
    ];
    $room_type_service->createRoomType($room_type_data);
    echo "Room type created successfully!\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
