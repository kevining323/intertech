<?php
// 1️⃣ Cargar PHPMailer desde la carpeta "phpmailer" descargada de GitHub
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';

// 2️⃣ Recibir datos del formulario
$nombre  = $_POST['nombres'];
$apellido   = $_POST['apellidos'];
$telefono   = $_POST['telefono'];
$correo  = $_POST['correo'];

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
    $mail->addReplyTo($correo, $nombre); // 📤 Para poder responder al remitente

    // 6️⃣ Contenido del correo
    $mail->isHTML(true);
    $mail->Subject = "Nuevo mensaje desde el formulario de Brochure";
    $mail->Body    = "
        <h2>Nuevo mensaje recibido</h2>
        <p><strong>Nombres:</strong> $nombre</p>
        <p><strong>Apellidos:</strong> $apellido</p>
        <p><strong>Telefono:</strong> $telefono</p>
        <p><strong>Correo:</strong> $correo</p>
    ";

    // 7️⃣ Enviar correo
    $mail->send();

    header("Location: brochuure.html?descargar=1");
exit();


} catch (Exception $e) {
    echo "<script>
      alert('❌ Error al enviar el mensaje: {$mail->ErrorInfo}');
      window.location.href='contactanos.html';
    </script>";
}
?>
