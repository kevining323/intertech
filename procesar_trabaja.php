<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Incluir PHPMailer
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';

// Verificar envío del formulario
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit("Acceso no autorizado.");
}

// Recibir datos del formulario
$nombres   = $_POST['nombres'] ?? '';
$apellidos = $_POST['apellidos'] ?? '';
$telefono  = $_POST['telefono'] ?? '';
$correo    = $_POST['correo'] ?? '';

// Validar archivo
if (!isset($_FILES['cv']) || $_FILES['cv']['error'] != 0) {
    die(" Error al recibir el CV. Asegúrate de subir un archivo PDF o Word.");
}

// Validar tipo de archivo
$tipoArchivo = strtolower(pathinfo($_FILES["cv"]["name"], PATHINFO_EXTENSION));
if ($tipoArchivo != "pdf" && $tipoArchivo != "doc" && $tipoArchivo != "docx") {
    die(" Solo se permiten archivos PDF o Word.");
}

// Crear instancia de PHPMailer
$mail = new PHPMailer(true);

try {
    // 📡 Configuración del servidor SMTP de tu cPanel
    $mail->isSMTP();
    $mail->Host       = 'contacto@intertechperu.net';     // Ajusta si cPanel te da otro host
    $mail->SMTPAuth   = true;
    $mail->Username   = 'contacto@intertechperu.net'; // Tu correo corporativo
    $mail->Password   = 'M4yDBnl25SYA;,^x';           // Contraseña de ese correo
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // 📤 Correo principal (a la empresa)
    $mail->setFrom('contacto@intertechperu.net', 'Bolsa de Trabajo Intertech');
    $mail->addAddress('contacto@intertechperu.net', 'RRHH Intertech');
    $mail->addReplyTo($correo, "$nombres $apellidos");

    // Adjuntar CV directamente desde $_FILES sin guardarlo en el servidor
    $mail->addStringAttachment(file_get_contents($_FILES['cv']['tmp_name']), $_FILES['cv']['name']);

    // Contenido del correo a la empresa
    $mail->isHTML(true);
    $mail->Subject = "📩 Nueva postulación recibida";
    $mail->Body    = "
        <h2>📬 Nueva postulación desde 'Trabaja con Nosotros'</h2>
        <p><strong>Nombre:</strong> $nombres $apellidos</p>
        <p><strong>Teléfono:</strong> $telefono</p>
        <p><strong>Correo:</strong> $correo</p>
        <p>📎 Se ha adjuntado el CV del postulante.</p>
    ";

    // Enviar a la empresa
    $mail->send();

    // 📧 Enviar confirmación al postulante
    $confirmacion = new PHPMailer(true);
    $confirmacion->isSMTP();
    $confirmacion->Host       = 'contacto@intertechperu.net';
    $confirmacion->SMTPAuth   = true;
    $confirmacion->Username   = 'contacto@intertechperu.net';
    $confirmacion->Password   = 'M4yDBnl25SYA;,^x';
    $confirmacion->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $confirmacion->Port       = 587;

    $confirmacion->setFrom('contacto@intertechperu.net', 'Intertech RRHH');
    $confirmacion->addAddress($correo, "$nombres $apellidos");

    $confirmacion->isHTML(true);
    $confirmacion->Subject = "Confirmación de tu postulación";
    $confirmacion->Body    = "
        <h2>¡Hola, $nombres! </h2>
        <p>Hemos recibido tu postulación correctamente en <strong>Intertech</strong>.</p>
        <p> Nuestro equipo de Recursos Humanos revisará tu CV y, si cumples con el perfil, nos pondremos en contacto contigo pronto.</p>
        <p>Gracias por tu interés en formar parte de nuestro equipo. 💼</p>
        <br>
        <p>— Equipo Intertech</p>
    ";

    $confirmacion->send();

    echo "<script>
      alert('Tu postulación fue enviada con éxito y hemos enviado un correo de confirmación a tu bandeja de entrada.');
      window.location.href='trabaja_con_nosotros.html';
    </script>";

} catch (Exception $e) {
    echo "<script>
      alert('Error al enviar el correo: {$mail->ErrorInfo}');
      window.location.href='trabaja_con_nosotros.html';
    </script>";
}
?>
