<?php
require_once 'BaseDAO.php';

class RoomDAO extends BaseDAO {
    public function __construct() {
        parent::__construct("rooms");
    }
}
?>