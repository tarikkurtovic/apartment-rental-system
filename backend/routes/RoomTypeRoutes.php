<?php
/**
 * @OA\Get(
 *     path="/room-types",
 *     tags={"room_types"},
 *     summary="Get all room types",
 *     security={{"ApiKey": {}}},
 *     @OA\Response(
 *         response=200,
 *         description="Returns all room types"
 *     )
 * )
 */
Flight::route('GET /room-types', function() {
    Flight::auth_middleware()->verifyToken(
        Flight::request()->getHeader("Authentication")
    );

    Flight::auth_middleware()->authorizeRoles([
        Roles::ADMIN,
        Roles::USER
    ]);

    Flight::json(Flight::roomTypeService()->getAll());
});

/**
 * @OA\Get(
 *     path="/room-types/{id}",
 *     tags={"room_types"},
 *     summary="Get a room type by ID",
 *     security={{"ApiKey": {}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Room type ID",
 *         @OA\Schema(type="integer", example=2)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Returns a specific room type"
 *     )
 * )
 */
Flight::route('GET /room-types/@id', function($id) {
    Flight::auth_middleware()->verifyToken(
        Flight::request()->getHeader("Authentication")
    );

    Flight::auth_middleware()->authorizeRoles([
        Roles::ADMIN,
        Roles::USER
    ]);

    Flight::json(Flight::roomTypeService()->getById($id));
});

/**
 * @OA\Get(
 *     path="/room-types/name/{name}",
 *     tags={"room_types"},
 *     summary="Get a room type by name",
 *     security={{"ApiKey": {}}},
 *     @OA\Parameter(
 *         name="name",
 *         in="path",
 *         required=true,
 *         description="Room type name",
 *         @OA\Schema(type="string", example="Suite")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Returns room type(s) by name"
 *     )
 * )
 */
Flight::route('GET /room-types/name/@name', function($name) {
     Flight::auth_middleware()->verifyToken(
        Flight::request()->getHeader("Authentication")
    );

    Flight::auth_middleware()->authorizeRoles([
        Roles::ADMIN,
        Roles::USER
    ]);
    
    Flight::json(Flight::roomTypeService()->getRoomTypeByName($name));
});

/**
 * @OA\Post(
 *     path="/room-types",
 *     tags={"room_types"},
 *     summary="Create a new room type",
 *     security={{"ApiKey": {}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name"},
 *             @OA\Property(property="name", type="string", example="Premium Deluxe"),
 *             @OA\Property(property="description", type="string", example="Luxury suite with private balcony")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Room type created successfully"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Validation or duplicate name error"
 *     )
 * )
 */
Flight::route('POST /room-types', function() {

     Flight::auth_middleware()->verifyToken(
        Flight::request()->getHeader("Authentication")
    );

    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);

    $data = Flight::request()->data->getData();
    try {
        $result = Flight::roomTypeService()->createRoomType($data);
        Flight::json(['message' => 'Room type created successfully', 'result' => $result]);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

/**
 * @OA\Put(
 *     path="/room-types/{id}",
 *     tags={"room_types"},
 *     summary="Update a room type by ID",
 *     security={{"ApiKey": {}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Room type ID",
 *         @OA\Schema(type="integer", example=3)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="name", type="string", example="Updated Suite"),
 *             @OA\Property(property="description", type="string", example="Updated description for room type")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Room type updated successfully"
 *     )
 * )
 */
Flight::route('PUT /room-types/@id', function($id) {

    
    Flight::auth_middleware()->verifyToken(
        Flight::request()->getHeader("Authentication")
    );

    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);

    $data = Flight::request()->data->getData();
    try {
        $result = Flight::roomTypeService()->update($id, $data);
        Flight::json(['message' => 'Room type updated successfully', 'result' => $result]);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

/**
 * @OA\Delete(
 *     path="/room-types/{id}",
 *     tags={"room_types"},
 *     summary="Delete a room type by ID",
 *     security={{"ApiKey": {}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Room type ID",
 *         @OA\Schema(type="integer", example=4)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Room type deleted successfully"
 *     )
 * )
 */
Flight::route('DELETE /room-types/@id', function($id) {

    Flight::auth_middleware()->verifyToken(
        Flight::request()->getHeader("Authentication")
    );

    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    
    try {
        $result = Flight::roomTypeService()->delete($id);
        Flight::json(['message' => 'Room type deleted successfully', 'result' => $result]);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

?>
