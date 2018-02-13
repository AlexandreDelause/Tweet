<?php
session_start();
include_once('../database.php');
if($_POST['function'] == "new_message"){
	if(!empty($_POST['tweetc'])){
		$new_message = $dbh->prepare("INSERT INTO `messages`(`id_to`, `id_by`, `message`, `lu`, `date_env`) VALUES( ".$_SESSION['id_by'].", ".$_SESSION['id'].", '".htmlspecialchars($_POST['tweetc'])."', 0, NOW())");
        $new_message->execute(array());
  	header('location:messagerie.controleur.php?id_by='.$_SESSION['id_by']);
	}
}
elseif($_POST['function'] = "nou_message"){
	if(!empty($_POST['user_na'])){
		$_POST['user_na'] = substr($_POST['user_na'], 1, strlen($_POST['user_na']));
		$new_message = $dbh->prepare("SELECT * FROM `user` WHERE `pseudo` = :pseudo");
	    $new_message->execute(array('pseudo'=>$_POST["user_na"]));
	    $new_message = $new_message->fetchAll();
	    foreach ($new_message as $value) {
	    	$id_to = $value['id'];
	    }
	    if(!empty($id_to)){
			if(!empty($_POST['tweetc'])){
				$env_message = $dbh->prepare("INSERT INTO `messages`(`id_to`, `id_by`, `message`, `lu`, `date_env`) VALUES( ".$id_to.", ".$_SESSION['id'].", '".htmlspecialchars($_POST['tweetc'])."', 0, NOW())");
		        $env_message->execute(array());
		        echo "ok";
			}
			else{
				echo "false_mess";
			}
		}
		else{
			echo "false_name";
		}
	}
	else{
		echo "no_name";
	}
}
elseif($_GET['function'] == "all_vu"){
	echo "okokokokokko";
}
?>