<?php
    session_start();
    $userName = $_SESSION['username'];
    $userID = $_SESSION['userID'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <form action="Logout.php" method="POST">
        <div class="container">
            <h1>Welcome to User Page</h1>
            <div class="user-panel">
                <a href="UserViewLocation.php">List All Parking Locations</a>
                <button type="submit" name="Logout">Logout</button>
            </div>
        </div>
    </form>
</body>
</html>