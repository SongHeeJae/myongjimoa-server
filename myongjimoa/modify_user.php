<?php
	require("../config/config.php");
	require("../lib/db.php");
	$conn = db_init($config["host"], $config["duser"], $config["dpw"], $config["dname"]);

	mysqli_set_charset($conn, "utf-8");

	$user_id = $_POST["user_id"];
	$user_nickname = $_POST["user_nickname"];
	$user_major = $_POST["user_major"];

	$sql = "SELECT `id` FROM `user` WHERE nickname='".$user_nickname."'";
	$res = mysqli_query($conn, $sql);

	if(mysqli_num_rows($res) != 0) {
		echo "nickname";
		mysqli_close($conn);
		exit;
	}

	$sql = "UPDATE `user` SET nickname='".$user_nickname."', major='".$user_major."' WHERE id=".$user_id;

	$res = mysqli_query($conn, $sql);

	if($res) echo "success";

	mysqli_close($conn);
?>
