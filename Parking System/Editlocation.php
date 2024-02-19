<?php
    require 'dbConnection.php';
    session_start();

    $message = $locationmessage = $descmessage = $spacemessage = $costmessage = $latemessage = "";

    //Check if LocationID is set in the POST request
    if(isset($_POST['LocationID'])) {
        $_SESSION['LocationID'] = $_POST['LocationID'];  //Store the 'LocationID' information value in the session variable, so that other files can use this information
        $sql = "SELECT * FROM locations WHERE LocationID =" . $_POST['LocationID']; //Construct this statement using 'LocationID' from the POST request
        $result = mysqli_query($con, $sql);   //Execute the SQL query
        $locationRow = mysqli_fetch_assoc($result); //Fetch the result row as an associative array
    } 

    if(isset($_POST['submit'])) {   //Check if the form for editing the location has been submitted
        // Initialize the variables 
        $LocationID = $_SESSION['LocationID'];  //Retrieve the LocationID from the session
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
            $costmessage = "Must be valid cost format";
        } elseif (!preg_match("/^[$]?\d+(\.\d+)?$/", $latecost)) {
            $latemessage = "Must be valid cost format";
        } else {  
            //Update the location in the database
            $updateLocation = "UPDATE locations SET   
            LocationName = '$locationName', 
            DescriptionLocation = '$descriptionLocation', 
            ParkingSpace = '$parkSpace', 
            CostPerHr = '$costperhr', 
            LateCost = '$latecost' 
            WHERE LocationID = '$LocationID'";

            if(mysqli_query($con, $updateLocation)){ //check variables if is execute the sql in the database
                $message = "Location Has Updated Successfully.";
            } else {
                $message = "Insert Error: " . mysqli_error($con);
            }
        }    
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Location</title>
    <link rel="stylesheet" href="css/styles3.css">
</head>

<body>
    <form action="Editlocation.php" method="POST">
        <h2>Edit Location</h2>
        <table>
            <tr>
                <td>
                    <label for="LocationName">Name of the Location:</label>
                    <input type="text" id="LocationName" name="LocationName" required>
                    <span><?php echo $locationmessage; ?></span>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="DescriptionLocation">Location Description:</label>
                    <textarea id="DescriptionLocation" name="DescriptionLocation" required></textarea>
                    <span><?php echo $descmessage; ?></span>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="ParkingSpace">Parking Space (Capacity):</label>
                    <input type="text" id="ParkingSpace" name="ParkingSpace" required>
                    <span><?php echo $spacemessage; ?></span>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="CostPerHr">Cost ($) per hour:</label>
                    <input type="text" id="CostPerHr" name="CostPerHr" required>
                    <span><?php echo $costmessage; ?></span>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="LateCost">Cost ($) per hour for late check-out:</label>
                    <input type="text" id="LateCost" name="LateCost" required>
                    <span><?php echo $latemessage; ?></span>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="submit" class="btn-create" id="submit" name="submit" value="Update">
                    <span class="message"><?php echo $message; ?></span>
                    <a href="AdminViewLocation.php" class="back-link">Back to View Location</a>
                </td>
            </tr>
        </table>
    </form>
</body>
</html>
