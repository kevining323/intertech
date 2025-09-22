<?php
// Conexión a la base de datos (ajusta según tus credenciales en cPanel)
$servername = "localhost";
$username = "TU_USUARIO_CPANEL";
$password = "TU_PASSWORD";
$dbname = "TU_BASEDEDATOS";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}

// Recibir datos del formulario
$nombres = $_POST['nombres'];
$apellidos = $_POST['apellidos'];
$telefono = $_POST['telefono'];
$correo = $_POST['correo'];

// Procesar archivo CV
$directorio = "uploads/";
if (!is_dir($directorio)) {
    mkdir($directorio, 0777, true);
}

$archivoCV = $directorio . basename($_FILES["cv"]["name"]);
$tipoArchivo = strtolower(pathinfo($archivoCV, PATHINFO_EXTENSION));

// Validar formato
if ($tipoArchivo != "pdf" && $tipoArchivo != "doc" && $tipoArchivo != "docx") {
    die("Solo se permiten archivos PDF o Word.");
}

// Mover archivo
if (move_uploaded_file($_FILES["cv"]["tmp_name"], $archivoCV)) {
    // Guardar datos en la base de datos
    $sql = "INSERT INTO postulaciones (nombres, apellidos, telefono, correo, cv)
            VALUES ('$nombres', '$apellidos', '$telefono', '$correo', '$archivoCV')";

    if ($conn->query($sql) === TRUE) {
        echo "Tu postulación fue enviada con éxito 🎉";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "Error al subir el archivo.";
}

$conn->close();
?>
