<?php
require_once __DIR__ . '/../dao/ReservationDao.php';
require_once __DIR__ . '/BaseService.php';

class ReservationService extends BaseService{
    public function __construct() {
        $dao = new ReservationDao();
        parent::__construct($dao);
}

public function getByUser($user_id){
    return $this->dao->getByUser($user_id);
}

public function createReservation($data){
   if(empty($data['user_id']) || empty($data['room_id'])){
    throw new Exception('Reservation must include both user_id and room_id.');
   }
   
   if(empty($data['check_in']) || empty($data['room_id'])){
    throw new Exception('Check-in and check-out dates are required.');
   }

   if(strtotime($data['check_out']) <= strtotime($data['check_in'])){
    throw new Exception('Check-out date must be after check-in date.');
   }

   if(!isset($data['guests']) || $data['guests'] <= 0){
    throw new Exception('Number of guests must be a positive value.');
   }
   return $this->create($data);
}
}
?>