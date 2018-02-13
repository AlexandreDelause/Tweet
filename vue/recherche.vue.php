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
            <div class="tweetimg">
            </div>
            <div> 
          <?php
            $htag = "#";
            $aro = "@";
            if($_GET["type"] == "aro"){
                $sai = "@".$_GET["rec"];  
            }
            elseif($_GET["type"] == "htag"){
                $sai = "#".$_GET["rec"];
            }
            else{
                $sai = $_POST['saisie'];
            }
            if(substr($sai, 0, 1) === $aro) {
                $sai = substr($sai, 1, strlen($sai));
                $recherche_users = $dbh->prepare("SELECT * FROM `user` WHERE `pseudo` = :pseudo");
                $recherche_users->execute(array('pseudo'=>$sai ));
                $recherche_users = $recherche_users->fetchAll();
                foreach($recherche_users as $recherche_user){
                    echo '<ul>
                    <li>
                    <div class="avatar">
                        <a href="Profil.controleur.php?id='.$recherche_user["id"].'">
                            <img src="'.$recherche_user['img_profil'].'" alt="img_profil">
                        </a>
                    </div>
                    <div class="bubble-container">
                        <div class="bubble">
                            <div class="retweet">
                            </div>
                            <h3 id="h3twet">@'.$recherche_user["nom"].'</h3>
                            <p id="datetw"></p><br/>
                            <p></p>                  
                    </div>';
                }    
            }
            elseif(substr($sai, 0, 1) === $htag) {
                $sai = substr($sai, 1, strlen($sai));
                $recherche_hashs = $dbh->prepare("SELECT * FROM `hashtag` INNER JOIN `tweet` ON `tweet`.`id_tweet` = `hashtag`.`id_tweet` WHERE `name_hashtag` = :nom");
                $recherche_hashs->execute(array('nom'=>$sai ));
                $recherche_hashs = $recherche_hashs->fetchAll();
                foreach($recherche_hashs as $recherche_hash){
                    $info_us = $dbh->prepare("SELECT * FROM `user` WHERE `id` = :id");
                    $info_us->execute(array('id'=>$recherche_hash['id_user'] ));
                    $info_us = $info_us->fetchAll();
                    foreach($info_us as $info_u){
                        $htag = "#";
                        $aro = "@";
                        $arr = explode(" ", htmlspecialchars($recherche_hash["tweet"]));
                        $arrc = count($arr);
                        $y = 0;
                        while($y < $arrc) {
                            if(substr($arr[$y], 0, 1) === $htag) {
                                $arr[$y] = '<a href="#" class="lien">'.$arr[$y].'</a>';
                            }
                            elseif(substr($arr[$y], 0, 1) === $aro) {
                                $arr[$y] = '<a href="#" class="lien">'.$arr[$y].'</a>';
                            }
                            $y++;
                        }
                        $twee = implode(" ", $arr);
                        if(empty($info_u["img_profil"])){
                            $info_u["img_profil"] = "https://img.generation-nt.com/twitter-oeuf_012C00C801646334.jpg";
                        }
                        echo '<ul class="timeline">
                        <li>
                        <div class="avatar">
                            <a href="Profil.controleur.php?id='.$info_u["id"].'"><img src="'.htmlspecialchars($info_u["img_profil"]).'"></a>
                        </div>
                        <div class="bubble-container">
                            <div class="bubble">
                                <div class="retweet">
                                </div>
                                <h3 id="h3twet">'.htmlspecialchars($info_u["nom"]).'</h3><p id="datetw">'.htmlspecialchars($recherche_hash["date_tweet"]).'</p><br/><p>
                                '.$twee.'</p>                  


                        </div>
                            <div class="trli" style="display: flex;">
                            <div class="rtli" style="margin-right: 50%;margin-left: 10%;">
                            <div class="icon-retweet action" style="margin-left: 70%;">'.$nb_retweet.'</div>
                            </div>
                            <div class="rtli">
                            <div class="icon-star action">'.$nb_tweet_like.'</div>
                            </div>
                            </div>
                            </li>
                            </ul>';
                    }
                }
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

                $user_tweet_likes = $dbh->prepare("SELECT COUNT(*) FROM `tweet_like` WHERE `id_tweet_like` = :id");
                $user_tweet_likes->execute(array('id'=>$_SESSION['id_page'] ));
                $user_tweet_likes = $user_tweet_likes->fetchAll();
                foreach($user_tweet_likes as $user_tweet_like){
                    $nb_tweet_like = $user_tweet_like[0];
                }
 
                $user_sretweet = $dbh->prepare("SELECT COUNT(*) FROM `tweet` WHERE `id_retweet` = :id");
                $user_sretweet->execute(array('id'=>$_SESSION['id_page'] ));
                $user_sretweet = $user_sretweet->fetchAll();
                foreach($user_sretweet as $user_retweet){
                    $nb_retweet = $user_retweet[0];
                }
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
