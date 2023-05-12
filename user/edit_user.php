<?php

include("../authentication/start_session.php");

if ($_SESSION['login'] == true) {
    if ($_SESSION['userType'] == "manager" or $_GET['user_id'] == $_SESSION['userId']) {
        include('../db_connect.php');

        $query = "SELECT * FROM users WHERE user_id='$_GET[user_id]'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);

        $name = $row['user_name'];
        $email = $row['email'];
        $dob = date('Y-m-d', strtotime($row['birth_date']));
        $profilePic = $row['photo_file_path'];

        $emailErr = $usernameErr = $dobErr = $picErr = "";

        function test_input($input)
        {
            $input = trim($input);
            $input = stripslashes($input);
            $input = htmlspecialchars($input);
            return $input;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty($_POST["email"])) {
                $emailErr = "Email is required!";
            } else {
                $email = test_input($_POST["email"]);
                // check if e-mail address valid
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $emailErr = "Invalid email!";
                }
            }

            if (empty($_POST["name"])) {
                $usernameErr = "Full name is required!";
            } else {
                $name = test_input($_POST["name"]);
            }

            if (empty($_POST["dob"])) {
                $dobErr = "Date of birth is required!";
            } else {
                $dob = test_input($_POST["dob"]);
            }

            if ($emailErr == "" or $usernameErr == "" or $dobErr == "") {
                /**************************** Image upload ****************************/

                error_reporting(~E_NOTICE);

                // avoid notice

                $imgFile = $_FILES['profilePicture']['name'];
                $tmp_dir = $_FILES['profilePicture']['tmp_name'];
                $imgSize = $_FILES['profilePicture']['size'];

                if (empty($imgFile)) {
                    $profilePic = $row['photo_file_path'];
                } else {
                    $upload_dir = '../image_uploads/'; // upload directory

                    $imgExt = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION)); // get image extension
                    // valid image extensions
                    $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
                    // allow valid image file formats
                    if (in_array($imgExt, $valid_extensions)) {
                        // Check file size '5MB'
                        if ($imgSize < 5000000) {
                            if (filter_input(INPUT_POST, 'profilePicture') !== "") {
                                unlink($upload_dir . $profilePic);
                            }
                            // rename uploading image
                            $profilePic = $email . "." . $imgExt;

                            if (move_uploaded_file($tmp_dir, $upload_dir . $profilePic)) {
?>
                                <div class="alert alert-success" role="alert">
                                    <?php
                                    echo "Profile picture has been uploaded.";
                                    ?>
                                </div>
                <?php
                            } else {
                                $picErr =  "Sorry, there was an error uploading your file.";
                                exit();
                            }
                        } else {
                            $picErr = "Sorry, your file is too large.";
                            exit();
                        }
                    } else {
                        $picErr = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                        exit();
                    }
                }
                /************************** End Image upload **************************/
            }

            if ($emailErr != "" or $usernameErr != "" or $dobErr != "" or $picErr != "") {
                ?>
                <div class="alert alert-danger" role="alert">
                    <?php
                    echo $emailErr . "&nbsp;" . $usernameErr . "&nbsp;" . $passwordErr . "&nbsp;" . $dobErr . "&nbsp;" . $picErr . "&nbsp;";
                    ?>
                </div>
<?php } else {
                $query = "UPDATE users SET user_name = '$name', email = '$email', birth_date='$dob', photo_file_path='$profilePic' WHERE user_id = '$_GET[user_id]'";
                $result = mysqli_query($conn, $query);

                header('Location: user_profile.php?user_id=' . $_GET['user_id']);

                if (!$result) {
                    echo mysqli_error($conn);
                }
            }
        }
    } else {
        header('Location: edit_user_form.php?user_id=' . $_GET['user_id']);
    }

    mysqli_close($conn);
} else {
    header('Location: ../authentication/login_form.php');
}
