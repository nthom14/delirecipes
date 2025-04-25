document.getElementById('login-button').addEventListener('click', function() {
    document.getElementById('login-form-section').style.display = 'block';
});

document.getElementById('login-form').addEventListener('submit', function(event) {
    event.preventDefault();

    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    if (username === "user" && password === "pass") {
        alert("Login successful!");
        document.getElementById('login-form-section').style.display = 'none';
        document.getElementById('login-button').style.display = 'none';
        document.getElementById('logout-container').style.display = 'block';
        document.getElementById('extra-recipes').style.display = 'block';
    } else {
        alert("Invalid credentials. Please try again.");
    }
});

document.getElementById('logout-button').addEventListener('click', function() {
    alert("Logged out successfully!");
    document.getElementById('extra-recipes').style.display = 'none';
    document.getElementById('login-button').style.display = 'block';
    document.getElementById('logout-container').style.display = 'none';
}); 