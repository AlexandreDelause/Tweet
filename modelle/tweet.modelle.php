<?php
	include_once("../database.php");
	session_start();
	if($_POST['function'] == "follow"){
		echo "ok";
		$follow_user = $dbh->prepare("INSERT INTO `follow`(`id_followers`, `id_following`, `date_follow`) VALUES (:id, :id_page, NOW())");
        $follow_user->execute(array('id_page'=>$_SESSION['id_page'],
                                   'id'=>$_SESSION['id'] ));
	}
	elseif($_POST['function'] == "unfollow"){
		echo "ok";
		$forunf = $dbh->prepare("DELETE FROM `follow` WHERE `id_followers` = :id AND `id_following` = :id_page");
            $forunf->execute(array('id_page'=>$_SESSION['id_page'],
                                   'id'=>$_SESSION['id'] ));
	}
?>