<?php
	require("../config/config.php");
	require("../lib/db.php");
	$conn = db_init($config["host"], $config["duser"], $config["dpw"], $config["dname"]);

	mysqli_set_charset($conn, "utf-8");

	$board_title_id = $_POST["board_title_id"];
	$user_id = $_POST["user_id"];
	$title = $_POST["title"];
	$description = $_POST["description"];
	$image_path = $_POST["image_path"];
	$date = $_POST["date"];
	
	$sql = "INSERT INTO `board` (`title`, `description`, `user_id`, `date`, `board_title_id`) VALUES ('".$title."', '".$description."', '".$user_id."', '".$date."', ".$board_title_id.")";

	$result = mysqli_query($conn, $sql);
	$board_id = mysqli_insert_id($conn);
	
	if($result) {
		foreach($image_path as $item) {
			$sql = "INSERT INTO `board_images` (`board_id`, `path`) VALUES ( ".$board_id.", '".$item."')";
			$result = mysqli_query($conn, $sql);
		}
		if($result) {
			echo "success"; 
		}
		else echo "image post failed";
	} else echo "write post failed";

	mysqli_close($conn);

?>
