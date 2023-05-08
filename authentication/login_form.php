<?php
include('login.php');
include('../includes/header.php');
?>

<main class="d-flex justify-content-center align-items-center vh-100 flex-column">
    <div class="text-center w-25">
        <h1 class="mb-4">Login&ensp;<i class="bi bi-house-lock"></i></h1>
        <form name="loginForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
            <div class=" form-floating mb-3">
                <input class="form-control" id="email" type="email" name="email" placeholder="Email" value="<?php echo $email ?>" required autofocus>
                <label for="email">E-mail</label>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control" id="password" type="password" name="password" placeholder="Password" value="<?php echo $password ?>" required autofocus>
                <label for="password">Password</label>
            </div>
            <button type="submit" class="btn btn-primary w-100 mt-2">Submit</button>
            <div class="mt-4">
                <a href="register_form.php" class="text-secondary">I don't have an account</a>
            </div>
    </div>

    <?php
    include('../includes/footer.php');
    ?>