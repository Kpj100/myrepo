<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <Title> Validated LOGIN FORM</Title>
    <style>
      *{
    padding: 0;
    margin: 0;
}
body{
   background: url(bg1.png) no-repeat;
    background-size: cover;
    align-items: center;
    justify-content: center;
    display: flex;
    font-family: sans-serif;
}

.container{
    position: relative;
    margin-top: 100px;
    width: 450px;
    height: auto;
    background: #dedede;
    border-radius: 5px;

}

.label{
    padding: 20px 130px;
    font-size: 35px;
    font-weight: bold;
    color: #130f40;
}
.login_form{
    padding: 20px 40px;
}
.login_form .font{
    font-size: 18px;
    color: #130f40;
    margin: 5px 0;
}
.login_form input{
    height: 40px;
    width: 350px;
    padding: 0 5px;
    font-size: 18px;
    outline: none;
    border: 1px solid silver;
}
.login_form .font2{
    margin-top: 30px;
}
.login_form button{
    margin: 45px 0 30px 0;
    height: 45px;
    width: 365px;
    font-size: 20px;
    color: white;
    outline: none;
    cursor: pointer;
    font-weight: bold;
    background: #1A237E;
    border-radius: 3px;
    border: 1px solid #3949AB;
    transition: .5s;

}
.login_form button:hover{
    background: #151c6a;
}
.login_form #email_error,
.login_form #pass_error{
    margin-top: 5px;
    width: 345px;
    font-size: 18px;
    color: #C62828;
    background: rgba(255,0,0,0.1);
    text-align: center;
    padding: 5px 8px;
    border-radius: 3px;
    border: 1px solid #EF9A9A;
    display: none;
    
}
</style>
</head>
<body>
   
    <div class="container">
    <h1 class="label">LOGIN!!!</h1>
    <form class="login_form" action="" method="post" name="form" onsubmit="return validated()">
    <div class="font">Email or phone</div>
<input autocomplete="off" name="email" required/>
<div id="email_error">Please fill up your Email or phone</div>
<div class="font font2">Password</div>
<input type="password" name="password" required/>
<div id="pass_error">Please fill up your password</div><br>
<div class="pass">Forgot password?</div>
<button type="submit" name="submit">Login</button>
<p>Not a member? <a href="register.php">Sign up</a></p>  
</form>
</div>
</body>
</html>

  <?php      
    include('conn.php'); 
    if(isset($_POST['submit']))
    { 
    $email=$_POST['email'];  
    $password=$_POST['password'];  
      
        //to prevent from mysqli injection  
        $email= stripcslashes($email);  
        $password = stripcslashes($password);  
        $email    = mysqli_real_escape_string($con, $email);  
        $password = mysqli_real_escape_string($con, $password);  
      
        $sql = "select *from admin where email = '$email' and password = '$password'";  
        $result = mysqli_query($con, $sql);  
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);  
        $count = mysqli_num_rows($result);  
          
        if($count == 1){  
            echo 
            header("location: home.php");  
        }  
        else{  
            echo "<script>alert('Login failed. Invalid username or password')</script>";  
        } 
      }    
?> 
  