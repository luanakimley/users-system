<?php
    include('../authentication/start_session.php');
    include("../db_connect.php");
    
    $query = "UPDATE users SET is_active = $_GET[is_active] WHERE user_id = $_GET[user_id]";
    mysqli_query($conn, $query);

    mysqli_close($conn);

    header("location: users_list.php");
?>