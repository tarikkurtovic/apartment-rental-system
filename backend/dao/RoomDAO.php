<?php
require_once __DIR__ . '/BaseDAO.php';

class RoomDAO extends BaseDAO {
    public function __construct(){
        parent::__construct('rooms');
    }

    public function createRoom($room){
        $data = [
            'number'          => $room['number'],
            'title'           => $room['title'],
            'description'     => $room['description'],
            'max_guests'      => $room['max_guests'],
            'price_per_night' => $room['price_per_night'],
            'room_type_id'    => $room['room_type_id']
        ];
        return $this->insert($data);
    }

    public function getAllRooms(){
        return $this->getAll();
    }

    public function getRoomById($id){
        return $this->getById($id);
    }

    public function updateRoom($id, $room){
        $data = [
            'number'          => $room['number'],
            'title'           => $room['title'],
            'description'     => $room['description'],
            'max_guests'      => $room['max_guests'],
            'price_per_night' => $room['price_per_night'],
            'room_type_id'    => $room['room_type_id']
        ];
        return $this->update($id, $data);
    }

    public function deleteRoom($id){
        return $this->delete($id);
    }
}
?>