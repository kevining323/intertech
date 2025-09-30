<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Incluir PHPMailer
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';

// Asegurar que el formulario se envió por POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit("Acceso no autorizado.");
}


// Recibir datos del formulario
$nombre  = $_POST['nombre'];
$cargo   = $_POST['cargo'];
$email   = $_POST['email'];
$asunto  = $_POST['asunto'];
$mensaje = $_POST['mensaje'];

// Crear instancia
$mail = new PHPMailer(true);

try {
    // Configuración del servidor SMTP de cPanel 
    $mail->isSMTP();
    $mail->Host       = 'contacto@intertechperu.net';      // DOMINIO
    $mail->SMTPAuth   = true;
    $mail->Username   = 'contacto@intertechperu.net';  // CORREO en cPanel
    $mail->Password   = 'M4yDBnl25SYA;,^x';             // ← Contraseña del correo
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Configuración del remitente y destinatario
    $mail->setFrom('contacto@intertechperu.net', 'Formulario Intertech'); // desde
    $mail->addAddress('contacto@intertechperu.net', 'Intertech');         // 📥 hacia
    $mail->addReplyTo($email, $nombre);                               // para responder al usuario

    // Contenido del correo
    $mail->isHTML(true);
    $mail->Subject = "Nuevo mensaje desde el formulario de contacto";
    $mail->Body    = "
        <h2>Nuevo mensaje recibido</h2>
        <p><strong>Nombre:</strong> $nombre</p>
        <p><strong>Cargo:</strong> $cargo</p>
        <p><strong>Correo:</strong> $email</p>
        <p><strong>Asunto:</strong> $asunto</p>
        <p><strong>Mensaje:</strong><br>$mensaje</p>
    ";

    // Enviar correo
    $mail->send();

    echo "<script>
      alert('Tu mensaje fue enviado correctamente. Pronto nos pondremos en contacto contigo.');
      window.location.href='contactanos.html';
    </script>";
} catch (Exception $e) {
    echo "<script>
      alert('Error al enviar el mensaje: {$mail->ErrorInfo}');
      window.location.href='contactanos.html';
    </script>";
}
?>
    