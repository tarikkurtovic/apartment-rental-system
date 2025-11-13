<?php
require_once __DIR__ . '/../services/PaymentService.php';

Flight::route('GET /payments', function() {
    Flight::json(Flight::get('paymentService')->getAll());
});

Flight::route('GET /payments/@id', function($id) {
    Flight::json(Flight::get('paymentService')->getById($id));
});

Flight::route('POST /payments', function() {
    $data = Flight::request()->data->getData();
    try {
        $result = Flight::get('paymentService')->createPayment($data);
        Flight::json(['message' => 'Payment created successfully', 'result' => $result]);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

Flight::route('PUT /payments/@id', function($id) {
    $data = Flight::request()->data->getData();
    try {
        $result = Flight::get('paymentService')->update($id, $data);
        Flight::json(['message' => 'Payment updated successfully', 'result' => $result]);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

Flight::route('PATCH /payments/@id', function($id) {
    $data = Flight::request()->data->getData();
    try {
        $result = Flight::get('paymentService')->update($id, $data);
        Flight::json(['message' => 'Payment partially updated', 'result' => $result]);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

Flight::route('DELETE /payments/@id', function($id) {
    try {
        $result = Flight::get('paymentService')->delete($id);
        Flight::json(['message' => 'Payment deleted successfully', 'result' => $result]);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});
?>
