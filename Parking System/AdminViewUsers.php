<?php
    require 'dbConnection.php';
    $searchLocation = "";

    // Fetch records with or without search query
    if(isset($_POST['search'])) {
        $searchLocation = $_POST['search'];
        // If search query is not empty, modify SQL query to include search filter
        $sql = "SELECT * FROM users WHERE userName LIKE '%$searchLocation%' AND userRole = 'user'  OR userID LIKE '%$searchLocation%' ORDER BY userID";
    } else {
        $sql = "SELECT * FROM users WHERE userRole = 'user' ORDER BY userID"; // If search query is empty, retrieve all records
    }
    $result = mysqli_query($con, $sql); // Execute SQL query
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles2.css">
    <title>List of All Users</title>
</head>
<body>
    <h2>List of All Users</h2>

    <form method="POST" action="">
        <input type="text" name="search" placeholder="Search by User Name" value="<?php echo $searchLocation; ?>">
        <button type="submit">Search</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>UserID</th>
                <th>User Name</th>
                <th>User Surname</th>
                <th>User Number</th>
                <th>User Email</th>
                <th>Check In</th>
                <th>Check Out</th>
            </tr>
        </thead>

        <tbody>

            <?php
                while ($userrow = mysqli_fetch_assoc($result)) {
            ?>
            <tr>
                <td> <?php echo $userrow['userID'] ?></td>
                <td> <?php echo $userrow['userName']?></td>
                <td> <?php echo $userrow['userSurname']?></td>
                <td> <?php echo $userrow['userEmail'] ?></td>
                <td> <?php echo $userrow['userNumber']?></td>
                <td>
                    <form action='AdminCheckIn.php' method='POST'>
                        <input type='hidden' name='userID' value="<?php echo $userrow['userID']; ?>">
                        <input type='submit' value='Check In' class='btn'>
                    </form>
                </td>
                <td>
                    <form action='AdminCheckOut.php' method='POST'>
                        <input type='hidden' name='userID' value="<?php echo $userrow['userID']; ?>">
                        <input type='submit' value='Check Out' class='btn'>
                    </form>
                </td>
            </tr>
            <?php
                }
            ?>
        </tbody>
    </table>

    <div class="record">
        <?php echo mysqli_num_rows($result) . " records found"; ?>
    </div>

    <h2>List of Checked In Users</h2>
    <table>
        <thead>
            <tr>
                <th>User Name</th>
                <th>User Surname</th>
                <th>Location Name</th>
                <th>Check In Date</th>
                <th>Start Time</th>
                <th>End Time</th>
            </tr>
        </thead>

        <tbody>
            <?php
                $displayuser = "SELECT u.userName, u.userSurname, l.LocationName, s.Date, s.StartHour, s.StartMinutes, s.ExpectedEndHour, s.ExpectedEndMinutes, l.Capacity, l.ParkingSpace 
                FROM systems s
                JOIN users u ON s.userID = u.userID
                JOIN locations l ON s.LocationID = l.LocationID";

                $displayrowresult = mysqli_query($con, $displayuser);
                while ($displayrow = mysqli_fetch_assoc($displayrowresult)) {
            ?>

            <tr>
                <td><?php echo $displayrow['userName'] ?></td>
                <td><?php echo $displayrow['userSurname'] ?></td>
                <td><?php echo $displayrow['LocationName'] ?></td>
                <td><?php echo $displayrow['Date'] ?></td>
                <td><?php echo str_pad($displayrow['StartHour'], 2, '0', STR_PAD_LEFT) . ":" . str_pad($displayrow["StartMinutes"], 2, '0', STR_PAD_LEFT); ?></td>
                <td><?php echo str_pad($displayrow['ExpectedEndHour'], 2, '0', STR_PAD_LEFT) . ":" . str_pad($displayrow["ExpectedEndMinutes"], 2, '0', STR_PAD_LEFT); ?></td>
            </tr>

            <?php
                }
            ?>
        </tbody>
    </table>
    
    <div class="record">
        <?php echo mysqli_num_rows($displayrowresult) . " records found"; ?>
    </div>

    <div class="btn-container">
        <a href="Adminstrator.php" class="btn">Back to Administrator Page</a>
    </div>
</body>
</html>
