<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/log.css">
    <script src="../js/auth.js" defer></script>
</head>
<body>

    <form id="login-form">
    <h2>Login</h2>
        <label for="email">Email:</label>
        <input type="email" id="email" placeholder="Enter your email" required>
        
        <label for="password">Password:</label>
        <input type="password" id="password" placeholder="Enter your password" required>
        
        <button type="submit">Login</button>

        <p>Don't have an account? <a href="signup.php">Sign up here</a></p>
    </form>
    
</body>
</html>
