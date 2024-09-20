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
    <h1 class="container mt-2 mb-2">Register</h1>

    <form action="registerFuntion.php" method="post" class="container mt-5">
        <div class="row mb-3">
            <label for="email" class="form-label col-md-2">Email</label>
            <div class="col-md-10">
                <input type="email" name="email" class="form-control" id="email" placeholder="name@example.com">
            </div>
        </div>

        <div class="row mb-3">
            <label for="password" class="form-label col-md-2">Password</label>
            <div class="col-md-10">
                <input type="password" name="password" class="form-control" id="password" placeholder="Name">
            </div>
        </div>

        <div class="row mb-3">
            <label for="confirmPassword" class="form-label col-md-2">Confirm Password</label>
            <div class="col-md-10">
                <input type="password" name="confirmPassword" class="form-control" id="confirmPassword"
                    placeholder="Confirm password">
            </div>
        </div>

        <div class="row">
            <div class="col-md-10 offset-md-2">
                <input type="submit" name="registerFunc" value="Register" class="btn btn-primary">
            </div>
        </div>
    </form>


</body>

</html>