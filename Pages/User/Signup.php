<!-- login.php -->
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="../../style/SignupPage.css" />


    <script>
    function showAlert(message) {
        alert(message);
    }
    </script>

</head>

<body>
<?php
        require_once('../../db_connect.php');

        if(isset($_POST['submit'])) {
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $age = $_POST['age'];
            $mobile_no = $_POST['mobile_no'];
            $gender = $_POST['gender'];
            $address = $_POST['address'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $cpassword = $_POST['cpassword'];
            $meter_id = $_POST['meter_id'];
 
            // Validate form data (you can add your own validation rules here)
            if(empty($fname) || empty($lname) || empty($age) || empty($mobile_no) || empty($gender) || empty($address) || empty($email) || empty($password) || empty($cpassword)) {
                echo "All fields are required.";
            } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "Invalid email address.";
            } elseif($password !== $cpassword) {
                echo "Passwords do not match.";
            } else {
                // Check if email address already exists
                $sql = "SELECT * FROM users WHERE email = '$email'";
                $result = mysqli_query($conn, $sql);
                if(mysqli_num_rows($result) > 0) {
                    // Email address already exists, display alert
                    echo "<script>showAlert('Email address already exists.');</script>";
                } else {

                    // Hash the password before storing it in the database
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                    $sql = "INSERT INTO users (meter_id, fname, lname, age, mobile_no, gender, address, email, password) VALUES ('$meter_id', '$fname', '$lname', '$age', '$mobile_no', '$gender', '$address', '$email', '$hashed_password')";
                    if(mysqli_query($conn, $sql)) {
                        // Link user table meter_id to other tables meter_id
                        $sql = "UPDATE uploaddate SET meter_id='$meter_id' WHERE meter_id = (SELECT meter_id FROM users WHERE meter_id='$meter_id')";
                        mysqli_query($conn, $sql);
                        $sql = "UPDATE unpaidbill SET meter_id='$meter_id' WHERE meter_id = (SELECT meter_id FROM users WHERE meter_id='$meter_id')";
                        mysqli_query($conn, $sql);
                        $sql = "UPDATE solarusages SET meter_id='$meter_id' WHERE meter_id = (SELECT meter_id FROM users WHERE meter_id='$meter_id')";
                        mysqli_query($conn, $sql);
                        $sql = "UPDATE query SET meter_id='$meter_id' WHERE meter_id = (SELECT meter_id FROM users WHERE meter_id='$meter_id')";
                        mysqli_query($conn, $sql);
                        $sql = "UPDATE paidbills SET meter_id='$meter_id' WHERE meter_id = (SELECT meter_id FROM users WHERE meter_id='$meter_id')";
                        mysqli_query($conn, $sql);
                        $sql = "UPDATE electricityuses SET meter_id='$meter_id' WHERE meter_id = (SELECT meter_id FROM users WHERE meter_id='$meter_id')";
                        mysqli_query($conn, $sql);
                        header('Location: login.php');
                        exit();
                    } else {
                        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                        echo "<script>showAlert('Signup unsuccessful!');</script>";
                    }
                }
            }
        }

        // Close database connection
        mysqli_close($conn);
    ?>

  
    <div class="col">
        <div class="card card-registration my-4">
            <div class="row g-0">
                <div class="col-xl-6">
                    <div class="card-body p-md-4 text-black">
                        <h3 class="mb-5 text-uppercase d-flex justify-content-center align-items-center ">Signup form
                        </h3>

                        <form method="POST" action="">
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <div class="form-outline">
                                        <input type="text" id="name" name="fname" placeholder="First Name">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div class="form-outline">
                                        <input type="text" id="name" name="lname" placeholder="Last Name">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <div class="form-outline">
                                        <input type="number" id="name" name="age" placeholder="Age">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div class="form-outline">
                                        <input type="text" id="mail" name="mobile_no" placeholder="mobile number">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div class="form-outline">
                                        <input type="number" id="name" name="meter_id" placeholder="meter_id">
                                    </div>
                                </div>
                            </div>

                            <div class="d-md-flex justify-content-start align-items-center mb-4 py-2">

                                <h6 class="mb-0 me-4">Gender: </h6>

                                <select id="gender" name="gender">
                                    <option>Select Gender</option>
                                    <option value="male">MALE</option>
                                    <option value="female">FEMALE</option>
                                    <option value="other">OTHER</option>
                                </select>

                            </div>

                            <div class="mb-4">
                                <textarea type="text" id="form3Example8" name="address" value="male"
                                    class="form-control" placeholder="Address"></textarea>
                            </div>

                            <div class="mb-4">
                                <input type="email" id="form3Example97" name="email" class="form-control"
                                    placeholder="Email ID" />
                            </div>

                            <div class="mb-4">
                                <input type="password" id="form3Example97" name="password" class="form-control"
                                    placeholder="Password" />
                            </div>

                            <div class="mb-4">
                                <input type="password" id="form3Example97" name="cpassword" class="form-control"
                                    placeholder="Confirm Password" />
                            </div>

                            <div class="d-flex justify-content-center pt-3">
                                <input class="signup-btn" type="submit" name="submit" value="Signup">
                            </div><br />
                            <hr />

                            <p class="signupoption d-flex justify-content-center align-items-center">Alrady have an
                                account? <a class="signupbtn" href="login.php"> Login</a></p>
                        </form>

                    </div>

                </div>
                <div class="col-xl-6 d-none d-xl-block right-side">
                    <img src="../../assets/img/signup.png" alt="Sample photo" class="img-fluid imgg " />
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"
        integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"
        integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous">
    </script>

</body>

</html>