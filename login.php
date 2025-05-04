<?php include 'header.php'; ?>

<div class="container mt-5">
    <h2>Login</h2>
    <?php
    if (isset($_GET['error'])) {
        $msg = match ($_GET['error']) {
            'empty' => "Please fill in both fields.",
            'invalid' => "Invalid username/email or password.",
            default => "Something went wrong. Please try again."
        };
        echo "<div class='alert alert-danger'>$msg</div>";
    }
    ?>
    <form method="post" action="login_handler.php" class="needs-validation mt-3" novalidate>
        <div class="mb-3">
            <label class="form-label">Username or Email</label>
            <input type="text" name="username" class="form-control" required>
            <div class="invalid-feedback">Please enter your username or email.</div>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
            <div class="invalid-feedback">Please enter your password.</div>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="remember" id="remember">
            <label class="form-check-label" for="remember">Remember me</label>
        </div>

    </form>
</div>

<?php include 'footer.php'; ?>
