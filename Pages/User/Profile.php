<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Profile</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../../style/uploadData.css" />
</head>

<body>
    <?php
        session_start();
        require_once('../../db_connect.php');
		
        // Check if user is logged in, otherwise redirect to login page
            if(!isset($_SESSION['email'])) {
            header("Location: login.php");
            exit();
        }

        if(isset($_POST['submit'])) {
            $current_password = $_POST['current_password'];
            $new_password = $_POST['new_password'];
            $confirm_password = $_POST['confirm_password'];
    
            $email = $_SESSION['email'];
    
            $user_query = "SELECT * FROM users WHERE email = '$email'";
            $user_result = mysqli_query($conn, $user_query);
    
            if(mysqli_num_rows($user_result) == 1) {
                $user_row = mysqli_fetch_assoc($user_result);
    
                // Check if the current password entered by the user matches the one in the database
                if(password_verify($current_password, $user_row['password'])) {
                    // Check if the new password matches the confirm password
                    if($new_password == $confirm_password) {
                        // Update the user's password
                        $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
                        $update_query = "UPDATE users SET password = '$new_password_hash' WHERE email = '$email'";
                        mysqli_query($conn, $update_query);
                        echo "Password updated successfully!";
                    } else {
                        echo "New password and confirm password do not match!";
                    }
                } else {
                    echo "Current password is incorrect!";
                }
            } else {
                echo "User not found!";
            }
        }


        // Get user info
        $user_info_query = "SELECT fname, lname, mobile_no, meter_id FROM users WHERE email = '$email'";
        $user_info_result = mysqli_query($conn, $user_info_query);
        $user_info_row = mysqli_fetch_assoc($user_info_result);
        $fname = $user_info_row['fname'] ?? "";
        $lname = $user_info_row['lname'] ?? "";
        $mobile_no = $user_info_row['mobile_no'] ?? "";
        $meter_id = $user_info_row['meter_id'] ?? "";

        
        // if(isset($_POST['submit2'])) {
        //     $fname = $_POST['fname'];
        //     $lname = $_POST['lname'];
        //     $emailid = $_POST['emailid'];
        //     $mobile_no = $_POST['mobile_no'];
        //     $gender = $_POST['gender'];
        //     $address = $_POST['address'];

        //     $insert_query = "INSERT INTO users (fname, lname, emailid, mobile_no, gender, address) VALUES ('$fname', '$lname', '$emailid', '$mobile_no', '$gender', '$address')";
        //     $insert_result = mysqli_query($conn, $insert_query);

        //     if($insert_result) {
        //         echo "Data inserted successfully!";
        //     } else {
        //         echo "Error inserting data: " . mysqli_error($conn);
        //     }
        // }

    ?>

    <div class="flex">
        <?php
            require_once('../../components/User/navbar.php');
        ?>

        <div class="w-full pl-72 bg-[#DFEBE7] p-6 overscroll-auto overflow-auto">
            <div id="notice">Notice</div>
            <div id="title-bar1">Security Setting</div>
            <div class="box">
                <form method="POST">
                    <input class="inputs mb-4" type="text" name="current_password" placeholder="Current Password" />
                    <input class="inputs mb-4" type="text" name="new_password" placeholder="New Password" />
                    <input class="inputs mb-4" type="text" name="confirm_password" placeholder="Conform New Password" />
                    <input class="submit-btn" type="submit" name="submit" />
                </form>
            </div>

            <div id="title-bar1">Account Setting</div>

            <div class="box">
                <form method="post">
                    <div class="flex gap-16 mb-6">
                        <input class="inputs" type="text" name="fname" placeholder="First Name" required />
                        <input class="inputs" type="text" name="lname" placeholder="Last Name" required />
                    </div>

                    <div class="flex gap-16 mb-6">
                        <input class="inputs" type="email" name="email" placeholder="Email" required />
                        <input class="inputs" type="number" name="mobile_no" placeholder="Mobile No." required />
                    </div>

                    <div class="flex gap-16 mb-6">
                        <input class="inputs" type="text" name="gender" placeholder="Gender" required />
                        <input class="inputs" type="text" name="address" placeholder="Address" required />
                    </div>

                    <button class="submit-btn mt-2" type="submit2" name="submit2">Submit</button>
                </form>

            </div>

        </div>
    </div>
</body>

</html>