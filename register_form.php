<?php
include('register.php');
include('includes/header.php');
?>

<main class="d-flex justify-content-center align-items-center vh-100 flex-column">
    <div class="text-center w-25">
        <h1 class="mb-4">Registration&ensp;<i class="bi bi-house"></i></h1>
        <form name="registrationForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
            <div class=" form-floating mb-3">
                <input class="form-control" id="email" type="email" name="email" placeholder="Email" value="<?php echo $email ?>" required autofocus>
                <label for="email">Email</label>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control" id="username" type="text" name="username" placeholder="Username" value="<?php echo $username ?>" required autofocus>
                <label for="username">Username</label>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control" id="password" type="password" name="password" placeholder="Password" value="<?php echo $password ?>" required autofocus>
                <label for="password">Password</label>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control" id="dateOfBirth" type="date" name="dob" placeholder="Date of birth" value="<?php echo $dob ?>" required autofocus max="<?= date('Y-m-d'); ?>">
                <label for="dateOfBirth">Date of birth</label>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control" accept="image/png, image/gif, image/jpg, image/jpeg" id="profilePicture" type="file" name="profilePicture" placeholder="Upload profile picture" autofocus>
                <label for="profilePicture">Upload profile picture <em>(optional)</em></label>
            </div>
            <button type="submit" class="btn btn-primary w-100 mt-2">Submit</button>
        </form>
        <div class="mt-4">
            <a href="login.php" class="text-secondary">I have an account</a>
        </div>
    </div>

    <?php
    include('includes/footer.php');
    ?>