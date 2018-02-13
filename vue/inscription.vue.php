<!DOCTYPE html>
<html>
<head>
	<title>Connexion</title>
		<link rel="stylesheet" href="../style\css\bootstrap-responsive.css">
		<link rel="stylesheet" href="../style\css\style.css">
		<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.0/themes/smoothness/jquery-ui.css" />
		<meta charset="utf-8">
</head>
<body>

<div class="login-wrap">
	<div class="login-html">
		<input style="margin-bottom: 30px;" id="tab-1" type="radio" name="tab" class="sign-in" checked><label for="tab-1" class="tab">Se connecter</label>
		<input id="tab-2" type="radio" name="tab" class="sign-up"><label for="tab-2" class="tab">S'inscrire</label>
		<div class="login-form">
			<div class="sign-in-htm">
			<form id="co">

				<div class="group">
					<label style="color:#fff; font-family: cursive;" for="iden" class="label">Adresse mail</label>
					<div class="ip">
						<input id="iden" name="iden" type="text" class="input">
					<p id="piden" class="perror"></p>
                    </div>
				</div>
				<div class="group">
					<label style="color:#fff; font-family: cursive;" for="pass" class="label">mots de passe</label>
					<div class="ip">
						<input id="pass" name="pass" type="password" class="input" data-type="password">
					<p id="ppass" class="perror"></p>
                    </div>
                    <input type="hidden" name="function" value="connection">
					<input type="submit" class="login pull-right" value="Log In" style="margin-left: 130px;">

				</div>
				<div class="group">
					<img src="http://blog.infowebmaster.fr/img/logo/autres/twitter-logo-500px.png" width="380px" alt="twitter_log">
				</div>

				<div class="hr"></div>
			</form>
			</div>
			

			<div class="sign-up-htm">
			<div class="Inscription">
			  <form id="ins">
				<div class="group">
					<label style="color:#fff; font-family: cursive;" for="nom" class="label">Nom</label>
					<div class="ip">
						<input id="nom" name="nom" type="text" class="input">
					<p id="pnom" class="perror"></p>
                    </div>
				</div>
				<div class="group">
					<label style="color:#fff; font-family: cursive;" for="pseudo" class="label">pseudo</label>
					<div class="ip">
						<input id="pseudo" name="pseudo" type="text" class="input">
					<p id="ppseudo" class="perror"></p>
                    </div>
				</div>
				<div class="group">
					<label style="color:#fff; font-family: cursive;" for="date" class="label">Date de naissance</label>
					<div class="ip">
						<input id="date" name="date_naissance"  type="date" class="input">
					<p id="pdate" class="perror"></p>
                    </div>
				</div>
				<div class="group">
					<label style="color:#fff; font-family: cursive;" for="mail" class="label">Adresse mail</label>
					<div class="ip">
						<input id="mail" name="mail" type="text" class="input">
					<p id="pmail" class="perror"></p>
                    </div>
				</div>
				<div class="group">
					<label style="color:#fff; font-family: cursive;" for="mdp" class="label">mots de passe</label>
					<div class="ip">
						<input id="mdp" name="mdp" type="password" class="input" data-type="password">
					<p id="pmdp" class="perror"></p>
                    </div>
				</div>
				<div class="group">
					<label style="color:#fff; font-family: cursive;" for="mdpv" class="label">Verifier mots de passe</label>
					<div class="ip">
						<input id="mdpv" name="mdpv" type="password" class="input" data-type="password">
					<p id="pmdpv" class="perror"></p>
                    </div>
				</div>
				<div class="group">
					<label style="color:#fff; font-family: cursive;" for="ville" class="label">Ville</label>
					<div class="ip">
						<input id="ville" name="ville" class="input" type="text">
					<p id="pville" class="perror"></p>
                    </div>
				</div>
			
				<div class="group">
					<input type="hidden" value="add_user" name="function">
					<input type="submit" class="button" value="Inscription">
				</div>
				<div class="hr"></div>
				
					</form>
			</div>
		</div>
	</div>
</div>
</div>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script type="text/javascript" src="../style/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="../style/js/script.js"></script>

</body>
</html>