<?php

Flight::route('GET /users', function() {
    Flight::json(Flight::userService()->getAll());
});

Flight::route('GET /users/@id', function($id) {
    Flight::json(Flight::userService()->getById($id));
});

Flight::route('GET /users/email/@email', function($email) {
    Flight::json(Flight::userService()->getByEmail($email));
});

Flight::route('POST /users', function() {
    $data = Flight::request()->data->getData();
    try {
        $result = Flight::userService()->createUser($data);
        Flight::json(['message' => 'User created successfully', 'result' => $result]);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

Flight::route('PUT /users/@id', function($id) {
    $data = Flight::request()->data->getData();
    try {
        $result = Flight::userService()->update($id, $data);
        Flight::json(['message' => 'User updated successfully', 'result' => $result]);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

Flight::route('DELETE /users/@id', function($id) {
    try {
        $result = Flight::userService()->delete($id);
        Flight::json(['message' => 'User deleted successfully', 'result' => $result]);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

?>
