<?php
	include_once("../database.php");
	session_start();
	if($_GET['function'] == "follow"){
		$follow_user = $dbh->prepare("INSERT INTO `follow`(`id_followers`, `id_following`, `date_follow`) VALUES (:id, :id_page, NOW())");
        $follow_user->execute(array('id_page'=>$_SESSION['id_page'],
                                   'id'=>$_SESSION['id'] ));
        echo "ok";
	}
	elseif($_GET['function'] == "unfollow"){
		$forunf = $dbh->prepare("DELETE FROM `follow` WHERE `id_followers` = :id AND `id_following` = :id_page");
        $forunf->execute(array('id_page'=>$_SESSION['id_page'],
                               'id'=>$_SESSION['id'] ));
        echo "ok";
	}
	if($_POST['function'] == "nomhas"){
        if(!empty($_POST['rhas'])){
            $rec = htmlspecialchars(str_replace("#", "", $_GET['rhas']));
            $rec_hastags = $dbh->prepare("SELECT * FROM `hashtag` WHERE `name_hashtag` LIKE '".$rec."%'");
            $rec_hastags->execute();
            $rec_hastags = $rec_hastags->fetchAll();
            foreach($rec_hastags as $rec_hastag){
                echo "#".$rec_hastag['name_hashtag']."*/";
            }
        }
    }
    if($_GET['function'] == "noma"){
        if(!empty($_GET['ra'])){
            $rec = htmlspecialchars(str_replace("@", "", $_GET['ra']));            
            $rec_hastags = $dbh->prepare("SELECT * FROM `user` WHERE `pseudo` LIKE '".$rec."%'");
            $rec_hastags->execute();
            $rec_hastags = $rec_hastags->fetchAll();
            foreach($rec_hastags as $rec_hastag){
                echo "@".$rec_hastag['pseudo']."*/";
            }
        }
    }
?>