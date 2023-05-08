<?php
session_start();

ini_set('default_charset', 'UTF-8');

// if ($_SESSION['login'] == true) 
// {
    include("db_connect.php");
    $query = "DELETE FROM users WHERE user_id = $_GET[user_id]";
    mysqli_query($conn, $query);

    mysqli_close($conn);

    header("location: users_list.php");
//}
?>