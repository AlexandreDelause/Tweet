<?php

		$i = 0;
		$ok = true;
		include_once('../database.php');
		session_start();
		$infos_user = $dbh->prepare("SELECT * FROM `user` WHERE `id` = :id");
		$infos_user->execute(array('id'=>$_SESSION['id'] ));
		$infos_user = $infos_user->fetchAll();
		foreach ($infos_user as $info_user) {
			$img_p = $info_user['img_profil'];
			$img_c = $info_user['img_couverture'];
			$nom = $info_user['nom'];
			$mail = $info_user['mail'];
			$mdp = $info_user['password'];
		}
		$new_nom = $_POST['new_name'];
		$older_email = $_POST['older_email'];
		$new_mail = $_POST['new_email'];
		$older_mdp = $_POST['older_mdp'];
		$new_mdp = $_POST['new_mdp'];
		$cnew_mdp = $_POST['cnew_mdp'];

/*****************************************IMAGE PROFIL ************************************************************/

 		if(!empty($_FILES["img_p"]["name"])){
 			$validextensions = array("jpeg", "jpg", "png");
 			$temporary = explode(".", $_FILES["img_p"]["name"]);
 			$file_extension = end($temporary);
 			if ((($_FILES["img_p"]["type"] == "image/png") || ($_FILES["img_p"]["type"] == "image/jpg") || ($_FILES["img_p"]["type"] == "image/jpeg")) && ($_FILES["img_p"]["size"] < 10000000) && in_array($file_extension, $validextensions)) {
 				if ($_FILES["img_p"]["error"] > 0){
 					$ok = false;
 				}
 				else{
					$name_base = pathinfo($_FILES['img_p']['name'], PATHINFO_BASENAME);
			 		$name_temp = (int) microtime($name_base);
 					$imgName = $name_temp.".".$file_extension;
 					if (file_exists("ftp://wac:T5K299PP@185.41.154.194/".$imgName)) {
						echo "img_exist*/";
 						$ok = false;
 					}
 					else{
 						$sourcePath = $_FILES['img_p']['tmp_name'];
 						$targetPath = "ftp://wac:T5K299PP@185.41.154.194/".$imgName;
 						move_uploaded_file($sourcePath,$targetPath);
 						$new_img_p = "http://185.41.154.194/img/".$imgName;
 					}
 				}
 			}
 			else{
 				echo "false_size*/";
 				$ok = false;
 			}
 		}
 		else{
 			$new_img_p = $img_p;
 			$i++;
 		}

/************************************************IMAGE BANIERE*************************************************/

 		if(!empty($_FILES["img_c"]["name"])){
 			$validextensions = array("jpeg", "jpg", "png");
 			$temporary = explode(".", $_FILES["img_c"]["name"]);
 			$file_extension = end($temporary);
 			if ((($_FILES["img_c"]["type"] == "image/png") || ($_FILES["img_c"]["type"] == "image/jpg") || ($_FILES["img_c"]["type"] == "image/jpeg")) && ($_FILES["img_c"]["size"] < 10000000) && in_array($file_extension, $validextensions)) {
 				if ($_FILES["img_c"]["error"] > 0){
 					$ok = false;
 				}
 				else{
 					$name_base = pathinfo($_FILES["img_c"]['name'], PATHINFO_BASENAME);
				 	$name_temp = (int) microtime($name_base)+1;
 					$imgName = $name_temp.".".$file_extension;
 					if (file_exists("ftp://wac:T5K299PP@185.41.154.194/".$imgName)) {
 						echo "img_exist2*/";
 						$ok = false;
 					}
 					else{
 						$sourcePath = $_FILES["img_c"]['tmp_name'];
 						$targetPath2 = "ftp://wac:T5K299PP@185.41.154.194/".$imgName;
 						move_uploaded_file($sourcePath,$targetPath2);
 						$new_img_c = "http://185.41.154.194/img/".$imgName;
 					}
 				}
 			}
 			else{
 				echo "false_size2*/";
 				$ok = false;
 			}
 		}
 		else{
 			$new_img_c = $img_c;
 			$i++;
 		}

/***************************************************NOM*******************************************************/

		if(empty($new_nom)){
			$new_nom = $nom;
			$i++;
		}
		else{
			if(strlen($new_nom) > 1){
				echo "true_name*/";
			}
			else{
				echo "false_name*/";
				$ok = false;
			}
		}

/************************************************EMAIL***********************************************************/

		if($older_email == NULL){
			$new_mail = $mail;
			$i++;
		}
		else{
			$patternmail = "#^(|(([A-Za-z0-9]+_+)|([A-Za-z0-9]+\-+)|([A-Za-z0-9]+\.+)|([A-Za-z0-9]+\++))*[A-Za-z0-9]+@((\w+\-+)|(\w+\.))*\w{1,63}\.[a-zA-Z]{2,6})$#";
			if(preg_match($patternmail, $older_email)){
				$change_mail = $dbh->prepare("SELECT * FROM `user` WHERE `mail` = :mail AND `id` = :id");
				$change_mail->execute(array('mail'=>$older_email,
											'id'=>$_SESSION['id'] ));
				$change_mail = $change_mail->fetchAll();
				if(count($change_mail) > 0){
					echo "true_mail*/";
				}
				else{
					echo "false_mail*/";
					$ok = false;
				}				
			}
			else{
				echo "false_mail*/";
				$ok = false;
			}
			if(!preg_match($patternmail, $new_mail)){
				$ok = false;
				echo "false_new_umail*/";
			}
			else{
				$change_new_mail = $dbh->prepare("SELECT * FROM `user` WHERE `mail` = :mail");
				$change_new_mail->execute(array('mail'=>$new_mail ));
				$change_new_mail = $change_new_mail->fetchAll();
				if(count($change_new_mail) > 0){
					echo "false_new_mail*/";
					$ok = false;
				}
				else{
					echo "true_new_mail*/";
				}
			}
		}

/************************************************MOT DE PASSE********************************************/

		if($older_mdp == NULL){
			$new_mdp = $mdp;
			$i++;
		}
		else{
			$key = "si tu aimes la wac tape dans tes mains";
        	$older_mdp = hash_hmac("ripemd160", $older_mdp, $key);
			$change_mdp = $dbh->prepare("SELECT * FROM `user` WHERE `password` = :oldermdp AND `id` = :id");
			$change_mdp->execute(array('oldermdp'=>$older_mdp,
									   'id'=>$_SESSION['id'] ));
			$change_mdp = $change_mdp->fetchAll();
			if(count($change_mdp) > 0){
				echo 'true_mdp*/';
				if(strlen($new_mdp) < 9){
					$ok = false;
					echo "long_mdp*/";
				}
				else{
					if($new_mdp == $cnew_mdp){
						$key = "si tu aimes la wac tape dans tes mains";
	        			$new_mdp = hash_hmac("ripemd160", $new_mdp, $key);
	        			echo 'true_new_mdp*/';
	        		}
	        		else{
	        			$ok = false;
						echo "equal_mdp*/";
	        		}
				}
			}
			else{
				echo "false_mdp*/";
				$ok = false;
			}
		}

/****************************************************UPDATE*******************************************/

 		if($i < 5 && $ok == true){
 			$verifco = $dbh->prepare("UPDATE `user` SET `mail` = :new_mail, `password` = :new_mdp, `img_profil` = :img, `img_couverture` = :img_c, `pseudo` = :nom WHERE `id` = :id");
 			$verifco->execute(array('new_mail'=>$new_mail,
 									'new_mdp'=>$new_mdp,
 									'img'=>$new_img_p,
 									'img_c'=>$new_img_c,
 									'nom'=>$new_nom,
 									'id'=>$_SESSION['id'] ));
 			echo "change_ok*/";
 		}

?>