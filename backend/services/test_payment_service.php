<?php
require_once __DIR__ . '/PaymentService.php';

$payment_service = new PaymentService();

try {
   
    $payment_data = [
        'reservation_id' => 24,
        'amount' => 600.00,
        'currency' => 'EUR',
        'paid_at' => '2025-11-01 10:15:00'
    ];
    $payment_service->createPayment($payment_data);
    echo "Payment created successfully!\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
