<?php
	require("../config/config.php");
	require("../lib/db.php");
	$conn = db_init($config["host"], $config["duser"], $config["dpw"], $config["dname"]);

	mysqli_set_charset($conn, "utf-8");
	$board_id = $_POST["board_id"];

	$sql = "SELECT id FROM `board` WHERE id=".$board_id;
	$res = mysqli_query($conn, $sql);
	if(mysqli_num_rows($res) == 0) {
		mysqli_close($conn);
		exit;
	}	

	$sql = "SELECT `board_comments`.`id`, `user`.`number`, `user`.`major`, `board_comments`.`comment`, `board_comments`.`date`, `user`.`nickname` FROM `board_comments` LEFT JOIN `user` ON `board_comments`.`user_id`=`user`.`id` WHERE `board_id`=".$board_id;
	$res = mysqli_query($conn, $sql);

	$result = array();
	if($res) {
		while($row = mysqli_fetch_array($res)) {
			array_push($result,
				array("id"=>$row[0],
				"number"=>$row[1],
				"major"=>$row[2],
				"comment"=>$row[3],
				"date"=>$row[4],
				"nickname"=>$row[5]));
		}
		echo json_encode($result, JSON_UNESCAPED_UNICODE);
	} else {
		echo mysqli_error($conn);
	}
	mysqli_close($conn);

?>
