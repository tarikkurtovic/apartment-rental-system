<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'dao/UserDAO.php';
require_once 'dao/RoomTypeDAO.php';
require_once 'dao/RoomDAO.php';
require_once 'dao/ReservationDAO.php';
require_once 'dao/PaymentDAO.php';

$db   = Database::connect();
$user = new UserDAO();
$rt   = new RoomTypeDAO();
$room = new RoomDAO();
$res  = new ReservationDAO();
$pay  = new PaymentDAO();


$email      = 'hafe@gmail.com';
$rtName     = 'Deluxe Suite';
$roomNumber = '101';
$checkIn    = date('Y-m-d', strtotime('+1 day'));
$checkOut   = date('Y-m-d', strtotime('+3 days'));
$amount     = 240.00;

$u = $user->getByEmail($email);
if ($u) {
  $userId = (int)$u['id'];
} else {
  $user->insert(['name'=>'Hafe',
                 'email'=>$email,
                 'password'=>'hafe123',
                 'role'=>'user',
                 'phone'=>null]);
  $userId = (int)$db->lastInsertId();
}

$rtId = null;
foreach ($rt->getAll() as $row) { if ($row['name'] === $rtName) { $rtId = (int)$row['id']; break; } }
if (!$rtId) { $rt->insert(['name'=>$rtName,'description'=>'Spacious suite with sea view']); $rtId = (int)$db->lastInsertId(); }


$roomId = null;
foreach ($room->getAll() as $r) { if ($r['number'] === $roomNumber) { $roomId = (int)$r['id']; break; } }
if (!$roomId) {
  $room->insert(['number'=>$roomNumber,'title'=>'Deluxe 101','description'=>'Large double room with balcony','max_guests'=>2,'price_per_night'=>120.00,'room_type_id'=>$rtId]);
  $roomId = (int)$db->lastInsertId();
}


$existingRes = null;
foreach ($res->getAll() as $rr) {
  if ((int)$rr['user_id']===$userId && (int)$rr['room_id']===$roomId && $rr['check_in']===$checkIn && $rr['check_out']===$checkOut) { $existingRes=$rr; break; }
}
if ($existingRes) {
  $reservationId = (int)$existingRes['id'];
} else {
  $res->insert(['user_id'=>$userId,'room_id'=>$roomId,'check_in'=>$checkIn,'check_out'=>$checkOut,'guests'=>2]);
  $reservationId = (int)$db->lastInsertId();
}


$hasPayment = false;
foreach ($pay->getAll() as $pp) {
  if ((int)$pp['reservation_id']===$reservationId && (float)$pp['amount']==$amount) { $hasPayment = true; break; }
}
if (!$hasPayment) {
  $pay->insert(['reservation_id'=>$reservationId,'amount'=>$amount,'currency'=>'EUR','paid_at'=>date('Y-m-d H:i:s')]);
}


print_r($user->getAll());
print_r($rt->getAll());
print_r($room->getAll());
print_r($res->getAll());
print_r($pay->getAll());
