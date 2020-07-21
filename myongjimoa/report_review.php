<?php
	require("../config/config.php");
	require("../lib/db.php");
	$conn = db_init($config["host"], $config["duser"], $config["dpw"], $config["dname"]);

	mysqli_set_charset($conn, "utf-8");

	$review_id = $_POST["review_id"];
	$user_id = $_POST["user_id"];

	$sql = "SELECT `id` FROM `review` WHERE id=".$review_id;
	$res = mysqli_query($conn, $sql);
	if(mysqli_num_rows($res) == 0) {
		echo "removed";
		mysqli_close($conn);
		exit;
	}

	$sql = "SELECT * FROM review_report WHERE review_id=".$review_id." AND user_id=".$user_id;
	$result = mysqli_query($conn, $sql);

	if(mysqli_num_rows($result) == 0) {
		// 신고테이블에 비었으면 insert 가능
		$sql = "INSERT INTO `review_report` (`review_id`, `user_id`) VALUES (".$review_id.", ".$user_id.")";
		$result = mysqli_query($conn, $sql);

		$sql = "SELECT count(*) FROM review_report WHERE `review_id`=".$review_id;
		$result = mysqli_query($conn, $sql);
		$res = mysqli_fetch_array($result);
		echo $res[0];
	} else {
		echo "failed";
	}

	mysqli_close($conn);

?>
