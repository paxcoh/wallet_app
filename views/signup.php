<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="../css/log.css">
    <script src="../js/auth.js" defer></script>
</head>
<body>
    
    <form id="signup-form">
    <h2>Sign Up</h2>
        <label for="name">Full Name:</label>
        <input type="text" id="name" placeholder="Enter your name" required>
        
        <label for="email">Email:</label>
        <input type="email" id="email" placeholder="Enter your email" required>
        
        <label for="password">Password:</label>
        <input type="password" id="password" placeholder="Enter your password" required>
        
        <button type="submit">Sign Up</button>

        <p>Already have an account? <a href="login.php">Login here</a></p>
    </form>
    
</body>
</html>
