<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer files
require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $recipientEmail = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    if (!filter_var($recipientEmail, FILTER_VALIDATE_EMAIL)) {
        die("❌ Invalid recipient email address!");
    }

    // Create PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        // Debugging (Set to 0 for no debug output)
        $mail->SMTPDebug = 0; // 0 = Off, 1 = Basic, 2 = Full Debugging
        $mail->Debugoutput = 'html';

        // SMTP Settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'vaibhavkumarsingh2112@gmail.com'; // ✅ Your Gmail
        $mail->Password   = 'igut idkn zvyc okuo'; // ✅ Use Gmail App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Sender & Recipient
        $mail->setFrom('vaibhavkumarsingh2112@gmail.com', 'Vaibhav Kumar Singh');
        $mail->addAddress($recipientEmail); // ✅ Dynamic recipient email from form

        // Email Content
        $mail->isHTML(true);
        $mail->Subject = $subject;  // ✅ Dynamic subject
        $mail->Body    = nl2br($message); // ✅ Dynamic message
        $mail->AltBody = strip_tags($message);

        // Send Email
        if ($mail->send()) {
            echo "<script>
                    alert('✅ Email sent successfully!');
                    window.location.href = 'index.php';
                  </script>";
        } else {
            echo "<script>
                    alert('❌ Email could not be sent.');
                    window.location.href = 'index.php';
                  </script>";
        }
    } catch (Exception $e) {
        echo "❌ Error: {$mail->ErrorInfo}";
    }
} else {
    echo "❌ Invalid request!";
}
?>
