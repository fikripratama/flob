<!DOCTYPE html>
<html>
<head>
  <title>Post Detail</title>
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
      text-align: justify;
      background-color: lightgrey;
      overflow: hidden;
      float: right;
    }
    .col-sm-9 h1{
      text-align: center;
    }
    
    /* Set black background color, white text and some padding */
    footer {
      background-color: #555;
      color: white;
      padding: 15px;
    }
    .responsesForm{
      text-align: center;
      margin-left: 30%;
      width: 40%;
    }
    .error{
      color: red;
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
          session_start();
          $user='';
          echo "<li><a href='home.php'><span class = 'glyphicon glyphicon-home'></span> Home</a></li>";
          if(isset($_SESSION["userlogin"]))
          { 
            $user = $_GET["userid"];
            echo "<li><a href='about.php'><span class = 'glyphicon glyphicon-user'></span> Profile</a></li>";
            echo "<li><a href='logout.php'><span class = 'glyphicon glyphicon-export'></span> Signout</a></li>";
          }
          else{
            echo "<li><a href='login.php'><span class = 'glyphicon glyphicon-import'></span> Login</a></li>";
          }
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
      $idnya = $_GET["idpost"];
      // define variables and set to empty values
      $commentErr = "";
      $comment = "";
      $harusnya = True;
      $posted = False;
      if(isset($_SESSION["userlogin"])){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
          $posted = True;
            if (empty($_POST["comment"])) {
              $commentErr = "Comment shouldnt be empty!";
              $harusnya = False;
            } else {
               $comment = $_POST["comment"];
            }

            if($harusnya == True && $posted == True)
            { 
              //memasukkan komen ke database
              $conn = connectDB();
              $sql = "INSERT INTO comment (post_id, user_id, date, content) VALUES ('".$idnya."', 
                '".$user."', '".date("Y-m-d")."' , '".$comment."')";
              $name = "";
              $email = "";
              $comment = "";
              if ($conn->query($sql) === TRUE) {
                $isiKomen = "SELECT post_id, user_id, date, content FROM comment";
                $result2 = $conn->query($isiKomen);
              }
            }
        }
      }
    ?>
    <div class="col-sm-9"><br>
      <?php
      // $idnya = $_GET['idpost'];
      $sql1 = "SELECT * FROM post WHERE post_id = $idnya";
      $result1 = $conn->query($sql1);
      $row = $result1->fetch_assoc();
      $namanya = $row["user_id"];
      $sql3 = "SELECT * FROM user WHERE user_id = $namanya";
      $result3 = $conn->query($sql3);
      $row2 = $result3->fetch_assoc();
      echo "<h1>".$row['title']."</h1><br>";
      echo "<p>".$row["content"]."</p><br>";
      echo "<hr><br>Posted on ".$row["date"]."<br>";
      echo "By ".$row2["username"];

      ?>
      <div class="responsesForm">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])."?idpost=".$idnya."&&userid=".$user;?>">
          <?php
            if(isset($_SESSION["userlogin"]))
              {   
                echo "<h3>Please Leave Comment for this Site</h3>";
                echo "<span class='error'>*".$commentErr."</span><br>";
                echo "<textarea class = 'form-control' maxlength='250' cols='80' rows='4' name ='comment' id='comment' placeholder='Masukkan komen.....'></textarea>";
                echo "<br>";
                echo "<input type='submit' class='btn btn-default' name='submit' value='Submit'>";
              } 
            ?>
        </form><br>
      </div>
      <div id="listkomentar">
        <?php
          $idnya = $_GET["idpost"];
          $isiKomen = "SELECT * FROM comment WHERE post_id = $idnya";
          $result5 = $conn->query($isiKomen);
          if($result5->num_rows>0){
            echo "<h2>COMMENT COLUMN</h2>";
            while($row = $result5->fetch_assoc()){
              $pengkomen = $row["user_id"];
              $sql4 = "SELECT * FROM user WHERE user_id = $pengkomen";
              $result4 = $conn->query($sql4);
              $row3 = $result4->fetch_assoc();
              echo "<h3>".$row3["username"]."</h3>".
              "Commented on ".$row["date"]."<br>".
              $row["content"]."<br>"."<br>"."<hr>"."<br>";
            }
          }
          else if($result5->num_rows==0){
            $successMessage = "0 results";
          }
          $conn->close();
        ?>
      </div>
      </div>
    </div>
  </div>
</div>

<footer class="container-fluid">
  <p>Copyright FIKRI PRATAMA</p><br>
</footer>

</body>
</html>
