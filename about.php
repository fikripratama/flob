<?php
	session_start();
	if(!isset($_SESSION["userlogin"])){
		header("Location: home.php");
	}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Profile</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  <!-- <link rel="stylesheet" type="text/css" href="../CSS/style.css" id="css-utama"> -->
  <script src="../JQuery/jquery.min.js"></script>
  <script type="text/javascript" src="../JQuery/jquery-2.1.4.js"></script>
  <script type="text/javascript" src="../javaScript/javaScriptUtama.js"></script>
  <style>
    @import url(https://fonts.googleapis.com/css?family=Lobster);
    /* Set height of the grid so .sidenav can be 100% (adjust if needed) */
    
    /* Set gray background color and 100% height */
    .sidenav {
      overflow: hidden;
      position: fixed;
      background-color: black;
      height: 100%;
    }
    .sidenav h1{
      font-family: 'Lobster', cursive;
      font-size: 70px;
    }
    .col-sm-9 {
      text-align: center;
      background-color: lightgrey;
      overflow: hidden;
      float: right;
    }
    
    /* Set black background color, white text and some padding */
    footer {
      background-color: #555;
      color: white;
      padding: 15px;
    }
    
    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        position: relative;
        padding: 15px;
      }
      .row.content {height: auto;} 
    }
  </style>
</head>
<body>

<div class="container-fluid">
  <div class="row content">
    <div class="col-sm-3 sidenav">
      <h1 class="text-center"><a href="index.php">FLOB </a></h1>
      <img class="img-responsive" src="../Picture/head.jpg" alt="Chania" width="345" height="345"><br>
      <ul class="nav nav-pills nav-stacked">
        <?php
          	echo "<li><a href='home.php'><span class = 'glyphicon glyphicon-home'></span> Home</a></li>";
            echo "<li class='active'><a href='about.php'><span class = 'glyphicon glyphicon-user'></span> Profile</a></li>";
            echo "<li><a href='logout.php'><span class = 'glyphicon glyphicon-export'></span> Signout</a></li>";
        ?>
      </ul><br>
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Search Blog..">
        <span class="input-group-btn">
          <button class="btn btn-default" type="button">
            <span class="glyphicon glyphicon-search"></span>
          </button>
        </span>
      </div>
    </div>

    <div class="col-sm-9"><br>
    <?php
            $conn = connectDB();
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
            $userid = $_SESSION['userid'];
			$sql1 = "SELECT * FROM user WHERE user_id = '$userid'";
			$result1 = $conn->query($sql1);
			$row = $result1->fetch_assoc();
    ?>
    	<h1><?php echo $row["fullname"];?></h1>
		<img classs="img-responsive "src= "../Picture/pic.png">
		<h3>
		<?php 	
		echo "<span class='glyphicon glyphicon-user'></span> ".$row["username"];
		echo "<br>";
		echo "<span class='glyphicon glyphicon-menu-down'></span> Lived at ".$row["address"];
		echo "<br>";
		echo "<span class='glyphicon glyphicon-calendar'></span> Born on ".$row["birthdate"];
		echo "<br>";
		echo "<span class='glyphicon glyphicon-fullscreen'></span> ".$row["description"];
		echo "<br>";
		echo "<span class='glyphicon glyphicon-send'></span> ".$row["email"];
		echo " | ";
		echo "<span class='glyphicon glyphicon-phone'></span> ".$row["phone"];
		?></h3><br><br>
    </div>
  </div>
</div>

<footer class="container-fluid">
  <p>Copyright FIKRI PRATAMA</p><br>
</footer>

</body>
</html>
