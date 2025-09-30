<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';

// 📥 1️⃣ Recibir datos del formulario
$nombre    = $_POST['nombre'];
$apellidos = $_POST['apellidos'];
$telefono  = $_POST['telefono'];
$correo    = $_POST['correo'];
$cargo     = $_POST['cargo'];

// 📎 2️⃣ Validar que se haya subido un archivo
if (!isset($_FILES['cv']) || $_FILES['cv']['error'] !== UPLOAD_ERR_OK) {
    die("<script>alert('❌ No se recibió ningún archivo o hubo un error al subirlo.'); window.history.back();</script>");
}

// 📁 3️⃣ Validar tipo de archivo
$tipoArchivo = strtolower(pathinfo($_FILES['cv']['name'], PATHINFO_EXTENSION));
if (!in_array($tipoArchivo, ['pdf', 'doc', 'docx'])) {
    die("<script>alert('❌ Solo se permiten archivos PDF o Word (.pdf, .doc, .docx).'); window.history.back();</script>");
}

// 📤 4️⃣ Enviar correo con PHPMailer
$mail = new PHPMailer(true);

try {
    // ⚙️ Configuración SMTP
    $mail->isSMTP();
    $mail->Host       = 'mail.intertechperu.net';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'reclutamiento@intertechperu.net';
    $mail->Password   = 'j{vK!-!^L8j8?d0H';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = 465;

    // 📤 Remitente y destinatario
    $mail->setFrom('reclutamiento@intertechperu.net', 'Formulario Intertech');
    $mail->addAddress('reclutamiento@intertechperu.net', 'Área de RRHH');
    $mail->addReplyTo($correo, "$nombre $apellidos");

    // 📎 5️⃣ Adjuntar el CV directamente desde el formulario
    $mail->addAttachment($_FILES['cv']['tmp_name'], $_FILES['cv']['name']);

    // ✉️ 6️⃣ Contenido del correo
    $mail->isHTML(true);
    $mail->Subject = "Nueva postulacion — $nombre $apellidos";
    $mail->Body    = "
        <h2>Nueva postulación recibida</h2>
        <p><strong>Nombre:</strong> $nombre $apellidos</p>
        <p><strong>Teléfono:</strong> $telefono</p>
        <p><strong>Correo:</strong> $correo</p>
        <p><strong>Cargo solicitado:</strong> $cargo</p>
        <p>📎 El CV está adjunto en este correo.</p>
    ";

    // 📤 7️⃣ Enviar el correo
    $mail->send();

    echo "<script>
      alert('✅Tu postulación fue enviada correctamente. Pronto nos pondremos en contacto contigo.');
      window.location.href = 'index.html';
    </script>";

} catch (Exception $e) {
    echo "<script>
      alert('Error al enviar el correo: {$mail->ErrorInfo}');
      window.location.href = 'contactanos.html';
    </script>";
}
?>
