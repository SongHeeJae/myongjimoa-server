
<?php
	require("../config/config.php");
	require("../lib/db.php");
	$conn = db_init($config["host"], $config["duser"], $config["dpw"], $config["dname"]);

	mysqli_set_charset($conn, "utf-8");

	$board_id = $_POST["board_id"];
	$title = $_POST["title"];
	$description = $_POST["description"];
	$image_path = $_POST["image_path"];
	$delete_images = $_POST["delete_images"];

	$sql = "UPDATE `board` SET `title`='".$title."', `description`='".$description."' WHERE id=".$board_id;
	mysqli_query($conn, $sql);

	foreach($delete_images as $item) {
		$sql = "DELETE FROM `board_images` WHERE `path` LIKE '".$item."'";
		mysqli_query($conn, $sql);
	}

	foreach($image_path as $item) {
		$sql = "INSERT INTO `board_images` (`board_id`, `path`) VALUES ( ".$board_id.", '".$item."')";
		mysqli_query($conn, $sql);
	}

	$post = array();
	$sql = "SELECT `board`.`id`, `board`.`title`, `board`.`description`, `user`.`number`, `user`.`major`, `board`.`date`, `user`.`nickname` FROM `board` LEFT JOIN `user` ON `board`.`user_id`=`user`.`id` WHERE `board`.`id`=".$board_id;
	$res = mysqli_query($conn, $sql);
	$row = mysqli_fetch_array($res);

	$post["id"]=$row[0];
	$post["title"]=$row[1];
	$post["description"]=$row[2];
	$post["number"]=$row[3];
	$post["major"]=$row[4];
	$post["date"]=$row[5];
	$post["nickname"]=$row[6];

	$path_res=array();
	$sql = "SELECT `path` FROM `board_images` WHERE `board_id`=".$post["id"];
	$res = mysqli_query($conn, $sql);
	if($res) {
		while($row = mysqli_fetch_array($res)) {
			array_push($path_res, $row[0]);
		}
	}

	$post["images"]=$path_res;

	$sql = "SELECT count(*) FROM board_recommend WHERE board_id=".$post["id"];
	$res = mysqli_query($conn, $sql);
	$recommend_num=0;
	if($res) {
		$row = mysqli_fetch_array($res);
		$recommend_num=$row[0];
	}

	$post["recommend_num"]=$recommend_num;

	echo json_encode($post, JSON_UNESCAPED_UNICODE);
	
	mysqli_close($conn);
?>
