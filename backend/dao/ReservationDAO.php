<?php
require_once 'BaseDAO.php';

class ReservationDAO extends BaseDAO {
   public function __construct() {
       parent::__construct("reservations"); 
   }

   public function getByUserId(int $userId): array {
       $stmt = $this->connection->prepare("SELECT * FROM reservations WHERE user_id = :uid ORDER BY check_in DESC");
       $stmt->bindValue(':uid', $userId, PDO::PARAM_INT);
       $stmt->execute();
       return $stmt->fetchAll();
   }
}
?>