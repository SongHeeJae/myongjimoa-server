<?php
	require("../config/config.php");
	require("../lib/db.php");
	$conn = db_init($config["host"], $config["duser"], $config["dpw"], $config["dname"]);

	mysqli_set_charset($conn, "utf-8");

	$board_id = $_POST["board_id"];
	$user_id = $_POST["user_id"];

	$sql = "SELECT `id` FROM board WHERE id=".$board_id;
	$res = mysqli_query($conn, $sql);
	if(mysqli_num_rows($res) == 0) {
		echo "removed";
		mysqli_close($conn);
		exit;
	}

	$sql = "SELECT * FROM board_recommend WHERE board_id=".$board_id." AND user_id=".$user_id;
	$result = mysqli_query($conn, $sql);

	if(mysqli_num_rows($result) == 0) {
		// 추천테이블이 비었으면 insert 가능
		$sql = "INSERT INTO `board_recommend` (`board_id`, `user_id`) VALUES (".$board_id.", ".$user_id.")";
		$result = mysqli_query($conn, $sql);

		$sql = "SELECT count(*) FROM board_recommend WHERE `board_id`=".$board_id;
		$result = mysqli_query($conn, $sql);
		$res = mysqli_fetch_array($result);
		echo $res[0];
	} else {
		echo "failed";
	}

	mysqli_close($conn);

?>
