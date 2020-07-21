<?php
	require("../config/config.php");
	require("../lib/db.php");
	$conn = db_init($config["host"], $config["duser"], $config["dpw"], $config["dname"]);

	mysqli_set_charset($conn, "utf-8");

	$category = $_POST["category"];
	$order = $_POST["order"];

	if(strcmp($category, "restaurant") !== 0) { // 불일치
		
		$sql = "SELECT `".$category."`.`restaurant_id`, `title`, `category`, `telephone`, `homepage`, `address`, `mapx`, `mapy`, `restaurant`.`restaurant_id`, `time`, `menu`, `image`, `review_num`, `score` FROM `".$category."` LEFT JOIN `restaurant` ON `restaurant`.`id`=`".$category."`.`restaurant_id` ORDER BY ".$order." DESC";
	
	} else { // 일치
		
		$sql = "SELECT * FROM `".$category."` ORDER BY ".$order." DESC";
	}

	$res = mysqli_query($conn, $sql);
	$result = array();

	if($res) {
		while($row = mysqli_fetch_array($res)) {
			array_push($result,
				array("id"=>$row[0],
				"title"=>$row[1],
				"category"=>$row[2],
				"telephone"=>$row[3],
				"homepage"=>$row[4],
				"address"=>$row[5],
				"mapx"=>$row[6],
				"mapy"=>$row[7],
				"restaurant_id"=>$row[8],
				"time"=>$row[9],
				"menu"=>$row[10],
				"image"=>$row[11],
				"review_num"=>$row[12],
				"score"=>$row[13]));
		}
		echo json_encode($result, JSON_UNESCAPED_UNICODE);
	} else {
		
	}
	mysqli_close($conn);
?>
