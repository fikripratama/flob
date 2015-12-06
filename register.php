# flob a simple social media sites, building with bootstrap

<?php
	session_start();
	if(isset($_SESSION["userlogin"])){
		header("Location: home.php");
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Registration</title>
		<meta charset="utf-8">
		<meta name="Description" content="Login Page">
		<link rel="stylesheet" type="text/css" href="../CSS/loginPage.css" id="loginPageCss">
	</head>
	<body>
		<div id="header">
			<h1>Welcome to <br> FLOB.</h1>
		</div>
		<div id="error">
			<br><br>
			<?php
			$username ="";
			$password ="";
			$email="";
			$fullname="";
			$birthdate="";
			$address="";
			$description="";
			$phone="";
			if(isset($_GET['username'])){
				$username = $_GET['username'];
				$password = $_GET['password'];
				$email = $_GET['email'];
				$fullname = $_GET['fullname'];
				$birthdate = $_GET['birthdate'];
				$address = $_GET['address'];
				$description = $_GET['description'];
				$phone = $_GET['phone'];
				
				//memasukkan data
				$conn = connectDB();
				if($username!=''&&$password!=''&&$email!=''&&$fullname!=''
					&&$address!=''&&$phone!=''&&$description!=''&&$birthdate!='0000-00-00')
				{
					$sql = "INSERT into user (username ,password ,email ,fullname ,birthdate ,address ,description ,phone)
				 		values('$username','$password','$email','$fullname','$birthdate','$address','$description','$phone')";
				 		if ($conn->query($sql) === TRUE) {
						echo "Username Added";
						$username ="";
						$password ="";
						$email="";
						$fullname="";
						$birthdate="";
						$address="";
						$description="";
						$phone="";
						header("Location: login.php");
					} else {
						echo "Form filled with non-valid text";
					}
				}
				else {
					echo "Form filled with non-valid text";
				}
			}
			
			function connectDB(){
				$servername = "localhost";
				$username = "root";
				$password = "";
				$dbName = "tugasakhir";

				// Create connection
				$conn = mysqli_connect($servername, $username, $password, $dbName);

				// Check connection
				if (!$conn) {
					die("Connection failed: " . mysqli_connect_error());
				}
				return $conn;
			}
			
		?><br><br>
		</div>
		<div id="login">
			<form method="GET" action="register.php">
				<h2>Register Here!</h2><br>
				<input type="text" name="fullname" placeholder="Full Name" value="<?php echo $fullname;?>"><br>
				<input type="date" name="birthdate" placeholder="Birthdate" value="<?php echo $birthdate;?>"><br>
				<input type="text" name="username" placeholder = "Username" value="<?php echo $username;?>"><br>
				<input type="text" name="address" placeholder = "Address" value="<?php echo $address;?>"><br>
				<input type="tel" name="phone" placeholder = "Phone Number" value="<?php echo $phone;?>"><br>
				<input type="email" name="email" placeholder = "Email" value="<?php echo $email;?>"><br>
				<input type="password" name="password" placeholder = "Password" ><br>
				<input type="text" name="description" placeholder = "Describe Yourself Here" value="<?php echo $description;?>"><br><br>
				<input type="submit" value="Register" id="loginButton"><br><br>
			</form>
		</div><br><br>
	</body>
</html>
