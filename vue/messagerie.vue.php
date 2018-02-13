<?php
session_start();
if (isset($_GET['id_by'])){
    $_SESSION['id_by'] = $_GET['id_by'];
}
else if (empty($_SESSION['id_by'])){
    $_SESSION['id_by'] = $_GET['id_by'];
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
            <?php

            if(!empty($_GET['id_by'])){
                echo '<form id="envoieform" action="messagerie.controleur.php?id_by='.$_GET['id_by'].'" method="POST">
                 <button style="margin-left: 494px;
                  margin-top: 0px;" id="benvoyer" type="submit">Envoyer</button>
                <textarea name="tweetc" id="textareaChars" maxlength="140" style="position: absolute;width: 470px; height: 100px;"></textarea><p id="compteur">140</p>
                <input type="hidden" name="function" value="new_message">
                </form>';
            }
            ?>
            <div class="tweetimg">
            <?php
            if(empty($_GET['id_by']) AND empty($_GET['new'])){
            ?>
                <h1 id="tconv">Conversation</h1><br><a href="messagerie.controleur.php?new=mes" id="new_mes">Nouveau message</a>
            <?php
            }
            ?>
            </div>
          <?php
            if(empty($_GET['id_by']) AND empty($_GET['new'])){
                $conversations = $dbh->prepare("SELECT DISTINCT `id_by` FROM `messages` WHERE `id_to` = :id");
                $conversations->execute(array('id'=>$_SESSION['id'] ));
                $conversations = $conversations->fetchAll();
                foreach($conversations as $conversation){
                    $quics = $dbh->prepare("SELECT * FROM `user` WHERE id = :id");
                    $quics->execute(array('id'=>$conversation['id_by'] ));
                    $quics = $quics->fetchAll();
                    foreach($quics as $quic){
                        $nbm_nl = $dbh->prepare("SELECT  COUNT(`id_message`) FROM `messages` WHERE `id_to` = :id AND `id_by` = :id_by AND `lu` = 0");
                        $nbm_nl->execute(array('id'=>$_SESSION['id'],
                                                'id_by'=>$quic['id'] ));
                        $nbm_nl = $nbm_nl->fetchAll();
                        foreach($nbm_nl as $nb_nonlu){
                            $nb_menl = $nb_nonlu[0];
                        }
                        if(empty($quic["img_profil"])){
                            $quic["img_profil"] = "https://img.generation-nt.com/twitter-oeuf_012C00C801646334.jpg";
                        }
                        echo '<ul class="timeline">
                            <a class="header-menu-number" id="number" href="#">'.$nb_menl.'</a>
                            <li>
                            <div class="avatar">
                                <a href="messagerie.controleur.php?id_by='.$quic["id"].'"><img src="'.htmlspecialchars($quic["img_profil"]).'" alt="image_profil"></a>
                            </div>
                            <div class="bubble-container">
                                <div class="bubble">
                                    <div class="retweet">
                                    </div>
                                    <h3 id="h3twet">'.htmlspecialchars($quic["nom"]).'</h3><p id="datetw">'.htmlspecialchars($quic["date_ins"]).'</p><br/>                 
                                </div>
                            </div>
                            </li>
                            </ul>';
                    }
                }
            }
            if(!empty($_GET['id_by']) AND empty($_GET['new'])){
                if(is_numeric($_SESSION['id_by'])){
                    $conversations_user = $dbh->prepare("SELECT * FROM `messages` INNER JOIN `user` ON `user`.`id` = `messages`.`id_by` WHERE `id_by` = ".$_SESSION['id_by']." AND id_to = ".$_SESSION['id']." OR `id_to` = ".$_SESSION['id_by']." AND `id_by` = ".$_SESSION['id']." ORDER BY `date_env` DESC");
                    $conversations_user->execute(array());
                    $conversations_user = $conversations_user->fetchAll();
                    $i = 0;
                    foreach($conversations_user as $conversation_user){
                        $ul = '<ul style="margin-top: 125px;" class="timeline">';
                        if($i > 0){
                            $ul = '<ul class="timeline">';
                        }
                        if(empty($conversation_user["img_profil"])){
                            $conversation_user["img_profil"] = "https://img.generation-nt.com/twitter-oeuf_012C00C801646334.jpg";
                        }
                        echo $ul.'
                            <li>
                            <div class="avatar">
                                <a href="Profil.controleur.php?id='.$conversation_user["id"].'"><img src="'.htmlspecialchars($conversation_user["img_profil"]).'" alt="image_profil"></a>
                            </div>
                            <div class="bubble-container">
                                <div class="bubble">
                                    <div class="retweet">
                                    </div>
                                    <h3 id="h3twet">'.htmlspecialchars($conversation_user["nom"]).'</h3><p id="datetw">'.htmlspecialchars($conversation_user["date_env"]).'</p><br/><p>
                        '.htmlspecialchars($conversation_user["message"]).'</p>                 
                                </div>
                            </div>
                            </li>
                            </ul>';
                            $i++;
                    }             
                }
                $message_lu = $dbh->prepare("UPDATE `messages` SET `lu`= 1 WHERE `id_to` = :id AND `id_by` = :id_by");
                $message_lu->execute(array("id"=>$_SESSION['id'],
                                                    "id_by"=>$_SESSION['id_by']));
                ?><script>
                window.onload = function(){
                    $('#okok').load('../vue/compte.vue.php #okok');
                }
                </script>
                <?php
            }
            if(empty($_GET['id_by']) AND !empty($_GET['new'])){

            echo '<ul><li><form id="nou_mes" action="messagerie.controleur.php?id_by='.$_GET['id_by'].'" method="POST">
            <p>Nom : </p><input type="texte" name="user_na" id="user_na"><br>
                 <button style="margin-left: 494px;
                  margin-top: 0px;" id="benvoyer" type="submit">Envoyer</button>
                <textarea name="tweetc" id="textareaChars" maxlength="140" style="position: absolute;width: 470px; height: 100px;"></textarea><p id="compteur">140</p>
                <input type="hidden" name="function" value="nou_message">
                </form></li></ul><br><br><br><br><br><br>';
            }
        ?>
</div>
      </div>      
            
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script type="text/javascript" src="../style/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="../style/js/script2.js"></script>
</body>
</html>
