<?php

Flight::route('GET /reservations', function() {
    Flight::json(Flight::reservationService()->getAll());
});

Flight::route('GET /reservations/@id', function($id) {
    Flight::json(Flight::reservationService()->getById($id));
});

Flight::route('GET /reservations/user/@user_id', function($user_id) {
    Flight::json(Flight::reservationService()->getByUser($user_id));
});

Flight::route('POST /reservations', function() {
    $data = Flight::request()->data->getData();
    try {
        $result = Flight::reservationService()->createReservation($data);
        Flight::json(['message' => 'Reservation created successfully', 'result' => $result]);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

Flight::route('PUT /reservations/@id', function($id) {
    $data = Flight::request()->data->getData();
    try {
        $result = Flight::reservationService()->update($id, $data);
        Flight::json(['message' => 'Reservation updated successfully', 'result' => $result]);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

Flight::route('DELETE /reservations/@id', function($id) {
    try {
        $result = Flight::reservationService()->delete($id);
        Flight::json(['message' => 'Reservation deleted successfully', 'result' => $result]);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

?>
