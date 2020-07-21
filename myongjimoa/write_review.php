<?php
	require("../config/config.php");
	require("../lib/db.php");
	$conn = db_init($config["host"], $config["duser"], $config["dpw"], $config["dname"]);

	mysqli_set_charset($conn, "utf-8");

	$restaurant_id = $_POST["restaurant_id"];
	$description = $_POST["description"];
	$user_id = $_POST["user_id"];
	$score = $_POST["score"];
	$image_path = $_POST["image_path"];
	$date = $_POST["date"];
	
	$sql = "INSERT INTO `review` (`restaurant_id`, `description`, `user_id`, `score`, `date`) VALUES (".$restaurant_id.", '".$description."', ".$user_id.", ".$score.", '".$date."')";

	$result = mysqli_query($conn, $sql);
	
	$review_id = mysqli_insert_id($conn);

	if($result) {
		foreach($image_path as $item) {
			$sql = "INSERT INTO `review_images` (`review_id`, `path`) VALUES ( ".$review_id.", '".$item."')";
			$result = mysqli_query($conn, $sql);
		}
		if($result) {
			$sql = "SELECT AVG(score) from review where restaurant_id=".$restaurant_id;
			$result = mysqli_query($conn, $sql);
			$row = mysqli_fetch_array($result);
			
			$sql = "UPDATE restaurant SET score=".$row[0].", review_num=review_num+1 WHERE id=".$restaurant_id;

			mysqli_query($conn, $sql);

			echo "success";
		}
		else echo "image review failed";
	} else echo "write review failed";

	mysqli_close($conn);
?>
