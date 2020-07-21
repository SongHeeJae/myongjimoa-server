<?php
	require("../config/config.php");
	require("../lib/db.php");
	$conn = db_init($config["host"], $config["duser"], $config["dpw"], $config["dname"]);

	mysqli_set_charset($conn, "utf-8");

	$board_id = $_POST["board_id"];

	$sql = "SELECT `id` FROM `board_comments` WHERE board_id=".$board_id;
	$res = mysqli_query($conn, $sql);
	if($res) {
		while($row=mysqli_fetch_array($res)) {
			$sql="DELETE FROM comment_report WHERE comment_id=".$row[0];
			mysqli_query($conn, $sql);
		}
	}
	
	$sql = "DELETE FROM `board` WHERE id=".$board_id;
	mysqli_query($conn, $sql);

	$sql = "DELETE FROM `board_recommend` WHERE board_id=".$board_id;
	mysqli_query($conn, $sql);

	$sql = "DELETE FROM `board_comments` WHERE board_id=".$board_id;
	mysqli_query($conn, $sql);

	$sql = "DELETE FROM `board_images` WHERE board_id=".$board_id;
	mysqli_query($conn, $sql);
	
	$sql = "DELETE FROM `board_report` WHERE board_id=".$board_id;
	mysqli_query($conn, $sql);

	echo "success";

	mysqli_close($conn);
?>
