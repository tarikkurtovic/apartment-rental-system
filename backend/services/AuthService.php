<?php
require_once 'BaseService.php';
require_once __DIR__ . '/../dao/AuthDao.php';
require_once __DIR__ . '/../config.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthService extends BaseService {
   private $auth_dao;

   public function __construct() {
       $this->auth_dao = new AuthDao();
       parent::__construct(new AuthDao);
   }

   public function get_user_by_email($email){
       return $this->auth_dao->get_user_by_email($email);
   }

   public function register($entity) {
       try {
           if (empty($entity['email']) || empty($entity['password'])) {
               return ['success' => false, 'error' => 'Email and password are required.'];
           }

           $email_exists = $this->auth_dao->get_user_by_email($entity['email']);
           if($email_exists){
               return ['success' => false, 'error' => 'Email already registered.'];
           }

           // Hash the password
           $entity['password'] = password_hash($entity['password'], PASSWORD_BCRYPT);

           // Set default role if not provided
           if (!isset($entity['role'])) {
               $entity['role'] = 'user';
           }

           // Set default name if not provided (use part before @ from email)
           if (empty($entity['name'])) {
               $entity['name'] = explode('@', $entity['email'])[0];
           }

           parent::create($entity);
            
           $user = $this->auth_dao->get_user_by_email($entity['email']);

           unset($user['password']);

           return ['success' => true, 'data' => $user];
       } catch (Exception $e) {
           return ['success' => false, 'error' => 'Registration failed: ' . $e->getMessage()];
       }
   }

   public function login($entity) {
 
       if (empty($entity['email']) || empty($entity['password'])) {
           return ['success' => false, 'error' => 'Email and password are required.'];
       }


       $user = $this->auth_dao->get_user_by_email($entity['email']);
       if(!$user){
           return ['success' => false, 'error' => 'Invalid username or password.'];
       }


       if(!password_verify($entity['password'], $user['password'])) {
           return ['success' => false, 'error' => 'Invalid username or password.'];
       }

       unset($user['password']);

       $jwt_payload = [
           'user' => $user,
           'iat' => time(),
           'exp' => time() + (60 * 60 * 24) 
       ];


       $token = JWT::encode(
           $jwt_payload,
           Config::JWT_SECRET(),
           'HS256'
       );

  
       return [
           'success' => true,
           'data' => array_merge($user, ['token' => $token])
       ];
   }
}
?>