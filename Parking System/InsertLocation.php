<!-- Stanard insert Location structure -->
<?php
    require 'dbConnection.php';

    $message = $locationmessage = $descmessage = $spacemessage = $costmessage = $latemessage = "";

    if(isset($_POST['submit'])) {
        // Initialize the variables 
        $locationName = $_POST['LocationName'];
        $descriptionLocation = $_POST['DescriptionLocation'];
        $parkSpace = $_POST['ParkingSpace'];
        $costperhr = $_POST['CostPerHr'];
        $latecost = $_POST['LateCost'];

         //Form validation check 
         if (!preg_match("/^[a-zA-Z\s]*$/", $locationName)) {
            $locationmessage = "Only letters and white space allowed in name field";
        } elseif (!preg_match("/^[a-zA-Z\s]*$/", $descriptionLocation)) {
            $descmessage = "Only letters and white space allowed in description field";
        } elseif (!preg_match("/^\d+$/", $parkSpace)) {
            $spacemessage = "Must contain only numbers";
        } elseif (!preg_match("/^[$]?\d+(\.\d+)?$/", $costperhr)) {
            $costmessage = "Must contain only numbers";
        } elseif (!preg_match("/^[$]?\d+(\.\d+)?$/", $latecost)) {
            $latemessage = "Must contain only numbers";
        } else {
            // Insert SQL statement into database
            $insertLocation = "INSERT INTO `locations`(`LocationName`, `DescriptionLocation`, `Capacity`, `ParkingSpace`, `CostPerHr`, `LateCost`) 
            VALUES ('$locationName', '$descriptionLocation', '0', '$parkSpace', '$costperhr', '$latecost')";
            
            if(mysqli_query($con, $insertLocation)){ //check variables if is execute the sql in the database
                $message = "Location Has Created Successfully.";
            } else {
                $message = "Error: " . mysqli_error($con);
            }
        }
        //the 0 is to increase to max capacity but the parkingspace is for admin to determine the the max capacity that the carpark can hold.
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert New Location</title>
    <link rel="stylesheet" href="css/styles3.css">
</head>

<body>
    <form action="InsertLocation.php" method="POST">
        <h2>Insert New Location</h2>
        <table>
            <tr>
                <td>
                    <label for="LocationName">Name of the Location:</label>
                    <input type="text" id="LocationName" name="LocationName" required>
                    <span class="message"><?php echo $locationmessage; ?></span>
                </td>
            </tr>

            <tr>
                <td>
                    <label for="DescriptionLocation">Location Description:</label>
                    <textarea id="DescriptionLocation" name="DescriptionLocation" required rows="3" cols="40"></textarea>
                    <span class="message"><?php echo $descmessage; ?></span>
                </td>
            </tr>
            
            <tr>
                <td>
                    <label for="ParkingSpace">Parking Space (Capacity):</label>
                    <input type="text" id="ParkingSpace" name="ParkingSpace" required>
                    <span class="message"><?php echo $spacemessage; ?></span>
                </td>
            </tr>

            <tr>
                <td>
                    <label for="CostPerHr">Cost ($) per hour:</label>
                    <input type="text" id="CostPerHr" name="CostPerHr" required>
                    <span class="message"><?php echo $costmessage; ?></span>
                </td>
            </tr>

            <tr>
                <td>
                    <label for="LateCost">Cost ($) per hour for late check-out:</label>
                    <input type="text" id="LateCost" name="LateCost" required>
                    <span class="message"><?php echo $latemessage; ?></span>
                </td>
            </tr>
            
            <tr>
                <td>
                    <input type="submit" class="btn-create" id="submit" name="submit" value="Create">
                    <span class="message"><?php echo $message; ?></span>
                    <a href="AdminViewLocation.php" class="back-link">Back to View Location</a>
                </td>
            </tr>
        </table>
    </form>
</body>
</html>