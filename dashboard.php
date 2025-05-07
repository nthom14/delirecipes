<?php
require 'config.php'; // This should start the session and connect to DB

if (isset($_SESSION['remember_expires']) && time() > $_SESSION['remember_expires']) {
    session_destroy();
    header("Location: login.php");
    exit();
}

// Check session
if (!isset($_SESSION['user'])) {
    // Check "remember me" cookie
    if (isset($_COOKIE['remember_token'])) {
        $token = $_COOKIE['remember_token'];
        $stmt = $pdo->prepare("SELECT * FROM users WHERE remember_token = ?");
        $stmt->execute([$token]);
        $user = $stmt->fetch();

        if ($user) {
            $_SESSION['user'] = $user['username'];
        } else {
            // Invalid token, redirect to login
            header("Location: login.php");
            exit();
        }
    } else {
        // No session and no cookie, redirect to login
        header("Location: login.php");
        exit();
    }
}
?>

<?php include 'header.php'; ?>

<!-- <div class="container mt-5">
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['user']); ?>!</h2>
    <p>This is your dashboard.</p>
</div> -->

<div class="container mt-5">
    <div class="row g-4">
        <!-- Section 1 -->
        <div class="col-md-6">
            <a href="page1.php" class="text-decoration-none">
                <div class="card h-100 text-center shadow-sm">
                    <img src="images/image1.jpg" class="card-img-top" alt="Section 1">
                    <div class="card-body">
                        <h5 class="card-title">Healthy</h5>
                    </div>
                </div>
            </a>
        </div>

        <!-- Section 2 -->
        <div class="col-md-6">
            <a href="page2.php" class="text-decoration-none">
                <div class="card h-100 text-center shadow-sm">
                    <img src="images/image2.jpg" class="card-img-top" alt="Section 2">
                    <div class="card-body">
                        <h5 class="card-title">Famous</h5>
                    </div>
                </div>
            </a>
        </div>

        <!-- Section 3 -->
        <div class="col-md-6">
            <a href="page3.php" class="text-decoration-none">
                <div class="card h-100 text-center shadow-sm">
                    <img src="images/image3.jpg" class="card-img-top" alt="Section 3">
                    <div class="card-body">
                        <h5 class="card-title">Favourites</h5>
                    </div>
                </div>
            </a>
        </div>

        <!-- Section 4 -->
        <div class="col-md-6">
            <a href="page4.php" class="text-decoration-none">
                <div class="card h-100 text-center shadow-sm">
                    <img src="images/image4.jpg" class="card-img-top" alt="Section 4">
                    <div class="card-body">
                        <h5 class="card-title">Recipes</h5>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
