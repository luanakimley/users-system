<?php
include('edit_user_password.php');

include('../includes/header.php');
?>

<main class="d-flex justify-content-center align-items-center vh-100 flex-column">
    <div class="text-center w-25">
        <h1 class="mb-4">Edit Password&ensp;<i class="bi bi-pencil-square"></i></h1>
        <form name="editUserForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?user_id=" . $_GET['user_id']); ?>" enctype="multipart/form-data">
            <div class=" form-floating mb-3">
                <input class="form-control" id="current-password" type="password" name="current-password" placeholder="Current-Password" value="" required autofocus>
                <label for="name">Current Password</label>
            </div>
            <div class=" form-floating mb-3">
                <input class="form-control" id="new-password" type="password" name="new-password" placeholder="New-Password" value="" required autofocus>
                <label for="new-password">New Password</label>
            </div>
            <div class=" form-floating mb-3">
                <input class="form-control" id="confirm-new-password" type="password" name="confirm-new-password" placeholder="Confirm-New-Password" value="" required autofocus>
                <label for="confirm-new-password">Confirm New Password</label>
            </div>

            <button type="submit" class="btn btn-primary w-100 mt-2">Save</button>
    </div>

    <?php
    include('../includes/footer.php');
    ?>