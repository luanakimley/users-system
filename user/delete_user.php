<?php
    include('../authentication/start_session.php');
    include("../db_connect.php");

    $query = "DELETE FROM users WHERE user_id = $_GET[user_id]";
    mysqli_query($conn, $query);

    mysqli_close($conn);

    header("location: users_list.php");
?>