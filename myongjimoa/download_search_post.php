<?php
	require("../config/config.php");
	require("../lib/db.php");
	$conn = db_init($config["host"], $config["duser"], $config["dpw"], $config["dname"]);

	mysqli_set_charset($conn, "utf-8");

	$search_text = $_POST["search_text"];
	$board_title_id = $_POST["board_title_id"];
	$count_board_id = $_POST["count_board_id"];

	$sql = "SELECT `board`.`id`, `board`.`title`, `board`.`description`, `user`.`number`, `user`.`major`, `board`.`date`, `user`.`nickname` FROM `board` LEFT JOIN `user` ON `board`.`user_id`=`user`.`id` WHERE `board`.`board_title_id`=".$board_title_id." AND `board`.`id`<".$count_board_id." AND (`board`.`title` LIKE '%".$search_text."%' OR `board`.`description` LIKE '%".$search_text."%' OR `user`.`nickname` LIKE '%".$search_text."%') ORDER BY `board`.`id` DESC LIMIT 15";

	$res = mysqli_query($conn, $sql);
	$result = array();

	if($res) {
		while($row = mysqli_fetch_array($res)) {

			$sql = "SELECT `path` FROM `board_images` WHERE `board_id` = ".$row[0];
			$result2 = array();
			$path_res = mysqli_query($conn, $sql);
			if($path_res) {
				while($row2 = mysqli_fetch_array($path_res)) {
					array_push($result2, $row2[0]);
				}
			} else echo "PATH TABLE ERROR";

			$sql = "SELECT count(*) FROM board_recommend WHERE board_id=".$row[0];

			$recommend_res = mysqli_query($conn, $sql);
			$recommend_num=0;
			if($recommend_res) {
				$row2 = mysqli_fetch_array($recommend_res);
				$recommend_num=$row2[0];
			} else echo "RECOMMEND TABLE ERROR";

			array_push($result,
				array("id"=>$row[0],
				"title"=>$row[1],
				"description"=>$row[2],
				"number"=>$row[3],
				"major"=>$row[4],
				"date"=>$row[5],
				"nickname"=>$row[6],
				"images"=>$result2,
				"recommend_num"=>$recommend_num));
		}
		echo json_encode($result, JSON_UNESCAPED_UNICODE);
	} else {
		echo "ERROR";
	}
