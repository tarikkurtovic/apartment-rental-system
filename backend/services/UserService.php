<?php 
require_once  __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/UserDAO.php';

class UserService extends BaseService {
    public function __construct(){
        $dao = new UserDAO();
        parent::__construct($dao);
    }

    public function getByEmail($email){
        return $this->dao->getByEmail($email);
    }

    public function createUser($data){
     
            if(empty($data['email'])){
                throw new Exception('Email is required.');
            }

            if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
                throw new Exception('Invalid email format.');
            }

            $existing = $this->dao->getByEmail($data['email']);
            if(!empty($existing)){
                throw new Exception('A user with this email already exists.');
            }
            return $this->create($data);
        }
    }
?>