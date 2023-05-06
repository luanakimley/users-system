<?php
// initialise session
session_start();

// PHP charset
ini_set('default_charset', 'UTF-8');

// database connection
include("db_connect.php");

// initialise variables
$email = $username = $password = $dob = $profilePic = "";
$emailErr = $usernameErr = $passwordErr = $dobErr = $picErr = "";

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

    if (empty($_POST["username"])) {
        $usernameErr = "Username is required!";
    } else {
        $username = test_input($_POST["username"]);
    }

    if (empty($_POST["password"])) {
        $passwordErr = "Password is required!";
    } else {
        $password = test_input($_POST["password"]);
    }

    if (empty($_POST["dob"])) {
        $dobErr = "Date of birth is required!";
    } else {
        $dob = test_input($_POST["dob"]);
    }

    if ($passwordErr == "" or $emailErr == "" or $usernameErr == "" or $dobErr == "") {
        /**************************** Image upload ****************************/

        error_reporting(~E_NOTICE);

        // avoid notice

        $imgFile = $_FILES['profilePicture']['name'];
        $tmp_dir = $_FILES['profilePicture']['tmp_name'];
        $imgSize = $_FILES['profilePicture']['size'];

        if (empty($imgFile)) {
            $profilePic = "";
        } else {
            $upload_dir = 'image_uploads/'; // upload directory

            $imgExt = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION)); // get image extension
            // valid image extensions
            $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
            // rename uploading image
            $profilePic = $email . "." . $imgExt;
            // allow valid image file formats
            if (in_array($imgExt, $valid_extensions)) {
                // Check file size '5MB'
                if ($imgSize < 5000000) {
                    if (move_uploaded_file($_FILES["profilePicture"]["tmp_name"], $upload_dir . $profilePic)) {
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
}

// Show error message if form is invalid
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($passwordErr != "" or $emailErr != "" or $usernameErr != "" or $dobErr != "" or $picErr != "") {
        ?>
        <div class="alert alert-danger" role="alert">
            <?php
            echo $emailErr . "&nbsp;" . $usernameErr . "&nbsp;" . $passwordErr . "&nbsp;" . $dobErr . "&nbsp;" . $picErr . "&nbsp;";
            ?>
        </div>
<?php } else {


        $exists = true;
        while ($exists) {
            // Generate a random 4-digit number
            $user_id = rand(1000, 9999);

            // Check if the ID already exists in the database
            $query = "SELECT COUNT(*) as count FROM users WHERE user_id = $user_id";
            $result = mysqli_query($conn, $query);
            $count = mysqli_fetch_assoc($result)['count'];

            if ($count == 0) {
                // ID doesn't exist, we can use it
                $exists = false;
            }
        }

        $dob = date('Y-m-d', strtotime($dob));

        $query = "INSERT INTO users (user_id, user_name, email, user_password, user_type, photo_file_path, birth_date, is_active)
        VALUES ($user_id,  '$username', '$email', '$password', 'user', '$profilePic', '$dob', 0)";


        $result = mysqli_query($conn, $query);

        if (!$result) {
            echo mysqli_error($conn);
        }

        header('Location: login.php');
    }
}
?>