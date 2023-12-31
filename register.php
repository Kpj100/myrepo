<style>
  .form-box {
    max-width: 300px;
   background: #f1f7fe;
   overflow: hidden;
   border-radius: 16px;
   color: #010101;
}

.form {
  position: relative;
  display: flex;
  flex-direction: column;
  padding: 32px 24px 24px;
  gap: 16px;
  text-align: center;
}

/*Form text*/
.title {
  font-weight: bold;
  font-size: 1.6rem;
}

.subtitle {
  font-size: 1rem;
  color: #666;
}

/*Inputs box*/
.form-container {
  overflow: hidden;
  border-radius: 8px;
  background-color: #fff;
  margin: 1rem 0 .5rem;
  width: 100%;
}

.input {
  background: none;
  border: 0;
  outline: 0;
  height: 40px;
  width: 100%;
  border-bottom: 1px solid #eee;
  font-size: .9rem;
  padding: 8px 15px;
}

.form-section {
  padding: 16px;
  font-size: .85rem;
  background-color: #e0ecfb;
  box-shadow: rgb(0 0 0 / 8%) 0 -1px;
}

.form-section a {
  font-weight: bold;
  color: #0066ff;
  transition: color .3s ease;
}

.form-section a:hover {
  color: #005ce6;
  text-decoration: underline;
}

/*Button*/
.form button {
  background-color: #0066ff;
  color: #fff;
  border: 0;
  border-radius: 24px;
  padding: 10px 16px;
  font-size: 1rem;
  font-weight: 600;
  cursor: pointer;
  transition: background-color .3s ease;
}

.form button:hover {
  background-color: #005ce6;
}
  </style>
<div class="form-box">
<form class="form" method="post">
    <span class="title">Sign up</span>
    <span class="subtitle">Create a free account with your email.</span>
    <div class="form-container">
      <input type="text" class="input" placeholder="Full Name" name="name">
			<input type="email" class="input" placeholder="Email" name="email">
			<input type="password" class="input" placeholder="Password" name="password">
    </div>
    <input type="submit" class="button" name="submit" value="submit"> 
  
</form>
<div class="form-section">
  <p>Have an account? <a href="index.php">Log in</a> </p>
</div>
</div>


<?php
	if(isset($_POST['submit']))
	{
		

    $host='localhost';
		$username='root';
		$password='';
    $dbname='accountdb';
    $conn= mysqli_connect($host,$username,$password,$dbname);
    $name= $_POST['name'];
		$email= $_POST['email'];
		$password= $_POST['password'];
    $checkuser= "SELECT * FROM admin where email='$email'";
    $result= mysqli_query($conn,$checkuser);
    $count= mysqli_num_rows($result);
   if($count>0)
    {
      echo
      "<script> alert('Given User has been already registered.') </script>";
    }
    else{
            
		$sql= "INSERT INTO admin (name,email,password) VALUES ('$name','$email','$password')";
		if(mysqli_query($conn, $sql)){
      echo
			"<script> alert('You have been successfully registered.') </script>";
		} else{
			echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
		}
    }

	
		 
		// Close connection
		mysqli_close($conn);

	}
	?>

