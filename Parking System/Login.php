<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/styles1.css">
</head>
<body>
    <?php
        session_start();
        require 'dbConnection.php';

        $message = ""; 

        if(isset($_POST['submit'])) {
            $username = $_POST['userName'];
            $password = $_POST['userPassword'];
            
            //Query to check if the provided credentials exist in the database
            $query = "SELECT * FROM users WHERE userName='$username' AND userPassword='$password'";
            $result = mysqli_query($con, $query);
            
            if(mysqli_num_rows($result) == 1) {
                // If the user exists, retrieve their role from the database
                $user = mysqli_fetch_assoc($result);
                
                //Start session and store the user name, ID and role
                $_SESSION['username'] = $user['userName'];
                $_SESSION['userID'] = $user['userID'];
                $userType = $user['userRole'];

                //Redirect  to users based on their roles
                if($userType == 'admin') {
                    header('Location: Adminstrator.php'); 
                } else {
                    header('Location: User.php'); 
                }
                exit();
            } else {
               //Display message error
                $message = "Invalid username or password";
            }
        }
    ?>

    <form action="Login.php" method="POST">
        <table>
            <tr>
                <td>
                    <label>Enter User Name:</label>
                    <input type="text" id="userName" name="userName" placeholder="Donald Trump">
                </td>
            </tr>
            <tr>
                <td>
                    <label>Enter Passwords:</label>
                    <input type="password" id="userPassword" name="userPassword" placeholder="Trump123!">
                </td>
            </tr>
            <tr> <td> <span> <?php echo $message ?> </span> </td> </tr> <!--Error message will display here -->
            <tr>
                <td>
                    <label>Click here to <a href="Register.php">Register Account</a> </label>
                </td>
            </tr>
        </table>
        <input type="submit" id="submit" name="submit" value="Login">
    </form>
</body>
</html>