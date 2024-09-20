<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
</head>

<body>

    <?php

    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);


    $servername = "localhost:3306";
    $username = "root";
    $password = "root";
    $dbname = "academy";
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    if (isset($_POST["editStudentFunc"])) {
        $id = $_POST["id"];
        $sql = "SELECT * from students where id = $id";
        $student_result = $conn->query($sql);

        if ($student_result->num_rows > 0) {
            while ($row = $student_result->fetch_assoc()) {
                $name =  $row["Name"];
                $email = $row["EMAIL"];
                $address = $row["Address"];
                $birthday = $row["Birthday"];
                $images = $row["Image"];
                $avatar = null;
                $image = null;
                // $avatars
                if (is_string($images)) {
                    $avatars = explode(',', $images);
                };
                $avatar = $avatars ? $avatars[0] : 'null';

                echo "<form action='function.php' method='post' enctype='multipart/form-data' class='container mt-5'>

                      <div class='row mb-3'>
                        <label for='email' class='form-label col-md-2'>Email</label>
                      <div class='col-md-10'>
                        <input type='email' name='email' value='$email' class='form-control' id='email' placeholder='name@example.com'>
                     </div>
                       <input type='number' name='id' value='$id' hidden>
                     </div>

    <div class='row mb-3'>
        <label for='name' class='form-label col-md-2'>Name</label>
        <div class='col-md-10'>
            <input type='text' name='name' value='$name' class='form-control' id='name' placeholder='Name'>
        </div>
    </div>

    <div class='row mb-3'>
        <label for='address' class='form-label col-md-2'>Address</label>
        <div class='col-md-10'>
            <input type='text' name='address' value='$address' class='form-control' id='address' placeholder='Address'>
        </div>
    </div>

    <div class='row mb-3'>
        <label for='birthday' class='form-label col-md-2'>Birthday</label>
        <div class='col-md-10'>
            <input type='date' name='birthday' value='$birthday' class='form-control' id='birthday'>
        </div>
    </div>

    <div class='row mb-3'>
        <label for='fileImage' class='form-label col-md-2'>Upload Image</label>
        <div class='col-md-10'>
            <input type='file' name='fileImage' class='form-control' id='fileImage'>
        </div>
    </div>

    <div class='row mb-3'>
        <label class='form-label col-md-2'>Image Previous</label>
        <div class='col-md-10'>
            <p>Image</p>       
            <img src='$image' alt='$name' class='img-fluid' style='width:300px; height:300px; object-fit:contain;'/>
        </div>
    </div>

    <div class='row'>
        <div class='col-md-10 offset-md-2'>
            <input type='submit' name='updateStudentFunc' value='Update Student' class='btn btn-primary'>
        </div>
    </div>
</form>";
            }
        } else {
            echo "NOT FOUND";
        }
    }
    $conn->close();
    ?>
</body>

</html>