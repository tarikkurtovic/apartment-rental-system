<?php
/**
 * @OA\Get(
 *     path="/reservations",
 *     tags={"reservations"},
 *     summary="Get all reservations",
 *     @OA\Response(
 *         response=200,
 *         description="Returns all reservations"
 *     )
 * )
 */
Flight::route('GET /reservations', function() {
    Flight::json(Flight::reservationService()->getAll());
});

/**
 * @OA\Get(
 *     path="/reservations/{id}",
 *     tags={"reservations"},
 *     summary="Get a reservation by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Reservation ID",
 *         @OA\Schema(type="integer", example=3)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Returns a specific reservation"
 *     )
 * )
 */
Flight::route('GET /reservations/@id', function($id) {
    Flight::json(Flight::reservationService()->getById($id));
});

/**
 * @OA\Get(
 *     path="/reservations/user/{user_id}",
 *     tags={"reservations"},
 *     summary="Get all reservations for a user",
 *     @OA\Parameter(
 *         name="user_id",
 *         in="path",
 *         required=true,
 *         description="User ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Returns all reservations created by a specific user"
 *     )
 * )
 */

Flight::route('GET /reservations/user/@user_id', function($user_id) {
    Flight::json(Flight::reservationService()->getByUser($user_id));
});

/**
 * @OA\Post(
 *     path="/reservations",
 *     tags={"reservations"},
 *     summary="Create a new reservation",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"user_id", "room_id", "check_in", "check_out", "guests"},
 *             @OA\Property(property="user_id", type="integer", example=1),
 *             @OA\Property(property="room_id", type="integer", example=3),
 *             @OA\Property(property="check_in", type="string", example="2025-12-01"),
 *             @OA\Property(property="check_out", type="string", example="2025-12-05"),
 *             @OA\Property(property="guests", type="integer", example=2)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Reservation successfully created"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Validation or date error"
 *     )
 * )
 */
Flight::route('POST /reservations', function() {
    $data = Flight::request()->data->getData();
    try {
        $result = Flight::reservationService()->createReservation($data);
        Flight::json(['message' => 'Reservation created successfully', 'result' => $result]);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

/**
 * @OA\Put(
 *     path="/reservations/{id}",
 *     tags={"reservations"},
 *     summary="Update a reservation by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Reservation ID",
 *         @OA\Schema(type="integer", example=3)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="user_id", type="integer", example=1),
 *             @OA\Property(property="room_id", type="integer", example=3),
 *             @OA\Property(property="check_in", type="string", example="2025-12-10"),
 *             @OA\Property(property="check_out", type="string", example="2025-12-14"),
 *             @OA\Property(property="guests", type="integer", example=2)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Reservation successfully updated"
 *     )
 * )
 */
Flight::route('PUT /reservations/@id', function($id) {
    $data = Flight::request()->data->getData();
    try {
        $result = Flight::reservationService()->update($id, $data);
        Flight::json(['message' => 'Reservation updated successfully', 'result' => $result]);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

/**
 * @OA\Delete(
 *     path="/reservations/{id}",
 *     tags={"reservations"},
 *     summary="Delete a reservation by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Reservation ID",
 *         @OA\Schema(type="integer", example=4)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Reservation successfully deleted"
 *     )
 * )
 */
Flight::route('DELETE /reservations/@id', function($id) {
    try {
        $result = Flight::reservationService()->delete($id);
        Flight::json(['message' => 'Reservation deleted successfully', 'result' => $result]);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

?>
