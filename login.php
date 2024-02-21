<?php

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    // Add error handling for database connection
    $mysqli = require __DIR__ . "/database.php";
    if ($mysqli === false || $mysqli->connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli->connect_error;
        exit();
    }
    
    // Check if email is set before accessing it
    $email = isset($_POST["email"]) ? $mysqli->real_escape_string($_POST["email"]) : "";
    $sql = sprintf("SELECT * FROM users WHERE email = '%s'", $email);
    
    $result = $mysqli->query($sql);
    
    if (!$result) {
        echo "Error: " . $mysqli->error;
        exit();
    }
    
    $users = $result->fetch_assoc();
    
    if ($users) {
        
        if (password_verify($_POST["password"], $users["password_hash"])) {
            
            session_start();
            session_regenerate_id();
            $_SESSION["user_id"] = $users["id"];
            
            header("Location: index.html");
            exit;
        }
    }
    
    $is_invalid = true;
}

?>


<!DOCTYPE html>
<html>
<head>	<head>
        <title>Login</title>
        <link rel="stylesheet" type="text/css" href="/css/main.css" id="styleMode">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Comfortaa">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Audiowide">
        <link rel="manifest" href="/manifest.json">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>
    
    <h1>Login</h1>
    
    <?php if ($is_invalid): ?>
        <em>Invalid login</em>
    <?php endif; ?>
    
    <form method="post">
        <label for="email">email</label>
        <input type="email" name="email" id="email"
               value="<?= htmlspecialchars($_POST["email"] ?? "") ?>">
        
        <label for="password">Password</label>
        <input type="password" name="password" id="password">
        
        <button>Log in</button>
    </form>
    
</body>
</html>








