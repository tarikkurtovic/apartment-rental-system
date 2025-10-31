<?php
require_once 'BaseDAO.php';


class UserDAO extends BaseDAO {
   public function __construct() {
       parent::__construct("users");
   }

     public function createUser($user){
        $data = [
            'name'     => $user['name'],
            'email'    => $user['email'],
            'password' => $user['password'],
            'phone'    => $user['phone'],
            'role'     => $user['role']
        ];
        return $this->insert($data);
    }

    public function getAllUsers(){
        return $this->getAll();
    }

    public function getUserById($id){
        return $this->getById($id);
    }

    public function updateUser($id, $user){
        $data = [
            'name'     => $user['name'],
            'email'    => $user['email'],
            'password' => $user['password'],
            'phone'    => $user['phone'],
            'role'     => $user['role']
        ];
        return $this->update($id, $data);
    }

    public function deleteUser($id){
        return $this->delete($id);
    }
    
    public function getByEmail($email) {
        $stmt = $this->connection->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch();
    }
}
?>
