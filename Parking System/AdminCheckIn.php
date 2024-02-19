<?php
    require 'dbConnection.php';
    session_start();

    if(isset($_POST['userID'])){
        $userID = $_POST['userID'];
        $userSQLstatement = "SELECT * FROM users WHERE userID = $userID ";
        $userQuery = mysqli_query($con, $userSQLstatement);
        $userData = mysqli_fetch_assoc($userQuery);
        $username = $userData['userName'];
    }

    if(isset($_POST['userCheckIn'])){
        $userID = $_POST["userID"];
        $locationID = $_POST['clickLocation'];
        $locationDate = $_POST['Date'];
        $Hour = $_POST['Hour'];
        $Minutes = $_POST["Minutes"];
        $Duration = $_POST['Duration'];
        
        $LocationStatement = "SELECT * FROM locations WHERE LocationID = '$locationID'";
        $LocationQuery = mysqli_query($con, $LocationStatement);
        $LocationData = mysqli_fetch_assoc($LocationQuery);
        
        $systemSQLstatement = "SELECT * FROM systems WHERE userID = '$userID' AND LocationID = '$locationID' AND StartHour != 0 AND EndHour = 0";
        $checkedQuery = mysqli_query($con, $systemSQLstatement);

        if(mysqli_num_rows($checkedQuery) > 0){
            $alertMessage = "You have just check In, Procced to View Location";
            $adminViewLocation = "AdminViewUsers.php";
            echo "<script>alert(\"$alertMessage\"); window.location.href=\"$adminViewLocation\";</script>";
        }else{
            $Locationdate = (new DateTime($locationDate))->format('Y-m-d');
            $Locationduration = $_POST["Duration"];
            $locationcost = $Locationduration * $LocationData['CostPerHr'];
            $locationlatecost = $LocationData['LateCost'];
            $EndTime = $Locationduration + $Hour;
           
            $systemSQLStatement = "INSERT INTO systems (Date, StartHour, StartMinutes, ExpectedEndHour, ExpectedEndMinutes, Duration, userID, LocationID) VALUES('$Locationdate', '$Hour', '$Minutes', '$EndTime', '$Minutes', '$Locationduration', '$userID', '$locationID')";
            $systemQuery = mysqli_query($con, $systemSQLStatement);

            $InsertStatementLocation = "UPDATE locations SET Capacity = Capacity + 1 WHERE LocationID = '$locationID'";
            $InsertStatementLocationQuery = mysqli_query($con, $InsertStatementLocation);

            if($systemQuery == TRUE){
                echo '<script>
                    alert("'. 'Duration: '  . $Locationduration . ' Hour'. '\nLocation Cost: $'. $locationcost . '\nLate Location Cost: $'. $locationlatecost . '")
                            window.location.href="AdminViewUsers.php";
                    </script>';
            } else{
                echo '<script>
                        alert("Error Check In")
                            window.location.href="AdminViewUsers.php";
                     </script>';
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles2.css">
    <title>Check In</title>
</head>

<body>
    <form action="AdminCheckIn.php" method="POST">
        <input type="hidden" name="userID" value="<?php echo $userData['userID']?>">	
      
        <h1>Admin Check In User Parking Location</h1>
        <div class="btn-container">
            <a href="AdminViewUsers.php" class="btn">Back to View user Page</a>
        </div>
        <table>
            <tr>
                <th>LocationID</th>
                <th>Location Name</th>
                <th>Description</th>
                <th>Capacity</th>
                <th>ParkingSpace (Capacity)</th>
                <th>CostPerHr ($)</th>
                <th>LateCost ($)</th>
                <th>Select</th>
            </tr>

            <tbody>
                <?php
                    $LocationCapacity = "SELECT * FROM locations WHERE Capacity < ParkingSpace";
                    $LocationCapacityQuery = mysqli_query($con, $LocationCapacity);
                    $LocationData = mysqli_num_rows($LocationCapacityQuery);

                    if(mysqli_num_rows($LocationCapacityQuery) > 0){
                        while($Datarow = mysqli_fetch_assoc($LocationCapacityQuery)){
                            echo "<tr>";
                                echo "<td>" . $Datarow['LocationID'] . "</td>";
                                echo "<td>" . $Datarow['LocationName'] . "</td>";
                                echo "<td>" . $Datarow['DescriptionLocation'] . "</td>";
                                echo "<td>" . $Datarow['Capacity'] . "</td>";
                                echo "<td>" . $Datarow['ParkingSpace'] . "</td>";
                                echo "<td>" . $Datarow['CostPerHr'] . "</td>";
                                echo "<td>" . $Datarow['LateCost'] . "</td>";
                                echo "<td>" 
                                        . "<input type='radio' name='clickLocation' value='" . $Datarow['LocationID'] . "'>"
                                     ."</td>";   
                            echo "</tr>";
                        }
                    }
                ?>
            </tbody>
        </table>
        
        <table>
            <tr>
                <td>
                    <label>Current Date:</label>
                    <input type="date" name="Date" required><br><br>
                </td>
            </tr>

            <tr>
                <td>
                    <label>Current Time (24 Hour):</label>
                    <select name="Hour">
                        <?php foreach (range(1, 24) as $hour): ?>
                            <option value="<?php echo $hour; ?>"><?php echo $hour; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>

            <tr>
                <td>
                    <label>Enter Minutes</label>
                    <input type="number" name="Minutes" required>
                </td>
            </tr>

            <tr>
                <td>
                    <label>Enter Duration in Hours:</label>
                    <input type="number" name="Duration" min="1" required><br>
                </td>
            </tr>
        </table>
        <input type="submit" name="userCheckIn" value="Check In" class="btn">
    </form>
</body>
</html>
