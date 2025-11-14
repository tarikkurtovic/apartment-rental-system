<?php
require_once __DIR__ . '/BaseDAO.php';

class ReservationDAO extends BaseDAO {
    public function __construct(){
        parent::__construct('reservations');
    }

    public function createReservation($reservation){
        $data = [
            'user_id'   => $reservation['user_id'],
            'room_id'   => $reservation['room_id'],
            'check_in'  => $reservation['check_in'],
            'check_out' => $reservation['check_out'],
            'guests'    => $reservation['guests']
        ];
        return $this->insert($data);
    }

    public function getAllReservations(){
        return $this->getAll();
    }

    public function getReservationById($id){
        return $this->getById($id);
    }

    public function updateReservation($id, $reservation){
        $data = [
            'user_id'   => $reservation['user_id'],
            'room_id'   => $reservation['room_id'],
            'check_in'  => $reservation['check_in'],
            'check_out' => $reservation['check_out'],
            'guests'    => $reservation['guests']
        ];
        return $this->update($id, $data);
    }

    public function deleteReservation($id){
        return $this->delete($id);
    }

    public function getByUser($user_id) {
        $stmt = $this->connection->prepare("SELECT * FROM reservations WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
?>