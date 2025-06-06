<?php 
/* 
    __DIR__ is a constant that contains the path to the directory where it is called.
        Example: Here, it holds the full path to the "service" folder.

    This allows me to always have a valid path, no matter where "_mailer.php" is required from.

    autoload.php – this autoloader helps us avoid requiring every library manually.
    When it detects that a new class is being used, it will automatically try to require the corresponding file.
*/

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__."/../../vendor/autoload.php";

/**
 * Sends an email
 *
 * @param string $from Sender of the email
 * @param string $to Recipient of the email
 * @param string $subject Subject of the email
 * @param string $body Content of the email
 * @return string Success or error message
 */
function sendMail(string $from, string $to, string $subject, string $body): string
{
    try
    {
        /* 
            Create a new PHPMailer object
            The "true" parameter enables exceptions
        */
        $mail = new PHPMailer(true);
        /* 
            Enable SMTP connection
            PHPMailer will connect to a mail server via SMTP
            (Simple Mail Transfer Protocol)
        */
        $mail->isSMTP();
        /* 
            Mail server address.
            Any mail server can be used — if you have a Gmail, Hotmail account, etc.
            For testing purposes here, we’ll use "mailtrap",
            A service that captures emails and creates a mini inbox for testing.
        */
        $mail->Host = "ChangeMe";
        // Enable SMTP authentication
        $mail->SMTPAuth = true;
        // Port used by the mail server
        $mail->Port = 2525;
        // Mail server username
        $mail->Username = "ChangeMe";
        $mail->Password = "ChangeMe";

        // Shows detailed info about the request process
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        // Secures email sending (not compatible with mailtrap)
        // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;

        // Set the sender of the email
        $mail->setFrom($from);
        // Add a recipient
        $mail->addAddress($to);
        /* 
            You can also use methods like:
                - addReplyTo
                - addCC
                - addBCC
                - addAttachment

            isHTML enables HTML content in the email
        */
        $mail->isHTML(true);
        // Set the subject of the email
        $mail->Subject = $subject;
        // Set the email content
        $mail->Body = $body;
        /* 
            Optionally, you can add an "AltBody" which will be shown 
            if the recipient's email client doesn't support HTML.
        */
        $mail->send();
        return "Email sent";
    }
    // catch(PHPMailer\PHPMailer\Exception $error)
    catch(Exception $error)
    {
        return "The email could not be sent. Mailer Error: {$error->ErrorInfo}";
    }
}

// sendMail("maurice@gmail.com", "pierre@gmail.com", "My first email", "<h1>I just sent an email!</h1>");
