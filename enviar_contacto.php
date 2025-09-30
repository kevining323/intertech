<?php
// 1️⃣ Cargar PHPMailer desde la carpeta "phpmailer" descargada de GitHub
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';

// 2️⃣ Recibir datos del formulario
$nombre  = $_POST['nombre'];
$cargo   = $_POST['cargo'];
$email   = $_POST['email'];
$asunto  = $_POST['asunto'];
$mensaje = $_POST['mensaje'];

// 3️⃣ Crear instancia
$mail = new PHPMailer(true);

try {
    // 4️⃣ Configuración del servidor SMTP de tu hosting
    $mail->isSMTP();
    $mail->Host       = 'mail.intertechperu.net';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'contacto@intertechperu.net';
    $mail->Password   = 'M4yDBnl25SYA;,^x';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // <— Importante: SSL/TLS desde el inicio
    $mail->Port       = 465;                         // <— Puerto correcto
    $mail->Timeout    = 20;                        // ✅ Puerto seguro

    // 5️⃣ Configurar remitente y destinatario
    $mail->setFrom('contacto@intertechperu.net', 'Formulario Intertech');
    $mail->addAddress('contacto@intertechperu.net', 'Intertech'); // 📥 Donde recibes los mensajes
    $mail->addReplyTo($email, $nombre); // 📤 Para poder responder al remitente

    // 6️⃣ Contenido del correo
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

    // 7️⃣ Enviar correo
    $mail->send();

    echo "<script>
      alert('✅ Tu mensaje fue enviado correctamente. Pronto nos pondremos en contacto contigo.');
      window.location.href='contactanos.html';
    </script>";
} catch (Exception $e) {
    echo "<script>
      alert('❌ Error al enviar el mensaje: {$mail->ErrorInfo}');
      window.location.href='contactanos.html';
    </script>";
}
?>
