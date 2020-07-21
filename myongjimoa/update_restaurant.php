<?php
실행금지
exit(0);
	require("../config/config.php");
	require("../lib/db.php");
	$conn = db_init($config["host"], $config["duser"], $config["dpw"], $config["dname"]);

	mysqli_set_charset($conn, "utf-8");

	$data = json_decode(file_get_contents('../lib/restaurant_list.json'), true);
	$count=0;
	foreach($data as $d) {
		$sql = 'INSERT INTO restaurant (title, category, telephone, homepage, address, mapx, mapy, restaurant_id, time, menu, image, review_num, score) VALUES ("'.$d["title"].'", "'.$d["category"].'", "'.$d["telephone"].'", "'.$d["link"].'", "'.$d["address"].'", "'.$d["mapx"].'", "'.$d["mapy"].'", "'.$d["restaurant_id"].'", "'.$d["time"].'", "'.$d["menu"].'", "'.$d["image"].'", 0, 0)';
		$res = mysqli_query($conn, $sql);
		if($res) { }
		else {
			echo "error : ".$d["menu"]." - ".mysqli_error($conn)."<br/>";
		}
		$count++;
	}
	echo $count;
	
	mysqli_close($conn);

?>

