<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register form</title>
    <link rel="stylesheet" href="css/styles1.css">
</head>
<body>
    <?php
        require 'dbConnection.php';
        $message = $namemessage = $surnamemessage = $passwordmessage = $numbermessage = $emailmessage =  ""; //Initlize for error messages;
        
        if(isset($_POST['submit'])) { //Check before Submitting

            //Initilize the variables 
            $username = $_POST['userName'];
            $usersurname = $_POST['userSurname'];
            $userpassword = $_POST['userPassword'];
            $usernumber = $_POST['userNumber'];
            $useremail = $_POST['userEmail'];
            $userrole = $_POST['userRole'];

            //Form validation check 
            if (!preg_match("/^[a-zA-Z]*$/", $username)) {
                $namemessage = "Only letters and white space allowed in name field";
            } elseif(!preg_match("/^[a-zA-Z]*$/", $usersurname)){
                $surnamemessage = "Only letters and white space allowed in name field";
            } elseif (!preg_match("/^[a-zA-Z0-9!@#$%^&*]+$/", $userpassword)) {
                $passwordmessage = "Password must contain only letters (both uppercase and lowercase), numbers, and special characters";
            } elseif (!preg_match("/^\d{9}$/", $usernumber)) {
                $numbermessage = "Phone number must be 9 digits long";
            } elseif (!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $useremail)) {
                $emailmessage = "Invalid email format";
            } else {
                //Insert sql statement to database
                $insertUser = "INSERT INTO `users`(`userName`, `userSurname`,`userPassword`, `userNumber`, `userEmail`, `userRole`) VALUES ('$username', '$usersurname', '$userpassword', '$usernumber', '$useremail', '$userrole')";
                
                //Insert to database successful
                if(mysqli_query($con, $insertUser)){
                    $message = "User registered successfully";
                }
            }
        }
    ?>
    
    <form action="Register.php" method="POST">
        <table>
            <tr>
                <td>
                    <label>Name:</label>
                    <input type="text" id="userName" name="userName" placeholder="Barack Hussein" required>
                    <span><?php echo $namemessage; ?></span> <!--Display validation error messages -->
                </td>
            </tr>
            <tr>
                <td>
                    <label>Surname:</label>
                    <input type="text" id="userSurname" name="userSurname" placeholder="Obama" required>
                    <span><?php echo $surnamemessage; ?></span> <!--Display validation error messages -->
                </td>
            </tr>
            <tr>
                <td>
                    <label>Password:</label>
                    <input type="password" id="userPassword" name="userPassword" placeholder="Obama123!" required>
                    <span><?php echo $passwordmessage; ?></span> <!--Display validation error messages -->
                </td>
            </tr>
            <tr>
                <td>
                    <label>Phone Number:</label>
                    <input type="text" id="userNumber" name="userNumber" placeholder="95423521" required>
                    <span><?php echo $numbermessage; ?></span> <!--Display validation error messages -->
                </td>
            </tr>
            <tr>
                <td>
                    <label>Email:</label>
                    <input type="email" id="userEmail" name="userEmail" placeholder="Obama69@gmail.com" required>
                    <span><?php echo $emailmessage; ?></span> <!--Display validation error messages -->
                </td>
            </tr>
            <tr>
                <td>
                    <label>Roles:</label>
                    <select name="userRole">
                        <option value="admin">Adminstrator</option>
                        <option value="user">User</option>
                    </select>
                </td>
            </tr>
        </table>
        <input type="submit" id="submit" name="submit" value="Register"> <br>
        <span> <?php echo $message ?> </span> <!--Display validation error messages -->
        <a href="Login.php">Back to Login Page</a>
    </form>
</body>
</html>