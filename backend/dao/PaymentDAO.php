<?php
require_once 'BaseDAO.php';

class PaymentDAO extends BaseDAO {
   public function __construct() {
       parent::__construct("payments");
   }

   public function getByReservationId(int $reservationId): ?array {
       $stmt = $this->connection->prepare("SELECT * FROM payments WHERE reservation_id = :rid");
       $stmt->bindValue(':rid', $reservationId, PDO::PARAM_INT);
       $stmt->execute();
       $row = $stmt->fetch();
       return $row ?: null;
   }
}