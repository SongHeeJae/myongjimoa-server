<?php
	require("../config/config.php");
	require("../lib/db.php");
	$conn = db_init($config["host"], $config["duser"], $config["dpw"], $config["dname"]);

	mysqli_set_charset($conn, "utf-8");

	$comment_id = $_POST["comment_id"];

	$sql = "DELETE FROM `board_comments` WHERE id=".$comment_id;
	mysqli_query($conn, $sql);

	$sql = "DELETE FROM `comment_report` WHERE comment_id=".$comment_id;
	mysqli_query($conn, $sql);

	echo "success";

	mysqli_close($conn);
?>
