<?php


/**
     * @OA\Get(
     *     path="/payments",
     *     tags={"payments"},
     *     summary="Get all payments",
     *     security={{"ApiKey": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Array of all payments in the database"
     *     )
     * )
     */
Flight::route('GET /payments', function() {
    Flight::auth_middleware()->verifyToken(
        Flight::request()->getHeader("Authentication")
    );


    Flight::auth_middleware()->authorizeRoles([
        Roles::ADMIN,
        Roles::USER
    ]);
    Flight::json(Flight::paymentService()->getAll());

});

 /**
     * @OA\Get(
     *     path="/payments/{id}",
     *     tags={"payments"},
     *     summary="Get a specific payment by ID",
     *     security={{"ApiKey": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Payment ID",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Returns the payment with the given ID"
     *     )
     * )
     */
Flight::route('GET /payments/@id', function($id) {
     Flight::auth_middleware()->verifyToken(
        Flight::request()->getHeader("Authentication")
    );


    Flight::auth_middleware()->authorizeRoles([
        Roles::ADMIN,
        Roles::USER
    ]);

    Flight::json(Flight::paymentService()->getById($id));
});

/**
     * @OA\Post(
     *     path="/payments",
     *     tags={"payments"},
     *     summary="Create a new payment",
     *     security={{"ApiKey": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"reservation_id", "amount", "currency", "paid_at"},
     *             @OA\Property(property="reservation_id", type="integer", example=1),
     *             @OA\Property(property="amount", type="number", format="float", example=240.00),
     *             @OA\Property(property="currency", type="string", example="EUR"),
     *             @OA\Property(property="paid_at", type="string", example="2025-11-01 10:15:00")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Payment successfully created"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error or invalid reservation ID"
     *     )
     * )
     */
Flight::route('POST /payments', function() {

     Flight::auth_middleware()->verifyToken(
        Flight::request()->getHeader("Authentication")
    );


    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    
    $data = Flight::request()->data->getData();
    try {
        $result = Flight::paymentService()->createPayment($data);
        Flight::json(['message' => 'Payment created successfully', 'result' => $result]);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

    /**
     * @OA\Put(
     *     path="/payments/{id}",
     *     tags={"payments"},
     *     summary="Update an existing payment by ID",
     *     security={{"ApiKey": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Payment ID to update",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="reservation_id", type="integer", example=1),
     *             @OA\Property(property="amount", type="number", format="float", example=260.00),
     *             @OA\Property(property="currency", type="string", example="EUR"),
     *             @OA\Property(property="paid_at", type="string", example="2025-11-02 12:00:00")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Payment successfully updated"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error"
     *     )
     * )
     */
Flight::route('PUT /payments/@id', function($id) {

    
    Flight::auth_middleware()->verifyToken(
        Flight::request()->getHeader("Authentication")
    );


    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    
    $data = Flight::request()->data->getData();
    try {
        $result = Flight::paymentService()->update($id, $data);
        Flight::json(['message' => 'Payment updated successfully', 'result' => $result]);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

    /**
     * @OA\Delete(
     *     path="/payments/{id}",
     *     tags={"payments"},
     *     summary="Delete a payment by ID",
     *     security={{"ApiKey": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
         *         required=true,
     *         description="Payment ID to delete",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Payment successfully deleted"
     *     )
     * )
     */
Flight::route('DELETE /payments/@id', function($id) {
    Flight::auth_middleware()->verifyToken(
        Flight::request()->getHeader("Authentication")
    );


    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);

    Flight::json(Flight::paymentService()->delete($id));
});
?>
