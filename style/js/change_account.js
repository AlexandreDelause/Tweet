
	window.onload = function(){
		$("#modif").submit(function(e){
			e.preventDefault(); 	
		    $.ajax({
		    	url : '../modelle/change_account.modelle.php', // La ressource ciblée
		       	type : 'POST', // Le type de la requête HTTP.
		       	dataType : 'html',
		       	data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
				contentType: false,       // The content type used when sending data to the server.
				cache: false,             // To unable request pages to be cached
				processData:false, 
		       	success : function (reponse){
		       		console.log(reponse);
		       		var splitrep = reponse.split("*/");
		       			splitrep.forEach(function(value) {
				   		if(value == "false_mail"){
				   			$('#polder_email').text("Adresse mail incorret");
				   			$('#older_email').css("border","1px solid red");
				   		}
				   		else if(value == "false_mdp"){
				   			$('#polder_mdp').text("Mot de passe incorrect");
				   			$('#older_mdp').css("border","1px solid red");
				   		}
				   		else if(value == "true_mail"){
				   			$('#polder_email').text("");
				   			$('#older_email').css("border","1px solid green");
				   		}
				   		else if(value == "true_mdp"){
				   			$('#polder_mdp').text("");
				   			$('#older_mdp').css("border","1px solid green");
				   		}
				   		else if(value == "long_mdp"){
				   			$('#pnew_mdp').text("Le mot de passe doit faire 8 caractères !");
				   			$('#new_mdp').css("border","1px solid red");
				   			$('#pcnew_mdp').text("Le mot de passe doit faire 8 caractères !");
				   			$('#cnew_mdp').css("border","1px solid red");
				   		}
				   		else if(value == "equal_mdp"){
				   			$('#pnew_mdp').text("Les mot de passes doivent être identiques !");
				   			$('#new_mdp').css("border","1px solid red");
				   			$('#pcnew_mdp').text("Les mot de passes doivent être identiques !");
				   			$('#cnew_mdp').css("border","1px solid red");
				   		}
				   		else if(value == "true_new_mdp"){
				   			$('#pnew_mdp').text("");
				   			$('#new_mdp').css("border","1px solid green");
				   			$('#pcnew_mdp').text("");
				   			$('#cnew_mdp').css("border","1px solid green");
				   		}
				   		else if(value == "false_new_mail"){
				   			$('#pnew_email').text("Adresse déja utilisé");
				   			$('#new_email').css("border","1px solid red");
				   		}
				   		else if(value == "false_new_umail"){
				   			$('#pnew_email').text("Adresse invalid");
				   			$('#new_email').css("border","1px solid red");
				   		}
				   		else if(value == "true_new_mail"){
				   			$('#pnew_email').text("");
				   			$('#new_email').css("border","1px solid green");
				   		}
				   		else if(value == "img_exist"){
				   			$('#pimg_p').text("L'image exist déja !");
				   			$('#img_p').css("border","1px solid red");
				   		}
				  		else if(value == "false_size"){
				   			$('#pimg_p').text("L'image est trop grande !");
				   			$('#img_p').css("border","1px solid red");
				   		}
				   		else if(value == "img_exist2"){
				   			$('#pimg_c').text("L'image exist déja !");
				   			$('#img_c').css("border","1px solid red");
				   		}
				  		else if(value == "false_size2"){
				   			$('#pimg_c').text("L'image est trop grande !");
				   			$('#img_c').css("border","1px solid red");
				   		}
				   		else if(value == "false_name"){
				   			$('#pnew_name').text("Rentrez un nom plus long !");
				   			$('#new_name').css("border","1px solid red");
				   		}
				   		else if(value == "true_name"){
				   			$('#pnew_name').text("");
				   			$('#new_name').css("border","1px solid green");
				   		}
				  		else if(value == "change_ok"){
				   			alert('Les modifications on bien été ajouté');
				   			location.reload();
				  		}
				   	});
		       	},
		       	error : function(error){
		       		console.log(error);
		       	}

		    });
		});
	}