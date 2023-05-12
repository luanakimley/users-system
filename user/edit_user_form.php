<?php
include('edit_user.php');

include('../includes/header.php');
?>

<main class="d-flex justify-content-center align-items-center vh-100 flex-column">
    <div class="text-center w-25">
        <h1 class="mb-4">Edit User&ensp;<i class="bi bi-pencil-square"></i></h1>
        <form name="editUserForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?user_id=" . $_GET['user_id']); ?>" enctype="multipart/form-data">
            <div class=" form-floating mb-3">
                <input class="form-control" id="name" type="text" name="name" placeholder="Name" value="<?php echo $name ?>" required autofocus>
                <label for="name">Full Name</label>
            </div>
            <div class=" form-floating mb-3">
                <input class="form-control" id="email" type="email" name="email" placeholder="Email" value="<?php echo $email ?>" required autofocus>
                <label for="email">E-mail</label>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control" id="dob" type="date" name="dob" placeholder="Date of Birth" value="<?php echo $dob ?>" required autofocus max="<?= date('Y-m-d'); ?>">
                <label for="dob">Date of Birth</label>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control" accept="image/png, image/gif, image/jpg, image/jpeg" id="profilePicture" type="file" name="profilePicture" placeholder="Upload profile picture" autofocus>
                <label for="profilePicture">Upload profile picture <em>(optional)</em></label>
            </div>
            <?php
            if ($profilePic != "") { ?>
                <div class="image-container">
                    <img src="../image_uploads/<?php echo $profilePic ?>">
                </div>
            <?php } ?>
            <button type="submit" class="btn btn-primary w-100 mt-2">Save</button>
    </div>

    <?php
    include('../includes/footer.php');
    ?>