<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles2.css">
    <title>List of Parking Locations</title>
</head>

<?php
    require 'dbConnection.php'; // Include the database connection file
   
    session_start();
    $userName = $_SESSION['username'];
    $userID = $_SESSION['userID'];
    
    $searchLocation = "";

    // Fetch records with or without search query
    if(isset($_POST['search'])){
        $searchLocation = $_POST['search'];
        // If search query is not empty, modify SQL query to include search filter
        $sql = "SELECT * FROM locations WHERE LocationID Like '%$searchLocation%' OR LocationName LIKE '%$searchLocation%'  OR DescriptionLocation LIKE '%$searchLocation%' ORDER BY LocationID";
    }else{
        $sql = "SELECT * FROM locations ORDER BY LocationID";
    }


    if(isset($filterLocation)){
        $filterLocation = $_POST['filter'];
        if($filterLocation == "PastSpace"){
            // Filter locations where the number of occupied spaces is less than the total capacity
            $sql = "SELECT * FROM locations WHERE Capacity > ParkingSpace ORDER BY LocationID";
        } elseif($filterLocation == "CurrentSpace"){
            // Filter locations where the number of occupied spaces is equal to the total capacity
            $sql = "SELECT * FROM locations WHERE Capacity = ParkingSpace ORDER BY LocationID";
        } elseif($filterLocation == "AvailableSpace"){
            // Show all locations regardless of space availability
            $sql = "SELECT * FROM locations ORDER BY LocationID";
        }
    }    
    $result = mysqli_query($con, $sql);// Execute SQL query
?>

<body>
    <h2>List of All Locations</h2>
    <form method="POST" action="">
        <input type="text" name="search" placeholder="Search by User location" value="<?php echo $searchLocation; ?>">
        <button type="submit">Search</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>LocationID</th>
                <th>Location Name</th>
                <th>Description</th>
                <th>Capacity</th>
                <th>ParkingSpace (Capacity)</th>
                <th>CostPerHr ($)</th>
                <th>LateCost ($)</th>
                <th>Check In</th>
                <th>Check Out</th>
            </tr>
        </thead>

        <tbody>
            <?php
                while ($locationrow = mysqli_fetch_assoc($result)) {
            ?>
            <tr>
                <td><?php echo $locationrow['LocationID'] ?> </td>
                <td><?php echo $locationrow['LocationName'] ?> </td>
                <td><?php echo $locationrow['DescriptionLocation'] ?> </td>
                <td><?php echo $locationrow['Capacity'] ?> </td>
                <td><?php echo $locationrow['ParkingSpace'] ?> </td>
                <td><?php echo $locationrow['CostPerHr'] ?> </td>
                <td><?php echo $locationrow['LateCost'] ?> </td>
                <td>
                    <form action='UserCheckIn.php' method='POST'>
                        <input type='hidden' name='userID' value="<?php echo $locationrow['LocationID']; ?>">
                        <input type='submit' value='Check In' class='btn'>
                    </form>
                </td>

                <td>
                    <form action='UserCheckOut.php' method='POST'>
                        <input type='hidden' name='userID' value="<?php echo $locationrow['LocationID']; ?>">
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
    <h2>List of All User Checked In</h2>       
    <table>
        <thead>
            <tr>
                <th>Location Name</th>
                <th>Capacity</th>
                <th>ParkingSpace (Capacity)</th>
                <th>Check In Date</th>
                <th>Start Time</th>
                <th>End Time</th>
            </tr>
        </thread>

        <tbody>
            <?php
                $displayuser = "SELECT l.LocationName, s.Date, s.StartHour, s.StartMinutes, s.ExpectedEndHour, s.ExpectedEndMinutes, l.Capacity, l.ParkingSpace 
                                FROM systems s
                                JOIN users u ON s.userID = u.userID
                                JOIN locations l ON s.LocationID = l.LocationID";
                                
                    $displayrowresult = mysqli_query($con, $displayuser);
                    while ($displayrow = mysqli_fetch_assoc($displayrowresult)) {
                ?>

                <tr>
                    <td><?php echo $displayrow['LocationName'] ?></td>
                    <td><?php echo isset($displayrow['Capacity']) ? $displayrow['Capacity'] : ''; ?> </td>
                    <td><?php echo isset($displayrow['ParkingSpace']) ? $displayrow['ParkingSpace'] : ''; ?> </td>
                    <td><?php echo $displayrow['Date'] ?></td>
                    <td><?php echo str_pad($displayrow['StartHour'], 2, '0', STR_PAD_LEFT) . ":" . str_pad($displayrow["StartMinutes"], 2, '0', STR_PAD_LEFT); ?></td>
                    <td><?php echo str_pad($displayrow['ExpectedEndHour'], 2, '0', STR_PAD_LEFT) . ":" . str_pad($displayrow["ExpectedEndMinutes"], 2, '0', STR_PAD_LEFT); ?></td>
                </tr>
            <?php
                }
            ?>
        </tbody>
    </table>
    
    <form action="UserViewLocation.php">
        <select name="filter">
            <option value="AvailableSpace">All available spaces</option>
            <option value="PastSpace">All Past Space</option>
            <option value = "CurrentSpace">All currently using;</option>
        </select>
        <input class="btn" type="submit" name="filterLocation" value="Filter Location">
    </form>

    <div class="record">
        <?php echo mysqli_num_rows($displayrowresult) . " records found"; ?>
    </div>

    <div class="btn-container">
        <a href="User.php" class="btn">Back to User Page</a>
    </div>
</body>
</html>