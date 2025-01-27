<?php
// Include the Composer autoload file for PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Adjust the path to PHPMailer's autoload.php

header('Content-Type: application/json');

// Ensure the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data with validation
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $message = $_POST['message'] ?? '';

    // Simple validation: ensure no fields are empty
    if (empty($name) || empty($email) || empty($message)) {
        echo json_encode(['success' => false, 'error' => 'All fields are required']);
        exit();
    }

    // Create PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        // Server settings for Gmail SMTP
        $mail->isSMTP();  // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';  // SMTP server (Gmail)
        $mail->SMTPAuth = true;
        $mail->Username = 'your_email@gmail.com';  // Your Gmail address
        $mail->Password = 'your_password';  // Your Gmail password (or app-specific password)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('your_email@gmail.com', 'Mailer');  // Your email address
        $mail->addAddress('vincentmango2018@gmail.com', 'Recipient Name');  // Recipient email address

        // Email content
        $mail->isHTML(true);
        $mail->Subject = 'New Contact Form Submission';
        $mail->Body = "Name: $name<br>Email: $email<br>Message: $message";  // HTML message body

        // Send the email
        if ($mail->send()) {
            echo json_encode(['success' => true, 'message' => 'Message sent successfully']);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to send email']);
        }
    } catch (Exception $e) {
        // Catch any errors
        echo json_encode(['success' => false, 'error' => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"]);
    }

    exit();
} else {
    // Invalid request method
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
    exit();
}

// Handling feedback submission (rating and comment)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rating = $_POST['rating'] ?? null;
    $comment = $_POST['comment'] ?? '';

    // Ensure rating and comment are not empty
    if ($rating !== null && !empty($comment)) {
        // Insert into the database (example with MySQL)
        // $conn = new mysqli($servername, $username, $password, $dbname);
        // $stmt = $conn->prepare("INSERT INTO feedback (rating, comment) VALUES (?, ?)");
        // $stmt->bind_param("is", $rating, $comment);
        // $stmt->execute();
        
        // Close the connection (uncomment once DB code is in use)
        // $stmt->close();
        // $conn->close();
    }
}
?>
