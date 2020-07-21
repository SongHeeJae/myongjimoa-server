
<?php
	require("../config/config.php");
	require("../lib/db.php");
	$conn = db_init($config["host"], $config["duser"], $config["dpw"], $config["dname"]);

	mysqli_set_charset($conn, "utf-8");

	$sql = "SELECT * FROM `board_title`";

	$res = mysqli_query($conn, $sql);
	$result = array();

	if($res) {
		while($row = mysqli_fetch_array($res)) {
			array_push($result,
				array("id"=>$row[0],
				"title"=>$row[1]));
		}
		echo json_encode($result, JSON_UNESCAPED_UNICODE);
	} else {
		
	}
	mysqli_close($conn);
?>
