<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

error_log("Email sending script started - ");

// Capture POST data
$username = $_POST['username'] ?? 'Not provided';
$email = $_POST['email'] ?? 'Not provided';
$phone = $_POST['phone'] ?? 'Not provided';
$subject = $_POST['subject'] ?? 'Not provided';
$message = $_POST['message'] ?? 'Not provided';

// Log the received data
error_log("Form Data Received:");
error_log("Username: " . $username);
error_log("Email: " . $email);
error_log("Phone: " . $phone);
error_log("Subject: " . $subject);
error_log("Message: " . $message);

require 'vendor/autoload.php';
$mail = new PHPMailer(true);

try {
    error_log("Attempting to send email to: ramez.bhatt@gmail.com");
    
    $mail->isSMTP();
    $mail->Host       = getenv('SMTP_SERVER');
    $mail->SMTPAuth   = true;
    $mail->Username   = getenv('SMTP_USERNAME');
    $mail->Password   = getenv('SMTP_PASSWORD');
    
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = getenv('SMTP_PORT');
    
    $mail->setFrom('rameez.bhat@lockular.in', 'Origin Matters');
    $mail->addAddress("nick.evans@originmatters.co");
    $mail->isHTML(true);
    
    // Use the captured form data in the email
    $mail->Subject = "New Contact Form Submission: $subject";
    $mail->Body    = "
        <strong>Name:</strong> $username<br>
        <strong>Email:</strong> $email<br>
        <strong>Phone:</strong> $phone<br>
        <strong>Subject:</strong> $subject<br>
        <strong>Message:</strong><br>$message
    ";
    $mail->AltBody = "
        Name: $username
        Email: $email
        Phone: $phone
        Subject: $subject
        Message: $message
    ";
    
    $mail->send();
    error_log("Email sent successfully");
    echo json_encode([
        'success' => true,
        'message' => 'Message has been sent',
        'data' => [
            'username' => $username,
            'email' => $email,
            'phone' => $phone,
            'subject' => $subject,
            'message' => $message
        ]
    ]);
} catch (Exception $e) {
    $errorMessage = "Email sending failed - Error: {$mail->ErrorInfo}";
    error_log($errorMessage);
    echo json_encode([
        'success' => false,
        'message' => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}",
        'data' => [
            'username' => $username,
            'email' => $email,
            'phone' => $phone,
            'subject' => $subject,
            'message' => $message
        ]
    ]);
}

error_log("Email sending script completed - ");
?>