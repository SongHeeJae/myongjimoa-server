<?php

	require("../config/config.php");
	require("../lib/db.php");
	$conn = db_init($config["host"], $config["duser"], $config["dpw"], $config["dname"]);

	mysqli_set_charset($conn, "utf-8");

	$board_id = $_POST["board_id"];
	$user_id = $_POST["user_id"];
	$comment = $_POST["comment"];
	$date = $_POST["date"];

	$sql = "SELECT `id` FROM `board` WHERE id=".$board_id;
	$res = mysqli_query($conn, $sql);
	if(mysqli_num_rows($res) == 0) {
		mysqli_close($conn);
		exit;
	}

	$sql = "INSERT INTO `board_comments` (`board_id`, `user_id`, `comment`, `date`) VALUES ('".$board_id."', '".$user_id."', '".$comment."', '".$date."')";
	$result = mysqli_query($conn, $sql);
	if($result) echo "success";
	mysqli_close($conn);
?>
