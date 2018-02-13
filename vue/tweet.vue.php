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
            <div class="main2">
             <div id="stat">
             <ul>
                <li>Tweet</li>
             </div>
                <div class="tweetimg">
                <?php

            $all_tweets = $dbh->prepare("SELECT * FROM `tweet` INNER JOIN `user` ON `tweet`.`id_user` = `user`.`id` WHERE
                `id_user` = :id ORDER BY `date_tweet` DESC");
            $all_tweets->execute(array('id'=>$_SESSION['id_page'] ));
            $all_tweets = $all_tweets->fetchAll();
            $i = 0;
            foreach($all_tweets as $all_tweet){
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
                        <h3 class="h3twet">'.htmlspecialchars($all_tweet["nom"]).'</h3><p class="datetw">'.htmlspecialchars($all_tweet["date_tweet"]).'</p><br/>
                        '.htmlspecialchars($all_tweet["tweet"]).'                    
                       <div class="over-bubble">
                        <div class="icon-mail-reply action"></div> 
                        <div class="icon-retweet action"></div>
                        <div class="icon-star"></div>
                    </div>
                </div>
                </div>
                </li>
                </ul>';
                $i++;
                //return;
            }
        ?>
        </div>
        </ul>

            </div>
      </div> 
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script type="text/javascript" src="../style/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="../style/js/script3.js"></script> 
</body>
</html>
