<!DOCTYPE html>
<html>
<head>
  <title>FLOB.</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  <!-- <link rel="stylesheet" type="text/css" href="../CSS/style.css" id="css-utama"> -->
  <script src="../JQuery/jquery.min.js"></script>
  <script type="text/javascript" src="../JQuery/jquery-2.1.4.js"></script>
  <style>
    @import url(https://fonts.googleapis.com/css?family=Lobster);
    /* Set height of the grid so .sidenav can be 100% (adjust if needed) */
    .row.content {height: 700px}
    
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
      overflow: hidden;
      background-color: lightblue;
      float: right;
    }
    .col-sm-9 h4{
      text-align: center;
    }
    .col-sm-4 {
      overflow: hidden;
      text-align: right;
    }
    .col-sm-8 {
      overflow: hidden;
      padding-right: 30%;
    }
    .col-sm-9 form{
      text-align: center;
    }
    
    /* Set black background color, white text and some padding */
    footer {
      overflow: hidden;
      background-color: #555;
      color: white;
      padding: 15px;
    }

    .error{
      color: red;
    }
    #footname{
      color: #555;
    }
    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
      .col-sm-4{
        visibility: hidden;
        display: none;
      }
      .sidenav {
        position: relative;
        height: auto;
        padding: 15px;
      }
      .row.content {
        height: auto;
        position: relative;
      } 
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
          echo "<li class='active'><a href='home.php'><span class = 'glyphicon glyphicon-home'></span> Home</a></li>";
          if(isset($_SESSION["userlogin"]))
          {
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

    <div class="col-sm-9">
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
            $user="";
            if(isset($_SESSION["userlogin"]))
            {
              $user=$_SESSION["userid"];
            }
            // define variables and set to empty values
            $title = "";
            $isiPos = "";
            $isiPosErr="";
            $titleErr="";
            $usernya =$user;
            $harusnya = True;
            $posted = False;
            //if(isset($_SESSION["userlogin"])){
              if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $posted = True;
                  if (empty($_POST["isiPos"])) {
                    $isiPosErr = "isi pos tidak boleh kosong!";
                    $harusnya = False;
                  } else {
                     $isiPos = test_input($_POST["isiPos"]);
                  }

                  if (empty($_POST["title"])) {
                    $titleErr = "judul pos tidak boleh kosong!";
                    $harusnya = False;
                  } else {
                     $title = test_input($_POST["title"]);
                  }
                  if($harusnya == True && $posted == True)
                  { 
                    $snippet = substr($isiPos,0,500);
                    //memasukkan komen ke database
                    $conn = connectDB();
                    $sql = "INSERT INTO post ( user_id, title, date, content, snippet) VALUES ( 
                      '".$user."','".$title."', '".date("Y-m-d")."' , '".$isiPos."' , '".$snippet."')";
                    $title = "";
                    $isiPos = "";
                    if ($conn->query($sql) === TRUE) {
                      $isiposnya = "SELECT user_id, title, date, content, snippet FROM post";
                      $result2 = $conn->query($isiposnya);
                    }
                  }
              }
              function test_input($data) {
                 $data = trim($data);
                 $data = stripslashes($data);
                 $data = htmlspecialchars($data);
                 return $data;
              }?>
              <?php
                if(isset($_SESSION["userlogin"]))
                  { 
                    echo "<h2>Write A New Post Here!</h2>";
                  }
              ?>
              <div class="col-sm-4">
                <?php
                  if(isset($_SESSION["userlogin"]))
                  { 
                    echo "<h3>Title</h3>";
                    echo "<br><br><br><br><h3>Isi Postingan</h3>";
                  }
                ?>
              </div>
              <div class="col-sm-8">
                <form method="post" class ="form-group" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>">
                  <?php
                    if(isset($_SESSION["userlogin"]))
                    { 
                       echo "<span id='error'class='error'>*".$titleErr."</span><br>
                        <input type='text' class='form-control' name='title' id='title' placeholder='masukkan judul...' value=".$title."><br>
                        <span id='error' class='error'>*".$isiPosErr."</span><br>
                        <textarea class='form-control' rows='5' name ='isiPos' id='isiPos' placeholder='masukkan isi pos...'value=".$isiPos."></textarea><br>
                        <input type='submit' name='submit' class='btn btn-default' value='Submit'></form><br>";
                    }
                  ?>
              </div>
              <h4><small>RECENT POSTS</small></h4><hr>
              <div id="content">
              </div>
              <div id="buttonLoad">
                <button id="button1" type="button" class="btn btn-primary">Load More</button><br><br>
              </div>
    </div>
  </div>
</div>

<footer class="container-fluid">
  <div id="footname">
    <?php
      $idnya='';
      if(isset($_SESSION["userlogin"]))
      {
        $idnya = $_SESSION['userid'];
      }
      echo $idnya ;
    ?>
  </div>
  <p>Copyright Fikri Pratama Afif</p>
</footer>

</body>
<script >
      var num_of_data = 0;
      var start = 0;
      var dataPerPage = 3;
      $(document).ready(function(){       
        loadData(start);
      });
      $("#button1").click(function(){
        if(num_of_data-start>=0){
          start+=dataPerPage;
          loadData(start);
        }else{
          window.alert("there is no more post to load !");
        }
      });
      function loadData(start){
        $.ajax({
          url: "getdata.php", 
          method: "GET",
          data: "dataPerPage="+dataPerPage+"&"+"currpos="+start,
          dataType: "json",
          success: function(result){
            console.log(result);
            num_of_data = tampilkanPost(result);
          },
          error: function(xhr){
            alert(xhr.status);
          }
        });
      }
      function tampilkanPost(data){
        // var dataUser = '<table><tr><td></td><td>email</td></tr><tbody>'; 
        var dataPost='';
        var nama = document.getElementById("footname").innerHTML;
        var i = 0;
        for(; i < data.post.length; i++){
          dataPost = dataPost+"<section><h1><a href='newestpost.php?idpost="+data.post[i].post_id+"&&userid="+nama+"'>"+data.post[i].title+"</a></h1>";
          dataPost = dataPost+"<h5><span class='glyphicon glyphicon-time'></span> uploaded on "+data.post[i].date+" </h5>";
          dataPost = dataPost+"<p>"+data.post[i].snippet+".... <a href='newestpost.php?idpost="+data.post[i].post_id+"&&userid="+nama+"'>readmore</a></p></section><br><hr>";
        }     
        $('#content').append(dataPost);
        return i;
      }
    
    </script>
</html>
