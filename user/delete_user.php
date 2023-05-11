<?php
include('../authentication/start_session.php');

if ($_SESSION['userType'] != "manager") {
    header('Location: ../authentication/login_form.php');
}

include("../db_connect.php");

$query = "SELECT photo_file_path FROM users WHERE user_id='{$_SESSION['userId']}'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$profilePic = $row['photo_file_path'];

if ($profilePic != "") {
    $upload_dir = '../image_uploads/'; // upload directory
    unlink($upload_dir . $profilePic);
}

$query = "DELETE FROM users WHERE user_id = $_GET[user_id]";
mysqli_query($conn, $query);

mysqli_close($conn);

if ($_SESSION['userType'] != "manager") {
    header('Location: ../authentication/logout.php');
}

header("location: users_list.php");
