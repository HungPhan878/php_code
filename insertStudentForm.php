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
    <form action="function.php" method="post" enctype="multipart/form-data" class="container mt-5">
        <div class="row mb-3">
            <label for="email" class="form-label col-md-2">Email</label>
            <div class="col-md-10">
                <input type="email" name="email" class="form-control" id="email" placeholder="name@example.com">
            </div>
        </div>

        <div class="row mb-3">
            <label for="name" class="form-label col-md-2">Name</label>
            <div class="col-md-10">
                <input type="text" name="name" class="form-control" id="name" placeholder="Name">
            </div>
        </div>

        <div class="row mb-3">
            <label for="address" class="form-label col-md-2">Address</label>
            <div class="col-md-10">
                <input type="text" name="address" class="form-control" id="address" placeholder="Address">
            </div>
        </div>

        <div class="row mb-3">
            <label for="birthday" class="form-label col-md-2">Birthday</label>
            <div class="col-md-10">
                <input type="date" name="birthday" class="form-control" id="birthday">
            </div>
        </div>

        <div class="row mb-3">
            <label for="fileImage" class="form-label col-md-2">Image</label>
            <div class="col-md-10">
                <input type="file" name="fileImage[]" multiple class="form-control" id="fileImage"
                    accept=".png, .jpg, .jpeg">
            </div>
        </div>

        <div class="row mb-3">
            <label for="videoURL" class="form-label col-md-2">Video URL</label>
            <div class="col-md-10">
                <input type="file" name="video_url[]" multiple class="form-control" id="videoURL"
                    accept=".mp4, .avi, .mov, .mpeg">
            </div>
        </div>

        <div class="row">
            <div class="col-md-10 offset-md-2">
                <input type="submit" name="insertStudentFunc" value="Add Student" class="btn btn-primary">
            </div>
        </div>
    </form>


</body>

</html>