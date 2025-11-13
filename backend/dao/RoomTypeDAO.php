<?php
require_once __DIR__ . '/BaseDAO.php';

class RoomTypeDAO extends BaseDAO {
    public function __construct(){
        parent::__construct('room_types');
    }

    public function createRoomType($roomType){
        $data = [
            'name'        => $roomType['name'],
            'description' => $roomType['description']
        ];
        return $this->insert($data);
    }

    public function getAllRoomTypes(){
        return $this->getAll();
    }

    public function getRoomTypeById($id){
        return $this->getById($id);
    }

    public function updateRoomType($id, $roomType){
        $data = [
            'name'        => $roomType['name'],
            'description' => $roomType['description']
        ];
        return $this->update($id, $data);
    }

    public function deleteRoomType($id){
        return $this->delete($id);
    }

    public function getByName($name) {
    $stmt = $this->connection->prepare("SELECT * FROM room_types WHERE name = :name");
    $stmt->execute(['name' => $name]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}
?>