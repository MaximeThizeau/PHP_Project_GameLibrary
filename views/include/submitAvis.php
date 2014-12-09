<?php

include "cnx.php";
include "avis.class.php";

$arr = array();
$validates = Comment::validate($arr);

if($validates)
	{

		$query = $bdd->prepare("INSERT INTO reviews (name,body,game_id) VALUES(:name, :body, 1)");
		$query->bindValue(":name", $arr['name'], PDO::PARAM_STR);
		$query->bindValue(":body", $arr['body'], PDO::PARAM_STR);
		$query->execute();

		$arr['id'] = $bdd->lastInsertId();

		$arr = array_map('stripslashes',$arr);

		$insertedComment = new Comment($arr);

		echo json_encode(array('status'=>1,'html'=>$insertedComment->markup()));

	}
else
	{
		echo '{"status":0,"errors":'.json_encode($arr).'}';
	}

?>
