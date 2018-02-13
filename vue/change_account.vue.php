<!DOCTYPE html>
<html>
<head>
	<title>edit_account</title>
	<link rel="stylesheet" href="../style/css/style2.css">
    <link rel="stylesheet" href="../style/css/css.css">
    <link rel="stylesheet" href="../style/css/bootstrap-responsive.css">
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.0/themes/smoothness/jquery-ui.css" />

</head>
<body>
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
		<div class="form-style-10">
<h1>Modifier Votre Compte !</h1>
<form method="POST" id="modif">
    <div class="section"><span>1</span>Changement photo de profil</div>
    <div class="inner-wrap">
        <?php echo '<img src='.$img_p.' width="90" height="90" alt="img_user"/>'; ?>
        <div id="ip">
            <input type="file" name="img_p" id="img_p"/>
            <p id="pimg_p" class="perror"></p>
        </div>
    </div>
     <div class="section"><span>2</span>Changement photo de fond</div>
    <div class="inner-wrap">
        <?php echo '<img src='.$img_c.' width="150" height="90" alt="img_user"/>'; ?>
        <div id="ip">
            <input type="file" name="img_c" id="img_c"/>
            <p id="pimg_c" class="perror"></p>
        </div>
    </div>
    <div class="section"><span>3</span>Changez De Nom</div>
        <div class="inner-wrap">
        <label for="new_name">Nouveau nom </label>
        <div class="ip">
        	<input type="text" name="new_name" id="new_name"/>
        	<p id="pnew_name" class="perror"></p>
        </div>
    </div>
    <div class="section"><span>4</span>Changez Votre Email</div>
    <div class="inner-wrap">
        <label for="older_email">Ancienne adresse mail </label>
        <div class="ip">
        	<input type="text" name="older_email" id="older_email"/>
        	<p id="polder_email" class="perror"></p>
        </div>
        <label for="new_email">Nouvelle</label>
        <div class="ip">
        	<input type="text" name="new_email" id="new_email"/>
        	<p id="pnew_email" class="perror"></p>
        </div>
    </div>

    <div class="section"><span>5</span>Changez De Mot De Passe</div>
        <div class="inner-wrap">
        <label for="older_mdp">Ancien Mot De Passe </label>
        <div class="ip">
        	<input type="password" name="older_mdp" id="older_mdp"/>
        	<p id="polder_mdp" class="perror"></p>
        </div>
        <label for="new_mdp">Nouveau Mot De Passe </label>
        <div class="ip">
        	<input type="password" name="new_mdp" id="new_mdp"/>
        	<p id="pnew_mdp" class="perror"></p>
        </div>
        <label for="cnew_mdp">Confirmez Votre Nouveau Mot De Passe </label>
        <div class="ip">
        	<input type="password" name="cnew_mdp" id="cnew_mdp"/>
        	<p id="pcnew_mdp" class="perror"></p>
        </div>
    </div>
    <input type="hidden" name="function" value="modif_account">
    <div class="button-section">
     <input type="submit" name="Sign Up" id="change"/>
    </div>
</form>
</div>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script type="text/javascript" src="../style/js/change_account.js"></script>
<script type="text/javascript" src="../style/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="../style/js/script2.js"></script> 
</body>
</html>