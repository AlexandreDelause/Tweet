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
          <?php

            $following = $dbh->prepare("SELECT * FROM `follow` WHERE `id_following` = :id");
                $following->execute(array('id'=>$_SESSION['id_page'] ));
                $following = $following->fetchAll();
                foreach($following as $followin){
                    $affichfollo = $followin['id_followers'];
                    $following = $dbh->prepare("SELECT * FROM `user` WHERE `id` = :id");
                    $following->execute(array('id'=>  $affichfollo));
                    foreach($following as $fol){
                if(empty($fol["img_profil"])){
                    $fol["img_profil"] = "https://img.generation-nt.com/twitter-oeuf_012C00C801646334.jpg";
                }
                echo '<ul class="timeline">
                <li>
                <div class="avatar">
                    <a href="Profil.controleur.php?id='.$fol["id_user"].'"><img src="'.htmlspecialchars($fol["img_profil"]).'"></a>
                </div>
                <div class="bubble-container">
                    <div class="bubble">
                        <div class="retweet">
                        </div>
                        <h3 id="h3twet">'.htmlspecialchars($fol["nom"]).'</h3><p id="datetw">'.htmlspecialchars($fol["date_ins"]).'</p><br/>                 
                       
                </div>
                </div>
                </li>
                </ul>';
                $i++;
                //return;
            }
                }
            $i = 0;
        ?>
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
                echo '<div class="tp"><a href="../controlleur/tweet.controleur.php?id='.$_SESSION['id_page'].'"><h1>Tweets</h1>
                <p>'.$nb_tweet.'</p></a></div>
                <div class="tp">
                <a href="../controlleur/abonnement.controleur.php?id='.$_SESSION['id_page'].'"><h1>Abonnements</h1>
                <p style="margin-left: 50px;">'.$nb_followers.'</p></a>
                </div>
                <div class="tp">
                <a href="../controlleur/abonnee.controleur.php?id='.$_SESSION['id_page'].'"><h1>Abonnés</h1>
                <p>'.$nb_followings.'</p></a>
                </div>';
                ?>
            </div>
            </div>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script type="text/javascript" src="../style/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="../style/js/script2.js"></script>
</body>
</html>
