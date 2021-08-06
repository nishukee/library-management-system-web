<?php
include_once 'php/config.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/styles.css">
        <title>Login Page</title>
    </head>
    <body>
        <div class="admin-login"> 
            <h1 class="title"><img src="icons/book-half.svg" width="75" height="75"><br>Admin Sign In</h1>
        </div>
        <form method="post">
            <div class="login-box">
                <div class="textbox">
                    Admin Name<br/>
                    <input type="text" name="adminname" value="" autocomplete="off" required>
                </div>
                <div class="textbox">
                    Password<br/>
                    <input type="password" name="password" value="" required>
                </div>
                <input class="button" type="submit" name="login" value="Sign In">                  
            </div>
        </form>
        <?php
            if(isset($_POST['login'])){
                $adminname = $conn->real_escape_string($_POST['adminname']);
                $password = $conn->real_escape_string($_POST['password']);
                if ($adminname != "" && $password != ""){
                    $sql = "SELECT COUNT(*) as countAdmin from adminlogin where adminname=? and password=?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ss",$adminname,$password);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $row = $result->fetch_assoc();
                    $count = $row['countAdmin'];
                    if($count > 0){
                        echo "<script language='javascript'>locatio1n.href = 'AdminPage/adminpage.php';</script>";
                    }
                    else{
                        echo "<script language='javascript'>alert('Incorrect Login Credentials');</script>";
                        echo "<script language='javascript'>location.href = 'index.php';</script>";
                    }
                }

            }
        ?>      
    </body>
</html>