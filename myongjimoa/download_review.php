<?php
	require("../config/config.php");
	require("../lib/db.php");
	$conn = db_init($config["host"], $config["duser"], $config["dpw"], $config["dname"]);

	mysqli_set_charset($conn, "utf-8");

	$restaurant_id = $_POST["restaurant_id"];
	$count_review_id = $_POST["count_review_id"];

	$review_result = array();
	$sql = "SELECT score, review_num FROM `restaurant` WHERE id=".$restaurant_id;
	$res = mysqli_query($conn, $sql);
	$row = mysqli_fetch_array($res);
	$review_result["score"] = $row[0];
	$review_result["review_num"] = $row[1];

	$sql = "SELECT `review`.`id`, `review`.`description`, `user`.`number`, `user`.`major`, `user`.`nickname`, `review`.`score`, `review`.`date` FROM `review` LEFT JOIN `user` ON `review`.`user_id`=`user`.`id` WHERE `review`.`restaurant_id`=".$restaurant_id." AND `review`.`id`<".$count_review_id." ORDER BY `review`.`id` DESC LIMIT 15";

	$res = mysqli_query($conn, $sql);
	$result = array();
	
	if($res) {
		while($row = mysqli_fetch_array($res)) {

			$sql = "SELECT `path` FROM `review_images` WHERE `review_id` = ".$row[0];
			$result2 = array();
			$path_res = mysqli_query($conn, $sql);
			if($path_res) {
				while($row2 = mysqli_fetch_array($path_res)) {
					array_push($result2, $row2[0]);
				}
			}

			array_push($result,
				array("id"=>$row[0],
				"description"=>$row[1],
				"number"=>$row[2],
				"major"=>$row[3],
				"nickname"=>$row[4],
				"score"=>$row[5],
				"date"=>$row[6],
				"images"=>$result2));
		}
		$review_result["list"]=$result;
		echo json_encode($review_result, JSON_UNESCAPED_UNICODE);
	} else {
	
	}
	mysqli_close($conn);
?>
