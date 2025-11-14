<?php

/**
 * @OA\Get(
 *     path="/rooms",
 *     tags={"rooms"},
 *     summary="Get all rooms",
 *     @OA\Response(
 *         response=200,
 *         description="Returns all rooms"
 *     )
 * )
 */
Flight::route('GET /rooms', function() {
    Flight::json(Flight::roomService()->getAll());
});

/**
 * @OA\Get(
 *     path="/rooms/{id}",
 *     tags={"rooms"},
 *     summary="Get a room by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Room ID",
 *         @OA\Schema(type="integer", example=3)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Returns room by ID"
 *     )
 * )
 */
Flight::route('GET /rooms/@id', function($id) {
    Flight::json(Flight::roomService()->getById($id));
});

/**
 * @OA\Get(
 *     path="/rooms/number/{number}",
 *     tags={"rooms"},
 *     summary="Get a room by its number (e.g., 101, 202)",
 *     @OA\Parameter(
 *         name="number",
 *         in="path",
 *         required=true,
 *         description="Room's number",
 *         @OA\Schema(type="string", example="101")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Returns room(s) that match the given room number"
 *     )
 * )
 */
Flight::route('GET /rooms/number/@number', function($number) {
    Flight::json(Flight::roomService()->getByNumber($number));
});

/**
 * @OA\Post(
 *     path="/rooms",
 *     tags={"rooms"},
 *     summary="Create a new room",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"number", "title", "max_guests", "price_per_night", "room_type_id"},
 *             @OA\Property(property="number", type="string", example="505"),
 *             @OA\Property(property="title", type="string", example="Penthouse Suite"),
 *             @OA\Property(property="description", type="string", example="Top floor suite with sea view"),
 *             @OA\Property(property="max_guests", type="integer", example=4),
 *             @OA\Property(property="price_per_night", type="number", example=350),
 *             @OA\Property(property="room_type_id", type="integer", example=3)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Room successfully created"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Validation error"
 *     )
 * )
 */
Flight::route('POST /rooms', function() {
    $data = Flight::request()->data->getData();
    try {
        $result = Flight::roomService()->createRoom($data);
        Flight::json(['message' => 'Room created successfully', 'result' => $result]);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

/**
 * @OA\Put(
 *     path="/rooms/{id}",
 *     tags={"rooms"},
 *     summary="Update a room by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Room ID",
 *         @OA\Schema(type="integer", example=3)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="number", type="string", example="505"),
 *             @OA\Property(property="title", type="string", example="Updated Room Title"),
 *             @OA\Property(property="description", type="string", example="Updated description"),
 *             @OA\Property(property="max_guests", type="integer", example=4),
 *             @OA\Property(property="price_per_night", type="number", example=400),
 *             @OA\Property(property="room_type_id", type="integer", example=3)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Room updated successfully"
 *     )
 * )
 */
Flight::route('PUT /rooms/@id', function($id) {
    $data = Flight::request()->data->getData();
    try {
        $result = Flight::roomService()->update($id, $data);
        Flight::json(['message' => 'Room updated successfully', 'result' => $result]);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

/**
 * @OA\Delete(
 *     path="/rooms/{id}",
 *     tags={"rooms"},
 *     summary="Delete a room by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Room ID",
 *         @OA\Schema(type="integer", example=4)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Room successfully deleted"
 *     )
 * )
 */
Flight::route('DELETE /rooms/@id', function($id) {
    try {
        $result = Flight::roomService()->delete($id);
        Flight::json(['message' => 'Room deleted successfully', 'result' => $result]);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

?>
