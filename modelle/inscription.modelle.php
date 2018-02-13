<?php
include_once('../database.php');
$ok = true;
if($_POST['function'] == 'add_user'){
    $nom = htmlspecialchars($_POST['nom']);
    $pseudo = htmlspecialchars($_POST['pseudo']);
    $date_naissance = htmlspecialchars($_POST['date_naissance']);
    $mail = htmlspecialchars($_POST['mail']);
    $mdpv = htmlspecialchars($_POST['mdpv']);
    $mdp = htmlspecialchars($_POST['mdp']);
    $ville = htmlspecialchars($_POST['ville']);

    if(!empty($nom)){ 
        echo "nom_ok*/";
    }
    else{
        echo "nom_ko*/";
        $ok = false;
    }
    if(!empty($pseudo)){
        echo "pseudo_ok*/";
    }
    else{
        echo "pseudo_ko*/";
        $ok = false;
    }
    if(!empty($date_naissance)){
        $tab_date = explode("-", $date_naissance);
        $jour = $tab_date[2];
        $mois = $tab_date[1];
        $annee = $tab_date[0];
        $birth = $annee."/".$mois."/".$jour;
        $date = new DateTime();
        $year = $date->format('Y');
        $age = $year - $annee;
        if($age < 14){
            echo "age_min*/";
            $ok=false;
        }
        else if($age == 14){
            $date = new DateTime();
            $month = $date->format('m');
            $verifm = $month - $mois;
            if($verifm >= 0){
                $date = new DateTime();
                $day = $date->format('d');
                $verifj = $day - $jour;
                if($verifj < 0){
                    echo "age_min*/";
                     $ok = false;
                }
                else{
                    echo "age_ok*/";
                }
            }
        }
        elseif($age > 14){
            echo "age_ok*/";  
        }
    }
    else{
        echo "dn_empty*/";
         $ok = false;
    }
    if(!empty($mail)){
        $patternmail = "#^(|(([A-Za-z0-9]+_+)|([A-Za-z0-9]+\-+)|([A-Za-z0-9]+\.+)|([A-Za-z0-9]+\++))*[A-Za-z0-9]+@((\w+\-+)|(\w+\.))*\w{1,63}\.[a-zA-Z]{2,6})$#";
        if(preg_match($patternmail, $mail)){
            $verifemail = $dbh->prepare("SELECT `mail` FROM `user` WHERE `mail` = :mail");
            $verifemail->execute(array('mail'=>$mail ));
            $verifemail = $verifemail->fetchAll();
            if(count($verifemail) == 0){
                echo "mail_ok*/";
            }
            else{
                echo "mail_ko*/";
                $ok=false;
            }
        }
        else{
            echo "mail_inv*/";
            $ok=false;
        } 
    }
    else{
        echo "mail_empty*/";
        $ok = false;
    }
    if(strlen($mdp) > 7){
        if($mdp == $mdpv){
            echo "mdp_ok*/";
        }
        else{
            echo "mdp_equal*/";
            $ok = false;
        }
    }
    else{
        echo "mdp_low*/";
        $ok = false;
    }
    if(strlen($mdpv) > 7){
        if($mdp == $mdpv){
            echo "mdpv_ok*/";
        }
        else{
            echo "mdpv_equal*/";
            $ok = false;
        }
    }
    else{
        echo "mdpv_low*/";
        $ok = false;  
    }
    if(strlen($ville)>1){
        $verif_ville = $dbh->query('SELECT * FROM `villes_france_free` WHERE `ville_nom_simple` = "'.$ville.'"');
        $verif_ville = $verif_ville->fetchAll();
        foreach($verif_ville as $ville2){
            $id_ville = $ville2['ville_id'];
        }
        if(!empty($id_ville)){
            echo "ville_ok*/";
        }
        else{
            echo "ville_ko*/";
        $ok = false;  
        }
    }
    else{
        echo "ville_ko*/";
        $ok = false;
    }
    if($ok == true){
        $nom = strtolower($nom);
        $nom = ucfirst($nom);
        $key = "si tu aimes la wac tape dans tes mains";
        $mdp = hash_hmac("ripemd160", $mdp, $key);
        $img = "https://img.generation-nt.com/twitter-oeuf_012C00C801646334.jpg";
        $inscription = $dbh->prepare("INSERT INTO user(nom, pseudo, date_nais, mail, password, ville_id, img_profil, date_ins, activee) VALUES (:nom, :pseudo, :birth, :mail, :mdp, :ville, :img, NOW(), 1)");
        $inscription->execute(array('nom'=>$nom,
                                    'pseudo'=>$pseudo,
                                    'birth'=>$birth,
                                    'mail'=>$mail,
                                    'mdp'=>$mdp,
                                    'ville'=>$id_ville,
                                    'img'=>$img ));
        echo "ins_ok*/";
    }
}
elseif($_POST['function'] == 'connection'){
    $email_co = htmlspecialchars($_POST['iden']);
    $pass = htmlspecialchars($_POST['pass']);
    if(!empty($email_co)){
        $patternmail = "#^(|(([A-Za-z0-9]+_+)|([A-Za-z0-9]+\-+)|([A-Za-z0-9]+\.+)|([A-Za-z0-9]+\++))*[A-Za-z0-9]+@((\w+\-+)|(\w+\.))*\w{1,63}\.[a-zA-Z]{2,6})$#";
        if(preg_match($patternmail, $email_co)){
            $key = "si tu aimes la wac tape dans tes mains";
            $pass = hash_hmac("ripemd160", $pass, $key);
            $connection = $dbh->prepare("SELECT * FROM `user` WHERE `mail` = :mail AND `password` = :mdp");
            $connection->execute(array('mail'=>$email_co,
                                        'mdp'=>$pass ));
            $connection = $connection->fetchAll();
            if(count($connection) == 0){
                echo "iden_ko*/";
                $ok=false;
            }
            else{
                session_start();
                foreach($connection as $info_user){
                    $_SESSION['id'] = $info_user['id'];
                }
                echo $_SESSION['id']."*/";
            }
        }
        else{
            echo "mail_inv*/";
            $ok=false;
        } 
   }
    else{
        echo "mail_empty*/";
        $ok = false;
    }
}
elseif($_GET['function'] == "nomville"){
    $resultat = $dbh->query('SELECT * FROM `villes_france_free` WHERE `ville_nom_simple` like "'.$_GET["recherche"].'%" ORDER BY `ville_nom_reel` ASC');
    $resultat = $resultat->fetchAll();
    foreach($resultat as $ville_nom){
        echo ucfirst($ville_nom['ville_nom_simple'])."*/";
    }
}