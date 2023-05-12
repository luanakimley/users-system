<?php

include("../authentication/start_session.php");

if ($_SESSION['login'] == true) {
    if ($_GET['user_id'] == $_SESSION['userId']) {
        include('../db_connect.php');

        $query = "SELECT * FROM users WHERE user_id='$_GET[user_id]'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);

        $currentPassword = $row['user_password'];

        $currentPasswordErr = $newPasswordErr = $confirmNewPassowrdErr = "";

        $currentPasswordForm = $newPasswordForm = $confirmNewPasswordForm = "";

        function test_input($input)
        {
            $input = trim($input);
            $input = stripslashes($input);
            $input = htmlspecialchars($input);
            return $input;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty($_POST["current-password"])) {
                $currentPasswordErr = "Current password is required!";
            } else {
                $currentPasswordForm = test_input($_POST["current-password"]);

                if ($currentPasswordForm !== $currentPassword) {
                    $currentPasswordErr = "Current password is incorrect!";
                }
            }

            if (empty($_POST["new-password"])) {
                $newPasswordErr = "New password is required!";
            } else {
                $newPasswordForm = test_input($_POST["new-password"]);
            }

            if (empty($_POST["confirm-new-password"])) {
                $confirmNewPassowrdErr = "Confirm new password is required!";
            } else {
                $confirmNewPasswordForm = test_input($_POST["confirm-new-password"]);

                if ($newPasswordForm !== $confirmNewPasswordForm) {
                    $confirmNewPassowrdErr = "Confirm new password does not match!";
                }
            }

            if ($currentPasswordErr != "" or $newPasswordErr != "" or $confirmNewPassowrdErr != "") {
                ?>
                <div class="alert alert-danger" role="alert">
                    <?php
                    echo $currentPasswordErr . "&nbsp;" . $newPasswordErr . "&nbsp;" . $confirmNewPassowrdErr . "&nbsp;";
                    ?>
                </div>
    <?php } else {
                $query = "UPDATE users SET user_password = '$newPasswordForm' WHERE user_id = '$_GET[user_id]'";
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
