<?php
	require("../config/config.php");
	require("../lib/db.php");
	$conn = db_init($config["host"], $config["duser"], $config["dpw"], $config["dname"]);

	mysqli_set_charset($conn, "utf-8");

	$email_id = $_POST["email_id"];
	$password = $_POST["password"];
	$nickname = $_POST["nickname"];
	$major = $_POST["major"];
	$number = $_POST["number"];
	$name = $_POST["name"];
	$date = $_POST["date"];

	$sql = "SELECT `id` FROM `user` WHERE email_id='".$email_id."'";
	$res = mysqli_query($conn, $sql);
	if(mysqli_num_rows($res) != 0) {
		echo "email";
		mysqli_close($conn);
		exit;
	}

	$sql = "SELECT `id` FROM `user` WHERE nickname='".$nickname."'";
	$res = mysqli_query($conn, $sql);

	if(mysqli_num_rows($res) != 0) {
		echo "nickname";
		mysqli_close($conn);
		exit;
	}

	$password_hash = base64_encode(strtoupper(hash("sha256", $password, true)));

	$sql = "INSERT INTO user (email_id, password, nickname, major, number, name, date, admin) VALUES ('".$email_id."', '".$password_hash."', '".$nickname."', '".$major."', '".$number."', '".$name."', '".$date."', 'false')";

	$result = mysqli_query($conn, $sql);

	if($result) echo "success";

	mysqli_close($conn);

?>
