<?php
include("../authentication/start_session.php");

include('../includes/header.php');

if ($_SESSION['login'] == true) {

    include('../db_connect.php');

    $query = "SELECT * FROM users WHERE user_id='$_SESSION[userId]'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    $userId = $row['user_id'];
    $name = $row['user_name'];
    $email = $row['email'];
    $dob = $row['birth_date'];

    if ($row['photo_file_path'] != "") {
        $profilePic = $row['photo_file_path'];
    } else {
        $profilePic = "user.png";
    }

?>
    <main class="d-flex align-items-center vh-100 flex-column">
        <div class="d-flex align-items-center flex-column justify-content-center bg-primary w-100 p-4">
            <div class="image-container">
                <img src="../image_uploads/<?php echo $profilePic ?>">
            </div>
            <h3 class="mt-3 text-light"><?php echo $name; ?></h3>
        </div>
        <div class="mt-5">
            <div class="card">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>Member ID:&ensp;</strong><?php echo $userId; ?></li>
                    <li class="list-group-item"><strong>E-mail:&ensp;</strong><?php echo $email; ?></li>
                    <li class="list-group-item"><strong>Date of birth:&ensp;</strong><?php echo $dob; ?></li>
                </ul>
            </div>
        </div>
        <div class="d-flex align-items-center justify-content-center mt-5 gap-2">
            <a href="edit_user_form.php?userId=<?php echo $userId ?>" class="btn btn-primary"><i class="bi bi-pencil-square"></i>&ensp;Edit profile</a>
            <?php if ($_SESSION['userType'] == 'manager') { ?>
                <a href="users_list.php" class="btn btn-primary">Back to User list</a>
            <?php } else { ?>
                <form action="../authentication/logout.php" method="post">
                    <input class="btn btn-primary" type="submit" value="Sign Out">
                </form> <?php } ?>
        </div>
    </main>
<?php
    include('../includes/footer.php');

    mysqli_close($conn);
} else {
    header('Location: ../authentication/login_form.php');
}
?>