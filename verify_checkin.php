<?php
// Incluir el código CRUD
include 'crud.php';

// Obtener el ID del check-in a partir del código QR
$qr_code = $_GET['qr_code'];
$check_in = getCheckInByQRCode($qr_code);

if ($check_in) {
    // Si el check-in existe, actualizar la hora de salida
    $checkout_time = date("Y-m-d H:i:s");
    updateCheckOutTime($check_in['id'], $checkout_time);
    echo "Salida registrada. Gracias por tu visita.";
} else {
    // Si el check-in no existe, crear uno nuevo
    $name = $_GET['name'];
    $email = $_GET['email'];
    $checkin_time = date("Y-m-d H:i:s");
    $qr_code = $_GET['qr_code'];
    createCheckIn($name, $email, $checkin_time, $qr_code);
    echo "Entrada registrada. Bienvenido.";
}
?>