<?php
require_once __DIR__ . '/../dao/PaymentDAO.php';
require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/ReservationDAO.php';

class PaymentService extends BaseService{
    public function __construct(){
        $dao = new PaymentDAO();
        parent::__construct($dao);
    }

    public function createPayment($data){
        
        $reservation_dao = new ReservationDAO();
        $reservation = $reservation_dao->getReservationById($data['reservation_id']); 

        if (empty($reservation)) {
            throw new Exception('Reservation ID does not exist.');
        }
        

        if(empty($data['reservation_id'])){
            throw new Exception('Reservation ID is required.');
        }

        if($data['amount'] <= 0){
            throw new Exception('Payment amount must be a positive value.');
        }

        if(empty($data['currency'])){
            throw new Exception('Currency is required.');
        }

        if(empty($data['paid_at'])){
            throw new Exception('Payment date (paid_at) is required.');
        }
        return $this->create($data);
    } 
}
?>