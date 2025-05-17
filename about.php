<?php
require 'config.php';
include 'header.php';
?>

<div class="container mt-5 mb-5">
    <h2 class="mb-4">About Us</h2>
    
    <div class="row">
        <div class="col-md-8">
            <p>
                Welcome to <strong>Student Foods</strong>, your go-to platform for [describe purpose of site here, e.g., "sharing knowledge, connecting professionals, and learning new skills"].
            </p>
            <p>
                Our mission is to provide a simple, secure, and user-friendly environment where visitors can [state what users can do — e.g., "register, log in, and access exclusive content or tools"].
            </p>
            <p>
                We are passionate about quality, innovation, and user satisfaction. Whether you're a casual visitor or a frequent user, we're here to support your journey.
            </p>
        </div>
        <div class="col-md-4">
            <img src="images/about.jpg" alt="About Us" class="img-fluid rounded shadow">
        </div>
    </div>
    <h3 class="mb-4">Meet the Team</h3>
    <div class="row g-4">
        <!-- Team Member 1 -->
        <div class="col-md-6">
            <div class="card h-100 shadow-sm">
                <img src="images/alex-papadopoulos.jpg" class="card-img-top team-photo" alt="Team Member 1">
                <div class="card-body">
                    <h5 class="card-title">Alex Papadopoulos</h5>
                    <p class="card-text">Lead Developer with a passion for clean code, PHP, and web security. Loves coffee and solving tough problems.</p>
                </div>
            </div>
        </div>

        <!-- Team Member 2 -->
        <div class="col-md-6">
            <div class="card h-100 shadow-sm">
                <img src="images/maria-kotsou.jpg" class="card-img-top team-photo" alt="Team Member 2">
                <div class="card-body">
                    <h5 class="card-title">Maria Kotsou</h5>
                    <p class="card-text">UI/UX Designer focusing on user experience, accessibility, and Bootstrap styling. Enjoys minimalism and design systems.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
