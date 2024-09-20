<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

$servername = "localhost:3306";
$username = "root";
$password = "root";
$dbname = "academy";

// Initial session
session_start();

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}


if (isset($_POST['registerFunc'])) {
  $email = $_POST['email'];

  // Check password match
  if ($_POST['password'] == $_POST['confirmPassword']) {
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
  } else {
    echo "Confirm password no match.";
  }

  //Check email exists
  $check_email = $conn->prepare("SELECT * from users where email = ?");
  $check_email->bind_param("s", $email);
  $check_email->execute();
  $result = $check_email->get_result();
  if ($result->num_rows > 0) {
    echo "Email đã tồn tại";
  } else {
    // created OTP code
    $otp = rand(100000, 999999);
    $_SESSION['otp'] = $otp;
    $_SESSION['otp_created_at'] = time();
    $_SESSION['email'] = $email;
    $_SESSION['email_created_at'] = time();

    // Save info user into database
    $stmt = $conn->prepare("INSERT into users(email, password, otp) value(?, ?, ?)");
    $stmt->bind_param("ssi", $email, $password, $otp);
    if ($stmt->execute()) {
      // send OTP through gmail
      $mail = new PHPMailer(true);
      try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'hungphanhung8@gmail.com';                     //SMTP username
        $mail->Password   = 'yydz armz ffwz acco';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('hungphanhung8@gmail.com', 'Hung');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'YOUR OTP AUTHENTICATION CODE';
        $mail->Body    = "Mã OTP của bạn là: <b>$otp</b>";
        $mail->AltBody = 'Cảm ơn bạn đã đăng ký tài khoản.';

        $mail->send();

        header("Location: ./verifyOtp.php");
        exit();
      } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
      }
    }
    $stmt->close();
  }
}

$conn->close();
