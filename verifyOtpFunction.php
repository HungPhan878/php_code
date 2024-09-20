<?php
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

if (isset($_POST['verifyOtpFunc'])) {
    $entered_otp = $_POST['otp'];

    // Check session have otp
    if (isset($_SESSION['otp']) && isset($_SESSION['otp_created_at'])) {
        $otp = $_SESSION['otp'];
        $otp_created_at = $_SESSION['otp_created_at'];
        $current_time = time();

        if ($current_time - $otp_created_at <= 300) {

            if ($entered_otp == $otp) {
                $is_verify = 1;
                $stmt = $conn->prepare("UPDATE users set is_verify = ? where otp = ?");
                $stmt->bind_param("ii", $is_verify, $otp);
                if ($stmt->execute()) {
                    // Set database agian
                    $otpNull = null;
                    $stmt = $conn->prepare("UPDATE users set otp = ? where otp = ?");
                    $stmt->bind_param("ii", $otpNull, $otp);
                    $stmt->execute();

                    header("Location: ./loginFunction.php");
                    exit();
                } else {
                    echo "Lỗi: " . $stmt->error;
                }

                // Delete otp in session
                unset($_SESSION["otp"]);
                unset($_SESSION['otp_created_at']);
            } else {
                echo "Code OTP unexactly";
            }
        } else {
            echo "Code OTP expired.";
            // Expired delete otp in session
            unset($_SESSION["otp"]);
            unset($_SESSION['otp_created_at']);
        }
    } else {
        echo "Not found code OTP, Please register again.";
    }
}
