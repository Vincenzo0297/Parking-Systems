<?php
    require 'dbConnection.php';
    $searchLocation = "";

    //Search for locations ID, name, and description in the database
    if(isset($_POST['search'])){
        $searchLocation = $_POST['search'];
        //If search query is not empty, modify SQL query to include search filter
        $sql = "SELECT * FROM locations WHERE LocationID Like '%$searchLocation%' OR LocationName LIKE '%$searchLocation%'  OR DescriptionLocation LIKE '%$searchLocation%' ORDER BY LocationID";
    } else {
        $sql = "SELECT * FROM locations ORDER BY LocationID";
    }

    //Filter Capacity Space
    if (isset($_POST['filterLocation'])) {
        $filterLocation = $_POST["filter"];
        if ($filterLocation == "CurrentAvailableSpace") {
            $sql = "SELECT * FROM locations WHERE Capacity < ParkingSpace ORDER BY LocationID";
        } elseif ($filterLocation == "FullSpace") {
            $sql = "SELECT * FROM locations WHERE Capacity >= ParkingSpace ORDER BY LocationID";
        }elseif($filterLocation == "AllSpace"){
            $sql = "SELECT * FROM locations ORDER BY LocationID";
        }
    }
    $result = mysqli_query($con, $sql);// Execute SQL query
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles2.css">
    <title>List of All Locations</title>
</head>
<body>
    <h2>List of All Locations</h2>

    <form method="POST" action="">
        <input type="text" name="search" placeholder="Search by User location" value="<?php echo $searchLocation; ?>">
        <button type="submit">Search</button>
    </form>

    <div class="btn-container">
        <a href="InsertLocation.php" class="btn">Create New Location</a>
    </div>

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
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php
                while ($locationrow = mysqli_fetch_assoc($result)) {
            ?>
                <tr>
                    <td><?php echo $locationrow['LocationID']; ?></td>
                    <td><?php echo $locationrow['LocationName']; ?></td>
                    <td><?php echo $locationrow['DescriptionLocation']; ?></td>
                    <td><?php echo $locationrow['Capacity']; ?></td>
                    <td><?php echo $locationrow['ParkingSpace']; ?></td>
                    <td><?php echo $locationrow['CostPerHr']; ?></td>
                    <td><?php echo $locationrow['LateCost']; ?></td>
                    <td>
                        <form action='Editlocation.php' method='POST'>
                            <input type='hidden' name='LocationID' value="<?php echo $locationrow['LocationID']; ?>">
                            <input type='submit' value='Edit' class='btn'>
                        </form>
                    </td>
                    <td>
                        <form action='DeleteLocation.php' method='POST'>
                            <input type='hidden' name='LocationID' value="<?php echo $locationrow['LocationID']; ?>">
                            <input type='submit' value='Delete' class='btn'>
                        </form>
                    </td>
                </tr>
            <?php
                }
            ?>
        </tbody>
    </table>

    <form action="AdminViewLocation.php" method="POST">
        <select name="filter">
            <option value="CurrentAvailableSpace">Current Available Space</option>
            <option value="FullSpace">Current Full Space</option>
            <option value = "AllSpace">All Space</option>
        </select>
        <input class="btn" type="submit" name="filterLocation" value="Filter Location">
    </form>

    <div class="record">
        <?php echo mysqli_num_rows($result) . " records found"; ?>
    </div>

    <div class="btn-container">
        <a href="Adminstrator.php" class="btn">Back to Administrator Page</a>
    </div>
</body>
</html>
