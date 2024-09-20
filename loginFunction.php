<?php

// initial session
session_start();

$servername = "localhost:3306";
$username = "root";
$password = "root";
$dbname = "academy";



// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

if ($_SESSION['email'] && $_SESSION['email_created_at'] - time() <= 864.000) {
  $email = htmlspecialchars($_SESSION['email']);
  $stmt = $conn->prepare("SELECT * from users where email = ?");
  $stmt->bind_param('s', $email);
  if ($stmt->execute()) {
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      if ($row['is_verify'] == 1) {
        header("Location: ./index.php?login=success");
        exit();
      } else {
        echo "Tài khoản chưa được xác minh.";
        die;
      }
    }
  }

  $stmt->close();
} else {
  // when login 
  if (isset($_POST['loginFunc'])) {
    // delete email and created at email expired
    unset($_SESSION["email"]);
    unset($_SESSION['email_created_at']);

    $email = $_POST['email'];
    $password = $_POST['password'];

    //Check email exists
    $checkUser = $conn->prepare("SELECT * from users where email = ?");
    $checkUser->bind_param("s", $email);
    $checkUser->execute();
    $result = $checkUser->get_result();
    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      if (password_verify($password, $row['password'])) {
        if ($row['is_verify'] == 1) {
          // create new email and date email 
          if (!empty($email)) {
            $_SESSION['email'] = $email;
            $_SESSION['email_created_at'] = time();
          }

          header("Location: ./index.php?login=success");
          exit();
        } else {
          echo "Tài khoản chưa được xác thực.";
        }
      }
    } else {
      echo "Mật khẩu hoặc Email không hợp lệ.";
    }
    $stmt->close();
  }
}


$conn->close();
