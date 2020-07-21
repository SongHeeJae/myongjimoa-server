<?php
	require("../config/config.php");
	require("../lib/db.php");
	$conn = db_init($config["host"], $config["duser"], $config["dpw"], $config["dname"]);

	mysqli_set_charset($conn, "utf-8");

	$email_id = $_POST["email_id"];
	$password = $_POST["password"];
	$password_hash = base64_encode(strtoupper(hash("sha256", $password, true)));
	$sql = "SELECT * FROM `user` WHERE `email_id` = '$email_id' AND `password` = '$password_hash'";

	$res = mysqli_query($conn, $sql);

	$result = array();

	if($res) {
		$row = mysqli_fetch_array($res);
		$result["id"]=$row[0];
		$result["email_id"]=$row[1];
		$result["nickname"]=$row[3];
		$result["major"]=$row[4];
		$result["number"]=$row[5];
		$result["name"]=$row[6];
		$result["date"]=$row[7];
		$result["admin"]=$row[8];
	
		echo json_encode($result, JSON_UNESCAPED_UNICODE);
	}
	
	mysqli_close($conn);

?>
