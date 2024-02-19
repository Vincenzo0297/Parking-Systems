<?php
    session_start();
    $userName = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adminstrator</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body> 
    <form action="Logout.php" method="POST">
        <div class="container">
            <h1>Adminstrator: <?php echo $userName; ?></h1>
            <div class="user-panel">
                <a href="AdminViewLocation.php">List of Parking Locations</a>
                <a href="AdminViewUsers.php">List of All Users</a>
                <button type="submit" name="Logout">Logout</button>
            </div>
        </div>
    </form>
</body>
</html>