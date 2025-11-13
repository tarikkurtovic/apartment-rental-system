<?php

Flight::route('GET /rooms', function() {
    Flight::json(Flight::roomService()->getAll());
});

Flight::route('GET /rooms/@id', function($id) {
    Flight::json(Flight::roomService()->getById($id));
});

Flight::route('GET /rooms/number/@number', function($number) {
    Flight::json(Flight::roomService()->getByNumber($number));
});

Flight::route('POST /rooms', function() {
    $data = Flight::request()->data->getData();
    try {
        $result = Flight::roomService()->createRoom($data);
        Flight::json(['message' => 'Room created successfully', 'result' => $result]);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

Flight::route('PUT /rooms/@id', function($id) {
    $data = Flight::request()->data->getData();
    try {
        $result = Flight::roomService()->update($id, $data);
        Flight::json(['message' => 'Room updated successfully', 'result' => $result]);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

Flight::route('DELETE /rooms/@id', function($id) {
    try {
        $result = Flight::roomService()->delete($id);
        Flight::json(['message' => 'Room deleted successfully', 'result' => $result]);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

?>
