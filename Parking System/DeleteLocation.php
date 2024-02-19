<?php
    require 'dbConnection.php';

    if(isset($_POST['LocationID'])) {

        $LocationID = $_POST['LocationID'];
        //Delete location from the database
        $deleteQuery = "DELETE FROM locations WHERE LocationID = $LocationID";

        if(mysqli_query($con, $deleteQuery)) {
            echo "The Location has deleted successfully. Refresh the page please";
        } else {
            echo "Error deleting location: " . mysqli_error($con);
        }
    }

    mysqli_close($con); //Close database connection
?>