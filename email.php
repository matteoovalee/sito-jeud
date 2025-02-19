<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

// Configurazione SMTP di Aruba
$mail_host = 'smtp.aruba.it';
$mail_username = 'info@jeud.it'; // Modifica con il tuo indirizzo email
$mail_password = 'tua_password'; // Modifica con la tua password
$mail_from = 'info@jeud.it';
$mail_to = 'info@jeud.it';

// Controlla quale modulo è stato inviato
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = $mail_host;
        $mail->SMTPAuth = true;
        $mail->Username = $mail_username;
        $mail->Password = $mail_password;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom($mail_from, 'JEUD Contact Form');
        $mail->addAddress($mail_to);

        if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['message'])) {
            // Modulo Contattaci
            $name = htmlspecialchars($_POST['name']);
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $message = nl2br(htmlspecialchars($_POST['message']));
            
            $mail->Subject = "Nuovo messaggio da $name";
            $mail->Body = "Nome / Azienda: $name<br>Email: $email<br>Messaggio:<br>$message";
            $mail->isHTML(true);
        } elseif (isset($_POST['student_name']) && isset($_POST['student_email']) && isset($_FILES['student_cv'])) {
            // Modulo Candidatura Studente
            $name = htmlspecialchars($_POST['student_name']);
            $email = filter_var($_POST['student_email'], FILTER_SANITIZE_EMAIL);
            $message = isset($_POST['student_message']) ? nl2br(htmlspecialchars($_POST['student_message'])) : 'Nessun messaggio';
            
            $mail->Subject = "Nuova candidatura da $name";
            $mail->Body = "Nome e Cognome: $name<br>Email: $email<br>Messaggio:<br>$message";
            $mail->isHTML(true);
            
            // Gestione allegato
            if ($_FILES['student_cv']['error'] === UPLOAD_ERR_OK) {
                $tmp_name = $_FILES['student_cv']['tmp_name'];
                $file_name = basename($_FILES['student_cv']['name']);
                $mail->addAttachment($tmp_name, $file_name);
            }
        } else {
            exit('Dati non validi.');
        }

        $mail->send();
        echo 'Email inviata con successo!';
    } catch (Exception $e) {
        echo "Errore nell'invio dell'email: " . $mail->ErrorInfo;
    }
} else {
    exit('Accesso non autorizzato.');
}
?>
