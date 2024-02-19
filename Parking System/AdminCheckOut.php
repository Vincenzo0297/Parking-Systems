<?php
    session_start();
    require 'dbConnection.php';

    if(isset($_POST['userID'])){
        $userID = $_POST['userID'];
        $userSQLQuery = "SELECT * FROM users WHERE userID = $userID";
        $userStatement = mysqli_query($con, $userSQLQuery);
        $userData = mysqli_fetch_assoc($userStatement);
        $username = $userData['userName'];
    }

    if(isset($_POST['LocationID'])) {
        $userID = $_POST["userID"];
        $locationID = $_POST['LocationID'];
        $systemSQLStatement = "SELECT * FROM systems WHERE userID = '$userID' AND LocationID = '$locationID' AND ExpectedEndHour IS NOT NULL AND EndHour = 0 ";
        $systemStatement = mysqli_query($con, $systemSQLStatement);
        $SystemDate = mysqli_fetch_assoc($systemStatement);
    }
        
    if(isset($_POST['submit'])) {
        $userID = $_POST["userID"];
        $locationID = $_POST["ClickLocation"];
        $EndHours = $_POST["EndHour"];
        $EndMinutes = $_POST["EndMinutes"];

        $locationSQLstatement = "SELECT * FROM locations WHERE LocationID = $locationID";
        $locationstatement = mysqli_query($con, $locationSQLstatement);
        $locationData = mysqli_fetch_assoc($locationstatement);
            
        $systemSQLStatement = "SELECT * FROM systems WHERE userID = '$userID' AND LocationID = '$locationID' AND ExpectedEndHour IS NOT NULL AND EndHour = 0 ";
        $systemStatement = mysqli_query($con, $systemSQLStatement);
        $SystemDate = mysqli_fetch_assoc($systemStatement);
         
        //Doing Logic
        $startHours = $SystemDate['StartHour'];
        $startMinutes = $SystemDate['StartMinutes'];
        $duration = $SystemDate['Duration'];
        $CostPerHrCheckOut = $locationData['CostPerHr'];
        $LateCostCheckOut = $locationData['LateCost'];
    
        if(mysqli_num_rows($systemStatement) > 0) {
            
            $NormalPrice = $CostPerHrCheckOut * $duration;
            $startTotalMinutes = ($startHours * 60) + $startMinutes;
            $endTotalMinutes = ($EndHours * 60) + $EndMinutes;

            $totalMinutes = $endTotalMinutes - $startTotalMinutes;
            $totalHours = $totalMinutes / 60;

            $TotalLateCostPerHr = $totalHours - $duration; 

            if ($$TotalLateCostPerHr > 0) {
                $TotalLateCost = $$TotalLateCostPerHr * $LateCostCheckOut;
                $TotalCost = $NormalPrice + $TotalLateCost;
            } else {
                $TotalCost = $duration * $NormalPrice;
            }
        
            $updateLocation = "UPDATE locations SET Capacity = Capacity - 1 WHERE LocationID = '$locationID'";
            $update = mysqli_query($con, $updateLocation);
        
            $updateSystem = "UPDATE systems SET EndHour ='$EndHours', EndMinutes = '$EndMinutes', TotalCost ='$TotalCost' WHERE userID ='$userID' AND LocationID = '$locationID' AND StartHour IS NOT NULL AND EndHour = 0";
            if(mysqli_query($con, $updateSystem) == TRUE){
                echo '<script>
                            alert("'. $username .'\nTotal Cost:$'. $TotalCost.'\nLate Cost$'.$TotalLateCost.'");
				            window.location.href="AdminViewUsers.php";
                    </script>';
            } else{
                echo '<script>
                        alert("Check Out fail")
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
    <title>Check Out</title>
</head>

<body>
    <form action="AdminCheckOut.php" method="POST">
        <input type="hidden" name="userID" value="<?php echo $userData['userID']?>">	
      
        <h2>Admin Check Out User Parking Location</h1>
        <div class="btn-container">
            <a href="AdminViewUsers.php" class="btn">Back to View user Page</a>
        </div>

        <table>
            <tr>
                <th>Location Name</th>
                <th>Capacity</th>
                <th>Parking Space</th>
                <th>Date</th>
                <th>Duration</th>
                <th>Check to Check Out</th>
            </tr>
                <?php 
                        $RowData = 0;
                        $SelectSQLstatment = "SELECT s.LocationID, s.LocationName AS LocationName, s.Capacity, s.ParkingSpace, t.StartHour, t.StartMinutes, t.EndHour, t.EndMinutes, t.Duration, t.TotalCost, t.Date, t.ExpectedEndHour, t.ExpectedEndMinutes FROM systems t JOIN users u ON t.userID = u.userID JOIN locations s ON t.LocationID = s.LocationID WHERE u.userID = '$userID' AND t.StartHour IS NOT NULL AND t.EndHour = 0";
                        $filterStatement = mysqli_query($con, $SelectSQLstatment);
                        $RowData = mysqli_num_rows($filterStatement);
                        
                        for ($i = 0; $i < $RowData; $i++) {
                        $displayRow = mysqli_fetch_assoc($filterStatement);
                ?>
                <tr>
                    <td><?php echo $displayRow['LocationName'];?></td>
                    <td><?php echo $displayRow['Capacity'];?></td>
                    <td><?php echo $displayRow['ParkingSpace'];?></td>
                    <td><?php echo $displayRow['Date'];?></td>
                    <td><?php echo $displayRow['Duration'];?></td>
                    <td>
                        <input type="radio" name="ClickLocation" value="<?php echo $displayRow['LocationID']; ?>" required>
                    </td>
                </tr>

                <?php
                    }
                ?>
        </table>
        
        <table>
            <tr>
                <td>
                    <label>Current Time (24 Hour Format):</label>
                    <select name="EndHour">
                    <?php foreach (range(1, 24) as $hour): ?>
                            <option value="<?php echo $hour; ?>"><?php echo $hour; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>

            <tr>
                <td>
                    <label>Enter Minutes</label>
                    <input type="number" name="EndMinutes" min="0" max="59" required><br>
                </td>
            </tr>
        </table>
            <input type="submit" name="submit" value="Check Out" class="btn">
        </form>
    </body>
</html>
