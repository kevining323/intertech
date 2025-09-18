<?php
header('Content-Type: application/json');

$destinatario = "incode98@gmail.com";

$nombre  = $_POST['nombre'] ?? '';
$email   = $_POST['email'] ?? '';
$asunto  = $_POST['asunto'] ?? '';
$mensaje = $_POST['mensaje'] ?? '';

$contenido = "Nombre: $nombre\nCorreo: $email\nAsunto: $asunto\n\nMensaje:\n$mensaje\n";
$cabeceras = "From: $nombre <$email>\r\nReply-To: $email\r\n";

if (mail($destinatario, "Nuevo mensaje de contacto: $asunto", $contenido, $cabeceras)) {
    echo json_encode(['estado' => 'ok', 'mensaje' => ' Mensaje enviado correctamente']);
} else {
    echo json_encode(['estado' => 'error', 'mensaje' => ' Error al enviar el mensaje']);
}
