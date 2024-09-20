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

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// function handler
function validateBirthday($birthday)
{
  // Tạo đối tượng DateTime từ chuỗi ngày tháng
  $date = DateTime::createFromFormat('Y-m-d', $birthday);

  // Kiểm tra định dạng và giá trị của ngày
  if (!$date || $date->format('Y-m-d') !== $birthday) {
    return false; // Ngày không hợp lệ
  }

  // Kiểm tra xem năm có trong khoảng cho phép không, ví dụ từ 1900 đến hiện tại
  $year = (int) $date->format('Y');
  if ($year < 1900 || $year > date('Y')) {
    return false; // Năm không hợp lệ
  }

  return true;
}

// Hàm xử lý khi post từ form
if (isset($_POST["deleteStudentFunc"])) {
  $id = $_POST["id"];

  $sql = "DELETE from register where student_Id = $id;DELETE from students where id = $id";


  if ($conn->multi_query($sql) === true) {
    header("location: " . $_SERVER['HTTP_REFERER']);
    exit();
  } else {
    echo "Error deleting record: " . $conn->error;
  }
} else if (isset($_POST["deleteTeacherFunc"])) {
  $id = $_POST["id"];

  $sql = "DELETE from teachers where id = $id";
  if ($conn->query($sql)) {
    header("location: " . $_SERVER['HTTP_REFERER']);
    exit();
  } else {
    echo "Error";
  }
} else if (isset($_POST['insertfunc'])) {
  $email = $_POST["email"];
  $name = $_POST["name"];
  $address = $_POST["address"];
  $birthday = $_POST["birthday"];

  $sql = "INSERT INTO teachers (Email, Name, Address, Birthday) VALUES ('$email', '$name', '$address', '$birthday')";

  if (mysqli_query($conn, $sql)) {
    echo "New record created successfully";
  } else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }
  mysqli_close($conn);
} else if (isset($_POST['insertStudentFunc'])) {

  $email = $_POST["email"];
  $name = $_POST["name"];
  $address = $_POST["address"];
  $birthday = $_POST["birthday"];

  $target_dir = "uploadsImage/";
  $target_dir_video = "uploadsVideo/";
  $uploaded_files = [];
  $uploaded_files_video = [];

  // kiểm tra date
  if (!validateBirthday($birthday)) {
    echo "Ngày sinh không hợp lệ, vui lòng nhập lại.";
  }

  // Xử lý tệp hình ảnh tải lên
  if (isset($_FILES['fileImage']['name'])) {
    foreach ($_FILES['fileImage']['name'] as $key => $file_name) {
      if ($_FILES['fileImage']['error'][$key] == 0) {
        $target_file = $target_dir . basename($file_name);
        $tmp_name = $_FILES['fileImage']['tmp_name'][$key];
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $uploadOk = 1;

        // Kiểm tra nếu tệp là ảnh
        $check = getimagesize($_FILES["fileImage"]["tmp_name"][$key]);
        if ($check !== false) {
          $uploadOk = 1;
        } else {
          echo "File is not an image.";
          $uploadOk = 0;
        }

        // Kiểm tra nếu file đã tồn tại
        if (file_exists($target_file)) {
          $target_file = $target_file; // Bạn có thể thay đổi tên tệp để tránh trùng lặp nếu muốn
        }

        // Kiểm tra kích thước file
        if ($_FILES["fileImage"]["size"][$key] > 500000) {
          echo "Sorry, your file is too large.";
          $uploadOk = 0;
        }

        // Chỉ cho phép các định dạng file ảnh nhất định
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
          echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
          $uploadOk = 0;
        }

        // Kiểm tra biến $uploadOk để tiếp tục xử lý tải file
        if ($uploadOk == 1) {
          if (move_uploaded_file($tmp_name, $target_file)) {
            $uploaded_files[] = basename($file_name);
          } else {
            echo "Lỗi khi tải lên tệp: " . $file_name;
          }
        }
      }
    }
  }

  // Xử lý video
  if (isset($_FILES['video_url']['name'])) {

    foreach ($_FILES['video_url']['name'] as $key => $nameVideo) {
      if ($_FILES['video_url']['error'][$key] == 0) {
        $target_file_video = $target_dir_video . basename($nameVideo);
        $uploadOk = 1;
        $videoFileType = strtolower(pathinfo($target_file_video, PATHINFO_EXTENSION));
        $tmp_name = $_FILES["video_url"]["tmp_name"][$key];

        // Kiểm tra định dạng file video
        $allowedTypes = ['mp4', 'avi', 'mov', 'mpeg'];
        if (!in_array($videoFileType, $allowedTypes)) {
          echo "Sorry, only MP4, AVI, MOV, and MPEG files are allowed.";
          $uploadOk = 0;
        }

        // Kiểm tra nếu $uploadOk để xử lý tải lên
        if ($uploadOk == 1) {
          if (move_uploaded_file($tmp_name, $target_file_video)) {
            $uploaded_files_video[] = basename($nameVideo); // Lưu tên file vào mảng
          } else {
            echo "Sorry, there was an error uploading your video: " . basename($nameVideo);
          }
        }
      }
    }
  } else {
    echo "No video file uploaded.";
  }

  // Lưu vào cơ sở dữ liệu
  $image_paths = implode(",", $uploaded_files);
  $image_paths_video = implode(",", $uploaded_files_video);
  $stmt = $conn->prepare("INSERT INTO students (EMAIL, Name, Address, Birthday, Image, Video_url) 
      values (?,?,?,?,?,?)");
  $stmt->bind_param("sssiss", $email, $name, $address, $birthday, $image_paths, $image_paths_video);
  if ($stmt->execute()) {
    //  auto send email
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
      $mail->setFrom('hungphanhung8@gmail.com', 'PhanHùng');
      $mail->addAddress($email, $name);
      $mail->isHTML(true);
      $mail->Subject = 'Test PHPMailer';
      $mail->Body    = 'BẠN ĐÃ THÊM SINH VIÊN THÀNH CÔNG';
      $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

      $mail->send();
      echo 'Message has been sent';
    } catch (Exception $e) {
      echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

    header("Location: ./index.php");
    exit();
  } else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }
  mysqli_close($conn);
} else if (isset($_POST["insertClassFunc"])) {
  $name = $_POST["name"];
  $date = $_POST["date"];
  $teacher_Id = $_POST["id"];

  $stmt = $conn->prepare("INSERT into classes (Name, Date, teacher_Id) values(?, ?, ?)");
  $stmt->bind_param("ssi", $name, $date, $teacher_Id);


  if ($stmt->execute()) {
    echo "New record created successfully";
  } else {
    echo "Error: " . $mysql . "<br>" . mysqli_error($conn);
  }

  $stmt->close();
} else  if (isset($_POST["updateStudentFunc"])) {
  $id = htmlspecialchars($_POST["id"]);
  $name = htmlspecialchars($_POST["name"]);
  $address = htmlspecialchars($_POST["address"]);
  $email = htmlspecialchars($_POST["email"]);
  $birthday = htmlspecialchars(($_POST["birthday"]));
  $image = htmlspecialchars(($_POST["fileImage"]));
  // Xử lý tệp tải lên
  if (isset($_FILES['fileImage']) && $_FILES['fileImage']['error'] == 0) {
    // Đường dẫn và tên tệp
    $target_dir = "uploadsImage/";
    $target_file = $target_dir . basename($_FILES["fileImage"]["name"]);
    $url_file = basename($_FILES["fileImage"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Kiểm tra nếu tệp là ảnh
    $check = getimagesize($_FILES["fileImage"]["tmp_name"]);
    if ($check !== false) {
      $uploadOk = 1;
    } else {
      echo "File is not an image.";
      $uploadOk = 0;
    }

    // Kiểm tra nếu file đã tồn tại
    if (file_exists($target_file)) {
      $target_file = $target_file;
    }

    // Kiểm tra kích thước file
    if ($_FILES["fileImage"]["size"] > 500000) {
      echo "Sorry, your file is too large.";
      $uploadOk = 0;
    }

    // Chỉ cho phép các định dạng file ảnh nhất định
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
      echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      $uploadOk = 0;
    }

    // Kiểm tra biến $uploadOk để tiếp tục xử lý tải file
    if ($uploadOk == 0) {
      echo "Sorry, your file was not uploaded.";
    } else {
      if (move_uploaded_file($_FILES["fileImage"]["tmp_name"], $target_file)) {

        // luu vao database
        $sql = "UPDATE students set Name = '$name', EMAIL = '$email', Address = '$address', 
          Birthday = '$birthday', Image= '$url_file' where id = $id";
        if ($conn->query($sql) === true) {
          header("location: ./index.php?update=success");
          exit();
        } else {
          echo "Error";
        }
        mysqli_close($conn);
      } else {
        echo "Sorry, there was an error uploading your file.";
      }
    }
  } else {
    echo "No file uploaded or there was an error uploading the file.";
  }
}

$conn->close();
