<?php
/**
 * @OA\Get(
 *     path="/users",
 *     tags={"users"},
 *     summary="Get all users",
 *     @OA\Response(
 *         response=200,
 *         description="Returns all users"
 *     )
 * )
 */
Flight::route('GET /users', function() {
    Flight::json(Flight::userService()->getAll());
});

/**
 * @OA\Get(
 *     path="/users/{id}",
 *     tags={"users"},
 *     summary="Get a user by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="User ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Returns a specific user"
 *     )
 * )
 */
Flight::route('GET /users/@id', function($id) {
    Flight::json(Flight::userService()->getById($id));
});

/**
 * @OA\Get(
 *     path="/users/email/{email}",
 *     tags={"users"},
 *     summary="Get a user by email",
 *     @OA\Parameter(
 *         name="email",
 *         in="path",
 *         required=true,
 *         description="Email address",
 *         @OA\Schema(type="string", example="john@example.com")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Returns a user by email"
 *     )
 * )
 */
Flight::route('GET /users/email/@email', function($email) {
    Flight::json(Flight::userService()->getByEmail($email));
});


/**
 * @OA\Post(
 *     path="/users",
 *     tags={"users"},
 *     summary="Create a new user",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name", "email", "password"},
 *             @OA\Property(property="name", type="string", example="Tarik Brown"),
 *             @OA\Property(property="email", type="string", example="tarik@example.com"),
 *             @OA\Property(property="password", type="string", example="securePassword123"),
 *             @OA\Property(property="phone", type="string", example="+38762123456"),
 *             @OA\Property(property="role", type="string", example="user")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User created successfully"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Validation error or email already exists"
 *     )
 * )
 */
Flight::route('POST /users', function() {
    $data = Flight::request()->data->getData();
    try {
        $result = Flight::userService()->createUser($data);
        Flight::json(['message' => 'User created successfully', 'result' => $result]);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

/**
 * @OA\Put(
 *     path="/users/{id}",
 *     tags={"users"},
 *     summary="Update a user by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="User ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="name", type="string", example="Updated Name"),
 *             @OA\Property(property="email", type="string", example="updated@example.com"),
 *             @OA\Property(property="password", type="string", example="newPassword123"),
 *             @OA\Property(property="phone", type="string", example="+38762111222"),
 *             @OA\Property(property="role", type="string", example="admin")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User updated successfully"
 *     )
 * )
 */
Flight::route('PUT /users/@id', function($id) {
    $data = Flight::request()->data->getData();
    try {
        $result = Flight::userService()->update($id, $data);
        Flight::json(['message' => 'User updated successfully', 'result' => $result]);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

/**
 * @OA\Delete(
 *     path="/users/{id}",
 *     tags={"users"},
 *     summary="Delete a user by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="User ID",
 *         @OA\Schema(type="integer", example=3)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User deleted successfully"
 *     )
 * )
 */
Flight::route('DELETE /users/@id', function($id) {
    try {
        $result = Flight::userService()->delete($id);
        Flight::json(['message' => 'User deleted successfully', 'result' => $result]);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

?>
