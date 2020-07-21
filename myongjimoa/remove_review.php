<?php
	require("../config/config.php");
	require("../lib/db.php");
	$conn = db_init($config["host"], $config["duser"], $config["dpw"], $config["dname"]);

	mysqli_set_charset($conn, "utf-8");

	$review_id = $_POST["review_id"];
	$restaurant_id = $_POST["restaurant_id"];

	$sql = "DELETE FROM `review` WHERE id=".$review_id;
	mysqli_query($conn, $sql);

	$sql = "SELECT AVG(score) FROM `review` WHERE `restaurant_id`=".$restaurant_id;
	mysqli_query($conn, $sql);
	$res = mysqli_query($conn, $sql);
	$row = mysqli_fetch_array($res);
	$new_score = 0;
	if($row[0] != NULL) $new_score = $row[0];

	$sql = "UPDATE `restaurant` SET score=".$new_score.", review_num=review_num-1 WHERE id=".$restaurant_id;
	mysqli_query($conn, $sql);

	$sql = "DELETE FROM `review_report` WHERE review_id=".$review_id;
	mysqli_query($conn, $sql);

	$sql = "DELETE FROM `review_images` WHERE review_id=".$review_id;
	mysqli_query($conn, $sql);

	echo "success";

	mysqli_close($conn);
?>
