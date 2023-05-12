<?php
include('../authentication/register.php');

include('../includes/header.php');
?>

<main class="d-flex justify-content-center align-items-center vh-100 flex-column">
    <div class="text-center w-25">
        <h1 class="mb-4">Add User&ensp;<i class="bi bi-house-add"></i></h1>
        <form name="editUserForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?userId=" . $_SESSION['userId']); ?>" enctype="multipart/form-data">
            <div class=" form-floating mb-3">
                <input class="form-control" id="name" type="text" name="name" placeholder="Name" value="<?php echo $name ?>" required autofocus>
                <label for="name">Full Name</label>
            </div>
            <div class=" form-floating mb-3">
                <input class="form-control" id="email" type="email" name="email" placeholder="Email" value="<?php echo $email ?>" required autofocus>
                <label for="email">E-mail</label>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control" id="password" type="password" name="password" placeholder="Password" value="<?php echo $password ?>" required autofocus>
                <label for="password">Password</label>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control" id="dob" type="date" name="dob" placeholder="Date of Birth" value="<?php echo $dob ?>" required autofocus  max="<?= date('Y-m-d'); ?>">
                <label for="dob">Date of Birth</label>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control" accept="image/png, image/gif, image/jpg, image/jpeg" id="profilePicture" type="file" name="profilePicture" placeholder="Upload profile picture" autofocus>
                <label for="profilePicture">Upload profile picture <em>(optional)</em></label>
            </div>
            <div class="d-flex gap-4 my-4 mx-2">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="userType" id="userRadioButton" checked>
                    <label class="form-check-label" for="userRadioButton">
                        User
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="userType" id="managerRadioButton">
                    <label class="form-check-label" for="managerRadioButton">
                        Manager
                    </label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 mt-2">Save</button>
    </div>

    <?php
    include('../includes/footer.php');
    ?>