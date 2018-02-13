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
        <link rel="stylesheet" href="../style/css/Profil.css">
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
            <?php
            $user_page = $dbh->prepare("SELECT * FROM `user` WHERE `id` = :id");
                    $user_page->execute(array('id'=>$_SESSION['id_page'] ));
                    $user_page = $user_page->fetchAll();
                    foreach($user_page as $user_info){
                        $nom = $user_info['nom'];
                        $img_profil = $user_info['img_profil'];
                        $pseudo = $user_info['pseudo'];
                        $img_cou =  $user_info['img_couverture'];          
                    }?>
            <div id="banniere_profil">
            <img id="profil_banniere" src=<?php echo $user_info['img_couverture']; ?> alt="img_couverture">
            <div id="stat_user">
             <ul id="stats">
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
                    
                    echo '<li><ul><li><strong style="color:black;">'.$nom.'</strong></li><li style="font-size: x-small;">@'.$pseudo.'</li></ul></li>
                    <li><a href="../controlleur/tweet.controleur.php?id='.$_SESSION['id_page'].'"><ul><li style="color:black;">Tweets</li><li style="color:black;">'.$nb_tweet.'</li></ul></a></li>
                    <li><a href="../controlleur/abonnement.controleur.php?id='.$_SESSION['id_page'].'"><ul><li style="color:black;">Abonnemnts</li><li style="color:black;">'.$nb_followers.'</li></ul></a></li>
                    <li><a href="../controlleur/abonnee.controleur.php?id='.$_SESSION['id_page'].'"><ul><li style="color:black;">Abonnés</li><li style="color:black;">'.$nb_followings.'</li></ul></a></li>
                    <li>';
                    if($_SESSION['id_page'] != $_SESSION['id']){
                        $forunf = $dbh->prepare("SELECT * FROM `follow` WHERE `id_following` = :id AND `id_followers` = :id_user");
                        $forunf->execute(array('id'=>$_SESSION['id_page'],
                                                'id_user'=>$_SESSION['id'] ));
                        $forunf = $forunf->fetchAll();
                        foreach($forunf as $val){
                            $fok = $val[0];
                        }
                        if(empty($fok)){
                    ?>
                            <li><button id="follow" onclick="follow()">Follow</button></li>
                    <?php
                        }
                        else{
                        ?>
                            <li><button id="unfollow" onclick="unfollow()">Unfollow</button></li>
                        <?php
                        }
                    }
                    else{
                        echo '<li><a href="../controlleur/change_account.controleur.php?id='.$_SESSION['id_page'].'"><button id="edit_profil">Editer Profile</button></a></li>';
                    }
                    ?>
                    </li>
                </ul>
            </div>
          </div>
          <div id="image_profil">
            <img id="profil_image" src=<?php echo $img_profil; ?> alt="img_profil">
          </div>
            <div class="main2">
             <div id="stat">
             <ul>
                <li>Tweet</li>
                <li>Tweet/Reponse</li>
             </div>
                <div class="tweetimg">
                <?php

            $all_tweets = $dbh->prepare("SELECT * FROM `tweet` INNER JOIN `user` ON `tweet`.`id_user` = `user`.`id` WHERE
                `id_user` = :id ORDER BY `date_tweet` DESC");
            $all_tweets->execute(array('id'=>$_SESSION['id_page'] ));
            $all_tweets = $all_tweets->fetchAll();
            $i = 0;
            foreach($all_tweets as $all_tweet){
                $htag = "#";
                $aro = "@";
                $arr = explode(" ", htmlspecialchars($all_tweet["tweet"]));
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
                if(empty($all_tweet["img_profil"])){
                    $all_tweet["img_profil"] = "https://img.generation-nt.com/twitter-oeuf_012C00C801646334.jpg";
                }
                $ul = '<ul style="margin-top: 50px;" class="timeline">';
                if($i > 0){
                    $ul = '<ul class="timeline">';
                }
                echo $ul.'
                <li>
                <div class="avatar">
                    <img src="'.htmlspecialchars($all_tweet["img_profil"]).'" alt="img_profil">
                </div>
                <div class="bubble-container">
                    <div class="bubble">
                        <div class="retweet">
                        </div>
                        <h3 class="h3twet">'.htmlspecialchars($all_tweet["nom"]).'</h3><p class="datetw">'.htmlspecialchars($all_tweet["date_tweet"]).'</p><br/><p style="word-wrap: break-word;">
                        '.$twee.'</p>
                </div>
                </div>
                </li>
                </ul>';
                $i++;
                //return;
            }
        ?>
                </div>
            </div>
      </div> 
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script type="text/javascript" src="../style/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="../style/js/script3.js"></script> 
</body>
</html>
