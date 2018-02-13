<?php
session_start();
if (isset($_GET['id'])){
    $_SESSION['id_page'] = $_GET['id'];
}
else if (empty($_SESSION['id_page'])){
    $_SESSION['id_page'] = $_GET['id'];
}
include_once('../database.php');
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Connexion</title>
		<link rel="stylesheet" href="../style/css/bootstrap-responsive.css">
        <link rel="stylesheet" href="../style/css/css.css">
            <link href='https://fonts.googleapis.com/css?family=Quicksand:300,400' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Lato:400,300' rel='stylesheet' type='text/css'>
    <link href="https://netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.0/themes/smoothness/jquery-ui.css" />

</head>
<body>

	
        <div style="margin: 0em auto; width: 1325px;" class="main-container">
            <header class="block">
                <ul class="header-menu horizontal-list">
                    <li>
                        <?php
                        echo '<a class="header-menu-tab" href="../controlleur/compte.controleur.php?id='.$_SESSION['id'].'"><span class="icon entypo-cog scnd-font-color"></span>Accueil</a>'
                        ?>
                    </li>
                    <li>
                        <a class="header-menu-tab" href="#" id="btheme"><span class="icon fontawesome-user scnd-font-color"></span>Thème</a>
                    </li>
                    <li id="okok">
                        <?php
                        $nb_mal = $dbh->prepare("SELECT COUNT(*) FROM `messages` WHERE `id_to` = :id AND `lu` = 0");
                        $nb_mal->execute(array('id'=>$_SESSION['id']));
                        foreach($nb_mal as $unnom){
                            $super = $unnom[0];
                        }
                        ?>
                        <a class="header-menu-tab" href="../controlleur/messagerie.controleur.php"><span class="icon fontawesome-envelope scnd-font-color"></span>Messages</a>
                        <a class="header-menu-number" href="#"><?php echo $super ?></a>
                    </li>
                    <li>
                        <?php
                        echo '<a class="header-menu-tab" href="../controlleur/Profil.controleur.php?id='.$_SESSION['id'].'"><span class="icon fontawesome-star-empty scnd-font-color"></span>Profile</a>';
                        ?>

                    </li>
                </ul>
                 <div class="profile-menu">
                    <span class="entypo-down-open scnd-font-color"></span>
                    <form action="../controlleur/recherche.controleur.php" style="margin-top: 30px;" id="recherche" method="post">
					   <input name="saisie" type="text" placeholder="Mots-Clefs..." required id="rah"/>
					   <input class="loupe" type="submit" value=""/>
                       <input name="function" type="hidden" value="search">
				    </form>       
                </div>
            </header>
            <div class="main">

            <form id="tweetform">
             <button style="margin-left: 494px;
              margin-top: 0px;" id="buttweet" type="submit">Tweeter</button>
            <textarea name="tweetc" id="textareaChars" maxlength="140" style="position: absolute;width: 470px; height: 100px;"></textarea><p id="compteur">140</p>
            <input type="hidden" name="function" value="new_tweet">
            </form>
            <div class="tweetimg">
            </div>
            <div id="all_t"> 
          <?php

            $all_tweets = $dbh->prepare("SELECT * FROM `tweet` INNER JOIN `user` ON `tweet`.`id_user` = `user`.`id` ORDER BY `date_tweet` DESC LIMIT 50");
            $all_tweets->execute(array('id'=>$_GET['id'] ));
            $all_tweets = $all_tweets->fetchAll();
            $i = 0;
            $u = 0;
            foreach($all_tweets as $all_tweet){
                $cont_tweet = htmlspecialchars($all_tweet["tweet"]);
                $img_p = htmlspecialchars($all_tweet["img_profil"]);
                $id_us = htmlspecialchars($all_tweet["id_user"]);
                $nom_us = htmlspecialchars($all_tweet["nom"]);
                $date_tw = htmlspecialchars($all_tweet["date_tweet"]);
                $id_tw = $all_tweet["id_tweet"];
                echo $all_tweet['id_retweet'];
                if($all_tweet['id_retweet'] != NULL){
                    $retweet_tw = $dbh->prepare("SELECT * FROM `tweet` INNER JOIN `user` ON `tweet`.`id_user` = `user`.`id` WHERE `id_tweet` = :id_retweet");
                    $retweet_tw->execute(array('id_retweet'=>$all_tweet['id_retweet'] ));
                    $retweet_tw = $retweet_tw->fetchAll();
                    foreach($retweet_tw as $retweet_t){
                        $nom_us_retweet = htmlspecialchars($all_tweet['nom']);
                        $cont_tweet = htmlspecialchars($retweet_t["tweet"]);
                        $img_p = htmlspecialchars($retweet_t["img_profil"]);
                        $id_us = htmlspecialchars($retweet_t["id_user"]);
                        $nom_us = htmlspecialchars($retweet_t["nom"]);
                        $date_tw = htmlspecialchars($retweet_t["date_tweet"]);
                        $id_tw = $retweet_t["id_tweet"]; 
                        $rep_re = '<p class="retweet">'.$nom_us_retweet.' a retweeté</p>';
                    }
                }
                $htag = "#";
                $aro = "@";
                $arr = explode(" ", $cont_tweet);
                $arrc = count($arr);
                $y = 0;
                while($y < $arrc) {
                    if(substr($arr[$y], 0, 1) === $htag) {
                        $sai2 =substr($arr[$y], 1, strlen($arr[$y]));
                        $arr[$y] = '<a href="../controlleur/recherche.controleur.php?id='.$_SESSION["id"].'&rec='.$sai2.'&type=htag" class="lien">'.$arr[$y].'</a>';
                    }
                    elseif(substr($arr[$y], 0, 1) === $aro) {
                        $sai2 =substr($arr[$y], 1, strlen($arr[$y]));
                        $arr[$y] = '<a href="../controlleur/recherche.controleur.php?id='.$_SESSION["id"].'&rec='.$sai2.'&type=aro" class="lien">'.$arr[$y].'</a>';
                    }
                    $y++;
                }
                $twee = implode(" ", $arr);
                if(empty($img_p)){
                    $img_p = "https://img.generation-nt.com/twitter-oeuf_012C00C801646334.jpg";
                }
                $ul = '<ul style="margin-top: 125px;" class="timeline">';
                if($i > 0){
                    $ul = '<ul class="timeline">';
                }
                echo $ul.'
                <li>';
                echo $rep_re.'
                <div class="avatar">
                    <a href="Profil.controleur.php?id='.$id_us.'"><img src="'.$img_p.'" alt="img_profil"></a>
                </div>
                <div class="bubble-container">
                    <div class="bubble">
                        <div class="retweet">
                        </div>
                        <h3 class="h3twet">'.$nom_us.'</h3><p class="datetw">'.$date_tw.'</p><br/><p>
                        '.$twee.'</p>                  


                </div>';
                    $user_tweet_likes = $dbh->prepare("SELECT COUNT(*) FROM `tweet_like` WHERE `id_tweet` = :id");
                    $user_tweet_likes->execute(array('id'=>$id_tw ));
                    $user_tweet_likes = $user_tweet_likes->fetchAll();
                    foreach($user_tweet_likes as $user_tweet_like){
                        $nb_tweet_like = $user_tweet_like[0];
                    }
                    $user_sretweet = $dbh->prepare("SELECT COUNT(*) FROM `tweet` WHERE `id_retweet` = :id");
                    $user_sretweet->execute(array('id'=>$id_tw ));
                    $user_sretweet = $user_sretweet->fetchAll();
                    foreach($user_sretweet as $user_retweet){
                        $nb_retweet = $user_retweet[0];
                    }
                    echo '<div class="trli" style="display: flex;">
                    <div class="rtli" style="margin-right: 50%;margin-left: 10%;">
                    <div class="icon-retweet action" style="margin-left: 70%;" onclick="retweet('.$id_tw.')"></div><p>'.$nb_retweet.'</p>
                    </div>
                    <div class="rtli">
                    <div class="icon-star action" onclick=like('.$id_tw.')></div><p>'.$nb_tweet_like.'</p>
                    </div>
                    </div>
                    <button class="buttcom" type="submit" onclick="new_com('.$id_tw.')">envoyer</button>
                    <textarea name="com" id="text_'.$id_tw.'" class="com" onclick="stop()"></textarea>
                <h1><strong>Réponse</strong></h1>
                </div>';
                $all_rep = $dbh->prepare("SELECT * FROM `commentaire` INNER JOIN `user` ON `commentaire`.`id_user` = `user`.`id` WHERE `id_tweet` = :id_tweet ORDER BY `date_com` DESC");
                $all_rep->execute(array('id_tweet'=>$id_tw ));
                $all_rep = $all_rep->fetchAll();

                foreach($all_rep as $rep){
                    if(!empty($rep)){
                        $htag = "#";
                        $aro = "@";
                        $arr = explode(" ", htmlspecialchars($rep["com"]));
                        $arrc = count($arr);
                        $v = 0;
                        while($v < $arrc) {
                            if(substr($arr[$v], 0, 1) === $htag) {
                                $sai2 =substr($arr[$v], 1, strlen($arr[$v]));
                                $arr[$v] = '<a href="../controlleur/recherche.controleur.php?id='.$_SESSION["id"].'&rec='.$sai2.'&type=htag" class="lien">'.$arr[$v].'</a>';
                            }
                            elseif(substr($arr[$v], 0, 1) === $aro) {
                                $sai2 =substr($arr[$v], 1, strlen($arr[$v]));
                                $arr[$v] = '<a href="../controlleur/recherche.controleur.php?id='.$_SESSION["id"].'&rec='.$sai2.'&type=aro" class="lien">'.$arr[$v].'</a>';
                            }
                            $v++;
                        }
                        $com = implode(" ", $arr);
                        echo '<div style="margin-top: 10px"><div class="avatar">
                            <a href="Profil.controleur.php?id='.$rep["id_user"].'"><img src="'.htmlspecialchars($rep["img_profil"]).'"></a>
                        </div>
                        <div class="bubble-container">
                            <div class="bubble">
                                <div class="retweet">
                                </div>
                                <h3 id="h3twet">'.htmlspecialchars($rep["nom"]).'</h3><p id="datetw">'.htmlspecialchars($rep["date_com"]).'</p><br/><p>
                                    '.$com.'
                                </p>
                                </div></div>'; 
                    } 
                }
                $u++;
                echo '</li>
                </ul>';
                $i++;
            }
        ?>
        </div>
</div>
      </div>      


            <div class="conteneurp">
            <div class="imgprofil">
            <?php
            $user_page = $dbh->prepare("SELECT * FROM `user` WHERE `id` = :id");
            $user_page->execute(array('id'=>$_SESSION['id_page'] ));
            $user_page = $user_page->fetchAll();
            foreach($user_page as $user_info){
                $nom = $user_info['nom'];
                $img_profil = $user_info['img_profil'];
                $pseudo = $user_info['pseudo'];
            }
            ?>
                <img src=<?php echo $img_profil ?> alt="profile-sample6"><p style="position: absolute; margin-top: 50px; margin-left: 120px;"><strong>@<?php echo $pseudo; ?></strong></p><p id="nompseudot"><strong><?php echo $nom; ?></strong></p>

            </div>
            <div id="info_user">
            <?php
                $user_tweets = $dbh->prepare("SELECT COUNT(*) FROM `tweet` WHERE `id_user` = :id");
                $user_tweets->execute(array('id'=>$_SESSION['id_page'] ));
                $user_tweets = $user_tweets->fetchAll();
                foreach($user_tweets as $user_tweet){
                    $nb_tweet = $user_tweet[0];
                }
                $user_abos = $dbh->prepare("SELECT COUNT(*) FROM `follow` WHERE `id_following` = :id");
                $user_abos->execute(array('id'=>$_SESSION['id_page'] ));
                $user_abos = $user_abos->fetchAll();
                foreach($user_abos as $user_abo){
                    $nb_followings = $user_abo[0];
                }   
                $nbs_abo = $dbh->prepare("SELECT COUNT(*) FROM `follow` WHERE `id_followers` = :id");
                $nbs_abo->execute(array('id'=>$_SESSION['id_page'] ));
                $nbs_abo = $nbs_abo->fetchAll();
                foreach($nbs_abo as $nb_abo){
                    $nb_followers = $nb_abo[0];
                }
                echo '<div class="tp">
                <strong><a href="../controlleur/tweet.controleur.php?id='.$_SESSION['id_page'].'">Tweet</a></strong>
                <p>'.$nb_tweet.'</p></div>
                <div class="tp">
                <strong><a href="../controlleur/abonnement.controleur.php?id='.$_SESSION['id_page'].'">Abonnements</a></strong>
                <p style="margin-left: 50px;">'.$nb_followers.'</p>
                </div>
                <div class="tp">
                <strong><a href="../controlleur/abonnee.controleur.php?id='.$_SESSION['id_page'].'">abonnées</a></strong>
                <p>'.$nb_followings.'</p>
                </div>';
                ?>
            </div>
            </div>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script type="text/javascript" src="../style/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="../style/js/script2.js"></script>
</body>
</html>
