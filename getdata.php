<?php
	header('Content-type: application/json');
	
	require "database.php";
	
	$conn = connectDB();
	
	$currpos = 0;
	$dataPerPage = 3;
	if(isset($_GET["currpos"]) && isset($_GET["dataPerPage"])){
		$currpos = $_GET["currpos"];
	}
	
	$sql = "SELECT title, date, post_id, snippet FROM post ORDER BY post_id DESC LIMIT 3 OFFSET $currpos";
	$result = $conn->query($sql);
	
	// $sql2 = "SELECT COUNT(*) as number FROM post";
	// $result2 = $conn->query($sql2);
	// $number = 0;
	
	// if($result2->num_rows > 0){
	// 	$row = $result2->fetch_assoc();
	// 	$number = $row["number"];
	// }
	
	// $data = '{"number":'.$number.', "post":[';
	$data ='{"post":[';
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()){
			$data = $data.'{"title":"'.$row['title'].'","date":"'.$row['date'].'","snippet":"'.$row['snippet'].'","post_id":"'.$row['post_id'].'"},';
			$data = trim(preg_replace('/[\s+\n+\r+]+/',' ',preg_replace('/\s+\n+\r+/'," ", $data)));													
		}
	}
	$data = rtrim($data, ","); 
	$data = $data.']}';
	
	echo $data;
?>
