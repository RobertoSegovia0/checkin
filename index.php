<?php
// Conexión a la base de datos

$servername = "localhost";
$username ="root";
$password = "";
$dbname = "checkin";


$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Funciones CRUD



// Crear un nuevo check-in
function createCheckIn($name, $email, $checkin_time) {
    global $conn;
}

    



    

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $checkin_time = date("Y-m-d H:i:s");

    if (isset($_FILES['qr_code']) && $_FILES['qr_code']['error'] === UPLOAD_ERR_OK) {
        $qrCodeReader = new QrReader($_FILES['qr_code']['tmp_name']);
        $qrCodeData = $qrCodeReader->text();
        list($qrName, $qrEmail, $qrCheckinTime) = explode('|', $qrCodeData);

        if ($name === $qrName && $email === $qrEmail && $checkin_time === $qrCheckinTime) {
            $qrCodeFile = createCheckIn($name, $email, $checkin_time);
            if ($qrCodeFile) {
                echo "Check-in realizado correctamente. Tu código QR es: " . $qrCodeFile;
            }
        } else {
            echo "El código QR no coincide con los datos ingresados.";
        }
    } else {
        echo "Por favor, carga un código QR.";
    }
}


// Leer todos los check-ins
function readCheckIns() {
    global $conn;
    $sql = "SELECT * FROM check_in";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "ID: " . $row["id"]. " - Nombre: " . $row["name"]. " - Email: " . $row["email"]. " - Hora de check-in: " . $row["checkin_time"]. " - Hora de check-out: " . ($row["checkout_time"] ? $row["checkout_time"] : "Aún no ha salido") . " - Código QR: " . $row["qr_code"]. "<br>";
        }
    } else {
        echo "No hay check-ins registrados.";
    }
}

// Actualizar un check-in
function updateCheckIn($id, $name, $email, $checkin_time, $checkout_time, $qr_code) {
    global $conn;
    $sql = "UPDATE check_in SET name='$name', email='$email', checkin_time='$checkin_time', checkout_time='$checkout_time', qr_code='$qr_code' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "Check-in actualizado correctamente.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Eliminar un check-in
function deleteCheckIn($id) {
    global $conn;
    $sql = "DELETE FROM check_in WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "Check-in eliminado correctamente.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Ejemplo de uso
$name = "John Doe";
$email = "johndoe@example.com";
$checkin_time = date("Y-m-d H:i:s");
$qr_code = "https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=https://example.com/checkin?id=1";

createCheckIn($name, $email, $checkin_time, $qr_code);
readCheckIns();
updateCheckIn(1, 'Jane Doe', 'janedoe@example.com', '2023-04-08 10:30:00', NULL, 'https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=https://example.com/checkin?id=1');readCheckIns();
deleteCheckIn(1);
readCheckIns();

$conn->close();

// Agregar la librería para generar códigos QR
require "qr/qrlib.php";

// Declarar una carpeta temporal para guardar las imágenes generadas
$dir = 'temp/';

// Si no existe la carpeta, crearla
if (!file_exists($dir))
    mkdir($dir);

// Declarar la ruta y nombre del archivo a generar
$filename = $dir.'test.png';

// Parámetros de configuración
$tamaño = 10; // Tamaño de pixel
$level = 'L'; // Precisión baja
$framSize = 3; // Tamaño en blanco
$contenido = "http://codigosdeprogramacion.com"; // Texto

// Enviar los parámetros a la función para generar el código QR
QRcode::png($contenido, $filename, $level, $tamaño, $framSize);

// Mostrar la imagen generada
echo '<img src="'.$dir.basename($filename).'" /><hr/>';






?>

<form method="post" enctype="multipart/form-data">
    <label for="name">Nombre:</label>
    <input type="text" id="name" name="name" required>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>

    <label for="qr_code">Código QR:</label>
    <input type="file" id="qr_code" name="qr_code" required>

    <button type="submit">Hacer check-in</button>


    // Agregar la librería para generar códigos QR
require "phpqrcode/qrlib.php";

// Declarar una carpeta temporal para guardar las imágenes generadas
$dir = 'temp/';

// Si no existe la carpeta, crearla
if (!file_exists($dir))
    mkdir($dir);

// Declarar la ruta y nombre del archivo a generar
$filename = $dir.'test.png';

// Parámetros de configuración
$tamaño = 10; // Tamaño de pixel
$level = 'L'; // Precisión baja
$framSize = 3; // Tamaño en blanco
$contenido = "http://codigosdeprogramacion.com"; // Texto

// Enviar los parámetros a la función para generar el código QR
QRcode::png($contenido, $filename, $level, $tamaño, $framSize);

// Mostrar la imagen generada
echo '<img src="'.$dir.basename($filename).'" /><hr/>';



</form>

