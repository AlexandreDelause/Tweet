window.onload = function(){
	
	$("#ins").submit(function(e){
		e.preventDefault();
	    	var donnees = $(this).serialize();
	    	$.ajax({
	       		url : '../modelle/inscription.modelle.php', // La ressource ciblée
	       		type : 'POST', // Le type de la requête HTTP.
	       		dataType : 'html',
	       		data : donnees,
	       		success : function (reponse){
	       			console.log(reponse);
	       			var splitrep = reponse.split("*/");
	       			splitrep.forEach(function(value) {
			       		if(value == "nom_ok"){
			       			$('#pnom').text("");
			       			$('#nom').css("border","1px solid green");
			       		}
			       		else if(value == "nom_ko"){
			       			$('#pnom').text("Rentrer votre nom !");
			       			$('#nom').css("border","1px solid red");
			       		}
			       		else if(value == "pseudo_ok"){
			       			$('#ppseudo').text("");
			       			$('#pseudo').css("border","1px solid green");
			       		}
			       		else if(value == "pseudo_ko"){
			       			$('#ppseudo').text("Rentrer votre pseudo !");
			       			$('#pseudo').css("border","1px solid red");
			       		}
			       		else if(value == "age_min"){
			       			$('#pdate').text("Il faut avoir 13ans !");
			       			$('#date').css("border","1px solid red");
			       		}
			       		else if(value == "age_ok"){
			       			$('#pdate').text("");
			       			$('#date').css("border","1px solid green");
			       		}
			       		else if(value == "dn_empty"){
			       			$('#pdate').text("Entrer votre date de naissance !");
			       			$('#date').css("border","1px solid red");
			       		}
			       		else if(value == "mail_ok"){
			       			$('#pmail').text("");
			       			$('#mail').css("border","1px solid green");
			       		}
			       		else if(value == "mail_ko"){
			       			$('#pmail').text("L'adresse est déja utilisé !");
			       			$('#mail').css("border","1px solid red");
			       		}
			       		else if(value == "mail_inv"){
			       			$('#pmail').text("Adresse invalid !");
			       			$('#mail').css("border","1px solid red");
			       		}
			       		else if(value == "mail_empty"){
			       			$('#pmail').text("Rentrez votre adresse !");
			       			$('#mail').css("border","1px solid red");
			       		}
			       		else if(value == "mdp_ok"){
			       			$('#pmdp').text("");
			       			$('#mdp').css("border","1px solid green");
			       		}
			       		else if(value == "mdp_equal"){
			       			$('#pmdp').text("mot de passe non identique !");
			       			$('#mdp').css("border","1px solid red");
			       		}
			       		else if(value == "mdp_low"){
			       			$('#pmdp').text("7 caractère minimum !");
			       			$('#mdp').css("border","1px solid red");
			       		}
			       		else if(value == "mdpv_ok"){
			       			$('#pmdpv').text("");
			       			$('#mdpv').css("border","1px solid green");
			       		}
			       		else if(value == "mdpv_equal"){
			       			$('#pmdpv').text("mot de passe non identique !");
			       			$('#mdpv').css("border","1px solid red");
			       		}
			       		else if(value == "mdpv_low"){
			       			$('#pmdpv').text("7 caractère minimum !");
			       			$('#mdpv').css("border","1px solid red");
			       		}
			       		else if(value == "ville_ok"){
			       			$('#pville').text("");
			       			$('#ville').css("border","1px solid green");
			       		}
			       		else if(value == "ville_ko"){
			       			$('#pville').text("Choisissez une ville !");
			       			$('#ville').css("border","1px solid red");
			       		}
			       		else if(value == "ins_ok"){
			       			location.reload();
			       		}
			       	});	
	       		},
	       		error : function(error){
	       			console.log(error);
	       		}

	    	});
	});

	$("#co").submit(function(e){
		e.preventDefault();
	    	var donnees = $(this).serialize();
	    	$.ajax({
	       		url : '../modelle/inscription.modelle.php', // La ressource ciblée
	       		type : 'POST', // Le type de la requête HTTP.
	       		dataType : 'html',
	       		data : donnees,
	       		success : function (reponse){
	       			console.log(reponse);
	       			var splitrep = reponse.split("*/");
	       			splitrep.forEach(function(value) {
			       		if(Math.floor(value) == value && $.isNumeric(value)){
			       			$('#ppass').text("");
			       			$('#pass').css("border","1px solid green");
			       			$('#piden').text("");
			       			$('#iden').css("border","1px solid green");
			       			window.location.replace("../controlleur/compte.controleur.php?id="+value);
			       		}
			       		else if(value == "iden_ko"){
			       			$('#ppass').text("Mot de passe ou identifiant éroné !");
			       			$('#pass').css("border","1px solid red");
			       			$('#piden').text("Mot de passe ou identifiant éroné !");
			       			$('#iden').css("border","1px solid red");
			       		}
			       		else if(value == "mail_inv"){
			       			$('#piden').text("Rentrez une adresse valide");
			       			$('#iden').css("border","1px solid red");
			       		}
			       		else if(value == "mail_empty"){
			       			$('#piden').text("Rentrer votre adresse !");
			       			$('#iden').css("border","1px solid red");
			       		}
			       	});	
	       		},
	       		error : function(error){
	       			console.log(error);
	       		}
	    	});
	});

	 $('#ville').keyup(function(){
	 	if(($('#ville').val()).length > 1){
	 		var recherche = $('#ville').val()
	        $.ajax({
	            url : '../modelle/inscription.modelle.php', // La ressource ciblée
	            type : 'GET', // Le type de la requête HTTP.
	            dataType : 'html',
	            data : "function=nomville&recherche="+recherche,
	            success : function (reponse){
	            	var splitrep = reponse.split("*/");
	            	var MyList = [];
	       			splitrep.forEach(function(value) {
		        		MyList.push(value);
	    			})
	    			$('#ville').autocomplete({
	        			source: MyList
	    			});
	            },
	            error : function(error){
	                console.log(error);
	            }
	        });
	    }
    })
}