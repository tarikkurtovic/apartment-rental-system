<?php
require_once 'BaseDAO.php';

class RoomTypeDAO extends BaseDAO {
    public function __construct() {
        parent::__construct("room_types");
    }
}
?>