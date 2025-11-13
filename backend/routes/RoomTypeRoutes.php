<?php

Flight::route('GET /room-types', function() {
    Flight::json(Flight::roomTypeService()->getAll());
});

Flight::route('GET /room-types/@id', function($id) {
    Flight::json(Flight::roomTypeService()->getById($id));
});

Flight::route('GET /room-types/name/@name', function($name) {
    Flight::json(Flight::roomTypeService()->getRoomTypeByName($name));
});

Flight::route('POST /room-types', function() {
    $data = Flight::request()->data->getData();
    try {
        $result = Flight::roomTypeService()->createRoomType($data);
        Flight::json(['message' => 'Room type created successfully', 'result' => $result]);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

Flight::route('PUT /room-types/@id', function($id) {
    $data = Flight::request()->data->getData();
    try {
        $result = Flight::roomTypeService()->update($id, $data);
        Flight::json(['message' => 'Room type updated successfully', 'result' => $result]);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

Flight::route('DELETE /room-types/@id', function($id) {
    try {
        $result = Flight::roomTypeService()->delete($id);
        Flight::json(['message' => 'Room type deleted successfully', 'result' => $result]);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

?>
