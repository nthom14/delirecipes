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
            $session_user = [
                'id' => $user['id'],
                'username' => $user['username'],
                'email' => $user['email']
            ];
            // Store in session
            $_SESSION['user'] = $session_user;
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

<?php if (isset($_SESSION['message'])): ?>
    <div class="alert alert-info mt-3">
        <?= htmlspecialchars($_SESSION['message']) ?>
    </div>
    <?php unset($_SESSION['message']); ?>
<?php endif; ?>

<?php include 'header.php'; ?>



<!-- <div class="container mt-5">
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['user']['username']); ?>!</h2>
    <p>This is your dashboard.</p>
</div> -->

<!-- <div class="container mt-5">
    <div class="row g-4">
        <div class="col-md-6">
            <a href="recipes.php" class="text-decoration-none">
                <div class="card h-100 text-center shadow-sm">
                    <img src="images/top_left.jpg" class="card-img-top" alt="Section 1">
                    <div class="card-body">
                        <h5 class="card-title">My Recipes</h5>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6">
            <a href="healthy_recipes.php" class="text-decoration-none">
                <div class="card h-100 text-center shadow-sm">
                    <img src="images/top_right.jpg" class="card-img-top" alt="Section 2">
                    <div class="card-body">
                        <h5 class="card-title">Healthy</h5>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6">
            <a href="favorite_recipes.php" class="text-decoration-none">
                <div class="card h-100 text-center shadow-sm">
                    <img src="images/bottom_left.jpg" class="card-img-top" alt="Section 3">
                    <div class="card-body">
                        <h5 class="card-title">Favorites</h5>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6">
            <a href="famous_recipes.php" class="text-decoration-none">
                <div class="card h-100 text-center shadow-sm">
                    <img src="images/bottom_right.jpg" class="card-img-top" alt="Section 4">
                    <div class="card-body">
                        <h5 class="card-title">Famous</h5>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div> -->

<div class="container py-4">
    <h2 class="mb-4">Dashboard</h2>

    <div class="row mb-4">
        <div class="col-md-6 mb-3">
            <a href="recipes.php" class="text-decoration-none">
                <div class="card text-center shadow-sm h-100">
                    <img src="images/my_recipes.jpg" class="card-img-top img-fluid square-img" alt="My Recipes">
                    <div class="card-body">
                        <h5 class="card-title">My Recipes</h5>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-6 mb-3">
            <a href="all_recipes.php" class="text-decoration-none">
                <div class="card text-center shadow-sm h-100">
                    <img src="images/all_recipes.jpg" class="card-img-top img-fluid square-img" alt="All Recipes">
                    <div class="card-body">
                        <h5 class="card-title">All Recipes</h5>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <a href="healthy_recipes.php" class="text-decoration-none">
                <div class="card text-center shadow-sm h-100">
                    <img src="images/healthy.jpg" class="card-img-top img-fluid square-img" alt="Healthy Recipes">
                    <div class="card-body">
                        <h5 class="card-title">Healthy Recipes</h5>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4 mb-3">
            <a href="favorite_recipes.php" class="text-decoration-none">
                <div class="card text-center shadow-sm h-100">
                    <img src="images/favorite.jpg" class="card-img-top img-fluid square-img" alt="Favorite Recipes">
                    <div class="card-body">
                        <h5 class="card-title">Favorite Recipes</h5>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4 mb-3">
            <a href="famous_recipes.php" class="text-decoration-none">
                <div class="card text-center shadow-sm h-100">
                    <img src="images/famous.jpg" class="card-img-top img-fluid square-img" alt="Famous Recipes">
                    <div class="card-body">
                        <h5 class="card-title">Famous Recipes</h5>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>


<?php include 'footer.php'; ?>
