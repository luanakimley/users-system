<?php
include("start_session.php");

// database connection
include("../db_connect.php");

// initialise variables
$email = $password = "";
$emailErr = $passwordErr = $authErr = $activateError = "";

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

    if (empty($_POST["password"])) {
        $passwordErr = "Password is required!";
    } else {
        $password = test_input($_POST["password"]);
    }
}

// Show error message if form is invalid
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($passwordErr != "" or $emailErr != "" or $authErr != "" or $activateError != "") {
?>
        <div class="alert alert-danger" role="alert">
            <?php
            echo $emailErr . "&nbsp;" . $passwordErr . "&nbsp;" . $authErr;
            ?>
        </div>
        <?php } else {

        $query = "SELECT * FROM users WHERE email='$_POST[email]' AND user_password='$_POST[password]'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        if (mysqli_num_rows($result) > 0) {
            if ($row['is_active'] == 0) {
                $activateError = "Account is not active yet, we will activate it soon"

        ?>

                <div class="alert alert-danger" role="alert">
                    <?php
                    echo $activateError;
                    ?>
                </div>
            <?php
            } else {
                $_SESSION['userId'] = $row['user_id'];
                $_SESSION['login'] = true;
                $_SESSION['userType'] = $row['user_type'];

                if ($_SESSION['userType'] == 'user') {
                    header('Location: ../user/user_profile.php');
                }

                if ($_SESSION['userType'] == 'manager') {
                    header('Location: ../user/users_list.php');
                }
            }
        } else {
            $authErr = "Incorrect email/password!"; ?>

            <div class="alert alert-danger" role="alert">
                <?php
                echo $authErr;
                ?>
            </div>
<?php
        }
    }
}

mysqli_close($conn);
?>