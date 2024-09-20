<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
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
    <!-- Toast Notification -->
    <div aria-live="polite" aria-atomic="true" class="position-relative">
        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div id="successToast" class="toast bg-success text-white" role="alert" aria-live="assertive"
                aria-atomic="true" data-bs-delay="3000">
                <div class="toast-header">
                    <strong class="me-auto">Notification</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    Update thành công!
                </div>
            </div>
        </div>
    </div>

    <?php

  ini_set('display_errors', '1');
  ini_set('display_startup_errors', '1');
  error_reporting(E_ALL);

  // initial session
  session_start();

  $servername = "localhost:3306";
  $username = "root";
  $password = "root";
  $dbname = "academy";
  $dbname_minimart = "mini_mart";

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  $conn_mini_mart = new mysqli($servername, $username, $password, $dbname_minimart);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  if (isset($_SESSION['email']) && $_SESSION['email'] && $_SESSION['email_created_at'] - time() <= 864.000) {
    echo '
    <div class="my-5 d-flex justify-content-end">
    <a href="./insertStudentForm.php" class="display-block mx-3 btn btn-primary">Add Student</a>
    <a href="./insertTeacherForm.php" class="display-block mx-3 btn btn-primary">Add teacher</a>
    <a href="./insertClassForm.php" class="display-block mx-3 btn btn-primary">Add class</a>
    </div>';
  } else {
    echo '
      <div class="my-5 d-flex justify-content-end">
      <a href="./loginForm.php" class="display-block mx-3 btn btn-primary">LOG IN</a>
      <a href="./registerForm.php" class="display-block mx-3 btn btn-primary">REGISTER</a>
      </div>
      ';
  }

  $sql = "SELECT * FROM students";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    echo 'Câu 1: Tìm tất cả học viên';
    echo '<table class="table table-striped table-bordered">';
    echo '<thead class="thead-dark">
      <tr>
        <th scope="col">Id</th>
        <th scope="col">Name</th>
        <th scope="col">Email</th>
        <th scope="col">Address</th>
        <th scope="col">Avatar</th>
        <th scope="col">Video</th>
        <th scope="col">Birthday</th>
        <th scope="col">Delete</th>
        <th scope="col">Edit</th>
      </tr>
    </thead>';

    // output data of each row
    while ($row = $result->fetch_assoc()) {
      $id = $row["id"];
      $name =  $row["Name"];
      $email = $row["EMAIL"];
      $address = $row["Address"];
      $images = $row["Image"];
      $birthday = $row["Birthday"];
      $videos = $row["Video_url"];
      $avatars = null;
      $videoUrls = null;
      // Phải test điều kiện đoàng hoàng nha ;
      if (is_string($images)) {
        $avatars = explode(',', $images);
      }
      if (is_string($videos)) {
        $videoUrls = explode(',', $videos);
      }
      $avatar = $avatars ? $avatars[0] : 'girl.jpg';
      $videoUrl = $videoUrls ? $videoUrls[0] : 'karina.mp4';

      echo "<tr>
        <td>$id</td>
        <td>$name</td>
        <td>$email</td>
        <td>$address</td>
        <td><img src='uploadsImage/$avatar' alt='$name' class='img-thumbnail' style='width:100px; height:100px; object-fit:contain;'/></td>
        <td><video width='320' height='240' controls>
                <source src='uploadsVideo/$videoUrl' type='video/mp4'>
              Your browser does not support the video tag.
              </video>
        </td>
        <td>$birthday</td>
        <td>
          <form action='function.php' method='post'> 
            <input type='number' value='$id' name='id' hidden/>
            <input type='submit' class='btn btn-danger' name='deleteStudentFunc' value='Delete'>
          </form>
        </td>
        <td>
          <form action='updateStudentForm.php' method='post'> 
            <input type='number' value='$id' name='id' hidden/>
            <input type='submit' class='btn btn-primary' name='editStudentFunc' value='Edit'>
          </form>
        </td>
      </tr>";
    }
    echo '</table>';
  } else {
    echo "0 results";
  }

  $teacher = "SELECT * FROM teachers";
  $teacher_result = $conn->query($teacher);

  if ($teacher_result->num_rows > 0) {
    echo 'cau 1 - b: tìm tất cả giáo viên';
    echo '<table class="table table-bordered table-hover table-striped">';
    echo '<thead class="thead-dark">
  <tr>
    <th scope="col">Id</th>
    <th scope="col">Name</th>
    <th scope="col">Email</th>
    <th scope="col">Address</th>
    <th scope="col">Birthday</th>
    <th scope="col">Delete</th>
  </tr>
</thead>';
    while ($row = $teacher_result->fetch_assoc()) {
      $id = $row["id"];
      $name =  $row["Name"];
      $email = $row["Email"];
      $address = $row["Address"];
      $birthday = $row["Birthday"];

      echo "<tr>
            <td>$id</td> 
            <td>$name</td> 
            <td>$email</td> 
            <td>$address</td> 
            <td>$birthday</td>
            <td>
                <form action='function.php' method='post'>
                    <input type='number' name='id' value=$id hidden/>
                    <input type='submit' name='deleteTeacherFunc' value='Delete Teacher' class='btn btn-danger'/>
                </form>
            </td>
          </tr>";
    }
    echo '</table>';
  } else {
    echo "0 result";
  }

  $mysql2 = "SELECT students.id, students.name, classes.name as class, register.Date from students  inner join register on students.id = register.student_Id inner join classes on classes.id = register.class_Id where YEAR(register.Date) = '2024' and classes.name = 'lớp lập trình'";
  $result2 = $conn->query($mysql2);

  if ($result2->num_rows > 0) {
    echo 'cau 2: tìm tất cả các học viên trong lớp lập trình, đăng ký học trong năm 2024';
    echo '<table class="table">';
    echo '<thead>
    <tr>
      <th scope="col">Id</th>
      <th scope="col">Name</th>
      <th scope="col">Class</th>
      <th scope="col">Date_Register</th>
    </tr>
  </thead>';
    while ($row = $result2->fetch_assoc()) {
      $id = $row["id"];
      $name =  $row["name"];
      $class = $row["class"];
      $date = $row["Date"];

      echo "<tr><td>$id</td> <td>$name</td> <td>$class</td> <td>$date</td></tr>";
    }
    echo '</table>';
  } else {
    echo "0 results";
  }

  $mysql3 = "SELECT classes.name, count(register.class_Id) as count_student_register from classes inner join register on classes.id = register.class_Id group by register.class_Id HAVING count(register.class_Id) > 5";
  $result3 = $conn->query($mysql3);

  if ($result3->num_rows > 0) {
    echo 'cau 3: : tìm tất cả các lớp có trên 5 học viên';
    echo '<table class="table">';
    echo '<thead>
    <tr>
      <th scope="col">Course</th>
      <th scope="col">Total students register</th>
      
    </tr>
  </thead>';
    while ($row = $result3->fetch_assoc()) {
      $class = $row["name"];
      $count =  $row["count_student_register"];
      echo "<tr><td>$class</td> <td>$count</td></tr>";
    }
    echo '</table>';
  } else {
    echo "0 results";
  }

  $mysql4 = "SELECT students.name, count(register.student_Id) as count_class_register from teachers inner join classes on classes.teacher_Id = teachers.id inner join register on register.class_Id = classes.id INNER join students on register.student_Id = students.id where teachers.name = 'nhân' group by register.student_Id having count(register.student_Id) between 2 and 3";
  $result4 = $conn->query($mysql4);

  if ($result4->num_rows > 0) {
    echo 'cau 4: : tìm tất cả các học viên học từ 2 -> 3 lớp do thầy nhân dạy';
    echo '<table class="table">';
    echo '<thead>
    <tr>
      <th scope="col">Name</th>
      <th scope="col">Total classes register</th>
      
    </tr>
  </thead>';
    while ($row = $result4->fetch_assoc()) {
      $class = $row["name"];
      $count =  $row["count_class_register"];
      echo "<tr><td>$class</td> <td>$count</td></tr>";
    }
    echo '</table>';
  } else {
    echo "0 results";
  }

  $mysql5 = "SELECT sum(count_students) as total_students from (select classes.name, count(classes.id) as count_students from register inner join classes on classes.id = register.class_Id inner join students on register.student_Id = students.id where YEAR(register.Date) BETWEEN '2023' AND '2024' GROUP by classes.id) as subquery";
  $result5 = $conn->query($mysql5);

  if ($result5->num_rows > 0) {
    echo 'cau 5: tính tổng các học viên trong các lớp học từ năm 2023 đến 2024';
    echo '<table class="table">';
    echo '<thead>
    <tr>
      <th scope="col">Total students</th>
      
    </tr>
  </thead>';
    while ($row = $result5->fetch_assoc()) {
      $sum =  $row["total_students"];
      echo "<tr><td>$sum</td></tr>";
    }
    echo '</table>';
  } else {
    echo "0 results";
  }

  echo "Quản lý mini store";
  $mysql6 = "SELECT orders.order_name, sum(orders.total_Amount) as total_Amount_Sold from orders where year(orders.date) = 2024 and month(orders.date) >= 2 GROUP by orders.order_name having sum(orders.total_Amount) BETWEEN 100 and 1000";
  $result6 = $conn_mini_mart->query($mysql6);
  // echo không phải đối tượng thì mới log được, còn obj dùng var_dump

  if ($result6->num_rows > 0) {
    echo "Bài 1 : tìm ra danh sách các mặt hang bán từ 100k đến 1tr từ tháng 2 năm 2024";
    echo '<table class="table">';
    echo '<thead>
    <tr>
      <th scope="col">Product</th>
       <th scope="col">Total amount sold</th>
    </tr>
  </thead>';
    while ($row = $result6->fetch_assoc()) {
      $name = $row["order_name"];
      $total = $row["total_Amount_Sold"];

      echo "<tr><td>$name</td> <td>$total</td></tr>";
    }
    echo '</table>';
  } else {
    echo "0 results";
  }

  $mysql7 = "SELECT employees.emloyee_name, orders.employee_Id, sum(orders.total_Amount) as total_Amount_Sold_2024 FROM orders inner join employees on employees.emloyee_Id = orders.employee_Id WHERE year(orders.date) = 2024 GROUP by orders.employee_Id";
  $result7 = $conn_mini_mart->query($mysql7);

  if ($result7->num_rows > 0) {
    echo "bài 2: tính doanh số bán được của từng nhân viên bán hang năm 2024";
    echo '<table class="table">';
    echo '<thead>
    <tr>
       <th scope="col">Id</th>
       <th scope="col">Name</th>
       <th scope="col">Total amount sold 2024</th>
    </tr>
  </thead>';
    while ($row = $result7->fetch_assoc()) {
      $name = $row["emloyee_name"];
      $id = $row["employee_Id"];
      $total = $row["total_Amount_Sold_2024"];

      echo "<tr><td>$id</td> <td>$name</td> <td>$total</td></tr>";
    }
    echo '</table>';
  } else {
    echo "0 results";
  }

  $mysql8 = "SELECT customers.customer_name, sum(orders.buy_amount) as total_product_sold from orders inner join customers on customers.customer_Id = orders.customer_Id where year(orders.date) = 2024 group by orders.customer_Id ORDER by sum(orders.buy_amount) desc limit 3";
  $result8 = $conn_mini_mart->query($mysql8);

  if ($result8->num_rows > 0) {
    echo "bài 3 : tìm ba khách hang mua nhiều sản phẩm nhất năm 2024";
    echo '<table class="table">';
    echo '<thead>
    <tr>
       <th scope="col">Name</th>
       <th scope="col">Total product sold 2024</th>
    </tr>
  </thead>';
    while ($row = $result8->fetch_assoc()) {
      $name = $row["customer_name"];
      $total = $row["total_product_sold"];
      echo "<tr><td>$name</td> <td>$total</td></tr>";
    }
    echo '</table>';
  } else {
    echo "0 results";
  }

  $mysql9 = "SELECT employees.emloyee_name, orders.order_name, sum(orders.total_Amount) as revenue_number from employees inner join orders on orders.employee_Id = employees.emloyee_Id where employees.emloyee_name = 'Phạm Thị Duyên' group by orders.order_name having sum(orders.total_Amount) BETWEEN 100 and 1000";
  $result9 = $conn_mini_mart->query($mysql9);

  if ($result9->num_rows > 0) {
    echo "bài 4 : tìm mặt hang có doanh số bán được 100k đến 1tr do nhân viên nào đó bán(cụ thể là nhân viên )";
    echo '<table class="table">';
    echo '<thead>
    <tr>
       <th scope="col">Employee</th>
       <th scope="col">Product</th>
       <th scope="col">Revenue number</th>
    </tr>
  </thead>';
    while ($row = $result9->fetch_assoc()) {
      $name_employee = $row["emloyee_name"];
      $name_product = $row["order_name"];
      $revenue = $row["revenue_number"];
      echo "<tr><td>$name_employee</td> <td>$name_product</td>  <td>$revenue</td></tr>";
    }
    echo '</table>';
  } else {
    echo "0 results";
  }


  $conn->close();
  ?>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.1/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    // Kiểm tra tham số URL để hiển thị toast
    document.addEventListener("DOMContentLoaded", function() {
        const urlParams = new URLSearchParams(window.location.search);
        const toastElement = document.getElementById('successToast');
        const toastBody = toastElement.querySelector('.toast-body'); // Chọn phần nội dung toast

        if (urlParams.has('update') && urlParams.get('update') === 'success') {
            // Nếu có tham số 'update'
            toastBody.textContent = 'Update thành công!';
            var toast = new bootstrap.Toast(toastElement);
            toast.show(); // Hiển thị toast

            const url = new URL(window.location);
            url.searchParams.delete('update');
            window.history.replaceState({}, document.title, url);

        } else if (urlParams.has('login') && urlParams.get('login') === 'success') {
            // Nếu có tham số 'login'
            toastBody.textContent = 'Đăng nhập thành công!';
            var toast = new bootstrap.Toast(toastElement);
            toast.show(); // Hiển thị toast

            const url = new URL(window.location);
            url.searchParams.delete('login');
            window.history.replaceState({}, document.title, url);
        }
    });
    </script>
</body>

</html>