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
    <form action="function.php" method="post" class="container mt-5">
        <div class="mb-3 form-group row">
            <label for="exampleFormControlInput1" class="form-label col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
                <input type="email" name='email' class="form-control form-control-lg" id="exampleFormControlInput1"
                    placeholder="name@example.com">
            </div>
        </div>

        <div class="mb-3 form-group row">
            <label for="exampleFormControlInput1" class="form-label col-sm-2 col-form-label">Name</label>
            <div class="col-sm-10">
                <input type="text" name='name' class="form-control form-control-lg" id="exampleFormControlInput1"
                    placeholder="name">
            </div>
        </div>

        <div class="mb-3 form-group row">
            <label for="exampleFormControlInput1" class="form-label col-sm-2 col-form-label">Address</label>
            <div class="col-sm-10">
                <input type="text" name='address' class="form-control form-control-lg" id="exampleFormControlInput1"
                    placeholder="address">
            </div>
        </div>

        <div class="mb-3 form-group row">
            <label for="exampleFormControlInput1" class="form-label col-sm-2 col-form-label">Birthday</label>
            <div class="col-sm-10">
                <input type="date" name='birthday' class="form-control form-control-lg" id="exampleFormControlInput1"
                    placeholder="birthday">
            </div>
        </div>

        <div class="mb-3">
            <input type="submit" name='insertfunc' value="Insert" class="btn btn-primary btn-lg">
        </div>
    </form>


</body>

</html>