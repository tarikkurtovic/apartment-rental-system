<?php
require_once __DIR__ . '/../dao/RoomDAO.php';
require_once __DIR__ . '/BaseService.php';

class RoomService extends BaseService {
    public function __construct() {
        $dao = new RoomDAO();
        parent::__construct($dao);
    }

public function getByNumber($number) {
    return $this->dao->getByNumber($number);
    }


public function createRoom($data){
    if($data['price_per_night'] <= 0){
        throw new Exception('Price per night must be a positive value.');
    }

    if($data['max_guests'] <= 0){
        throw new Exception('Max guests must be a positive number.');
    }
    return $this->create($data);
}
}
?>