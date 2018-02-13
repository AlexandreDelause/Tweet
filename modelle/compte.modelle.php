
<?php

session_start();
 include_once('../database.php');

    if($_POST['function'] == "new_tweet"){
        if(!empty($_POST['tweetc'])){
            $all_tweets = $dbh->prepare("INSERT INTO `tweet`(`id_user`, `tweet`, `date_tweet`) VALUES (:id, :tweet, NOW())");
            $all_tweets->execute(array('id'=>$_SESSION['id'],
                                        'tweet'=>$_POST['tweetc'] ));
            $search_id = $dbh->prepare("SELECT * FROM `tweet` WHERE `tweet` = :tweet and `id_user` = :id");
            $search_id->execute(array('id'=>$_SESSION['id'],
                                        'tweet'=>$_POST['tweetc'] ));
            $search_id = $search_id->fetchAll();
            foreach($search_id as $id_twe){
                $id_letweet = $id_twe['id_tweet'];
            }
            $htag = "#";
            $arr = explode(" ", htmlspecialchars($_POST['tweetc']));
            $arrc = count($arr);
            $y = 0;
            while($y < $arrc) {
                if(substr($arr[$y], 0, 1) === $htag) {
                    $sai2 =substr($arr[$y], 1, strlen($arr[$y]));
                    $envoie_hash = $dbh->prepare("INSERT INTO `hashtag`(`id_tweet`, `name_hashtag`) VALUES (:id, :hashtag)");
                    $envoie_hash->execute(array('id'=>$id_letweet,
                                        'hashtag'=> $sai2));
                }
                $y++;
            }
            echo "tweet_ok";
        }
    }
    elseif($_GET['function'] == "like"){
        if(!empty($_GET['id_tweet']) && is_numeric($_GET['id_tweet'])){
            $rec_like = $dbh->prepare("SELECT * FROM `tweet_like` WHERE `id_user` = :id AND `id_tweet` = :id_tweet");
            $rec_like->execute(array('id'=>$_SESSION['id'],
                                        'id_tweet'=>$_GET['id_tweet'] ));
            $rec_like = $rec_like->fetchAll();
            foreach($rec_like as $rec_lik){
                $like_user = $rec_lik['id_tweet_like'];
            }
            if(empty($like_user)){
                $like_tweet = $dbh->prepare("INSERT INTO `tweet_like`(`id_user`, `id_tweet`, `date_like`) VALUES (:id, :id_tweet, NOW())");
                $like_tweet->execute(array('id'=>$_SESSION['id'],
                                            'id_tweet'=>$_GET['id_tweet'] ));
            }
            else{
                $like_delete = $dbh->prepare("DELETE FROM `tweet_like` WHERE `id_user` = :id AND `id_tweet` = :id_tweet");
                $like_delete->execute(array('id'=>$_SESSION['id'],
                                            'id_tweet'=>$_GET['id_tweet'] ));
            }
            echo "like_ok";
        }
    }
    elseif($_GET['function'] == "retweet"){
        if(!empty($_GET['id_tweet']) && is_numeric($_GET['id_tweet'])){
            $rec_tweet = $dbh->prepare("SELECT * FROM `tweet` WHERE `id_retweet` = :id_tweet AND `id_user` = :id_user");
            $rec_tweet->execute(array('id_tweet'=>$_GET['id_tweet'],
                                        'id_user'=>$_SESSION['id'] ));
            $rec_tweet = $rec_tweet->fetchAll();
            echo count($rec_tweet);
            if(count($rec_tweet) == 0){
                $retweet_tweet = $dbh->prepare("INSERT INTO `tweet`(`id_user`, `id_retweet`, `date_tweet`) VALUES (:id_user, :id_retweet, NOW())");
                $retweet_tweet->execute(array('id_user'=>$_SESSION['id'],
                                            'id_retweet'=>$_GET['id_tweet'] ));
            }
            else{
                $retweet_delete = $dbh->prepare("DELETE FROM `tweet` WHERE `id_user` = :id_user AND `id_retweet` = :id_retweet");
                $retweet_delete->execute(array('id_user'=>$_SESSION['id'],
                                            'id_retweet'=>$_GET['id_tweet'] ));
            }
            echo "retweet_ok";
        }
    }
    elseif($_GET['function'] == "new_com"){
        if(!empty($_GET['com'])){
            $com_user = $_GET['com'];
            $new_com = $dbh->prepare("INSERT INTO `commentaire`(`id_user`, `id_tweet`, `com`, `date_com`) VALUES (:id, :id_tweet, :com, NOW())");
            $new_com->execute(array('id'=>$_SESSION['id'],
                                    'id_tweet'=>$_GET['idt'],
                                    'com'=>$com_user ));
            echo "com_ok";
        }
    }
    if($_POST['function'] == "nomhas"){
        if(!empty($_POST['rhas'])){
            $rec = htmlspecialchars(str_replace("#", "", $_GET['rhas']));
            $rec_hastags = $dbh->prepare("SELECT DISTINCT `name_hashtag` FROM `hashtag` WHERE `name_hashtag` LIKE '".$rec."%'");
            $rec_hastags->execute();
            $rec_hastags = $rec_hastags->fetchAll();
            foreach($rec_hastags as $rec_hastag){
                echo "#".$rec_hastag['name_hashtag']."*/";
            }
        }
    }
    if($_GET['function'] == "noma"){
        if(!empty($_GET['ra'])){
            $rec = htmlspecialchars(str_replace("@", "", $_GET['ra']));            
            $rec_hastags = $dbh->prepare("SELECT * FROM `user` WHERE `pseudo` LIKE '".$rec."%'");
            $rec_hastags->execute();
            $rec_hastags = $rec_hastags->fetchAll();
            foreach($rec_hastags as $rec_hastag){
                echo "@".$rec_hastag['pseudo']."*/";
            }
        }
    }
?>
