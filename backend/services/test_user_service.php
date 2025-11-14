<?php
require_once 'UserService.php';

$user_service = new UserService();

try {
   
    $user_data = [
        'name' => 'Tarik Test',
        'email' => 'tarik.test@example.com',
        'password' => 'password123',
        'phone' => '061234567',
        'role' => 'user'
    ];
    $user_service->createUser($user_data);
    echo "User created successfully!\n";

  
    $user = $user_service->getByEmail('tarik.test@example.com');
    echo "User fetched by email:\n";
    print_r($user);

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
