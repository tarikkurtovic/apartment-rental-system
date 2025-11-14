<?php
require_once __DIR__ . '/../dao/RoomTypeDAO.php';
require_once __DIR__ . '/BaseService.php';

class RoomTypeService extends BaseService {
    public function __construct() {
        $dao = new RoomTypeDAO();
        parent::__construct($dao);
    }

    public function getRoomTypeByName($name){
        return $this->dao->getByName($name);
    }

public function createRoomType($data){
    if(empty($data['name'])){
        throw new Exception('Room type name is required.');
    }

    $existing = $this->dao->getByName($data['name']);
    if(!empty($existing)){
        throw new Exception('Room type with this name already exists.');
    }

    return $this->create($data);
}
}
?>