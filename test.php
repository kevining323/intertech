<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';


$mail = new PHPMailer(true);

try {
    // Configuración SMTP
    $mail->isSMTP();
    $mail->Host       = 'mail.intertechperu.net';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'contacto@intertechperu.net';
    $mail->Password   = 'M4yDBnl25SYA;,^x';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // <— Importante: SSL/TLS desde el inicio
    $mail->Port       = 465;                         // <— Puerto correcto
    $mail->Timeout    = 20;                          // Evita que se quede colgado eternamente

    // Información del correo
    $mail->setFrom('contacto@intertechperu.net', 'Intertech');
    $mail->addAddress('contacto@intertechperu.net'); // prueba con tu correo personal

    $mail->isHTML(true);
    $mail->Subject = '✅ Prueba de conexión SMTP';
    $mail->Body    = '<b>¡Hola!</b> Este correo fue enviado exitosamente desde PHPMailer.';

    // Envío
    $mail->send();
    echo '📨 Correo enviado correctamente ✅';
} catch (Exception $e) {
    echo "❌ Error al enviar el mensaje: {$mail->ErrorInfo}";
}
?>