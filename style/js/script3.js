

	function follow(){
	    $.ajax({
       		url : '../modelle/profil.modelle.php', // La ressource ciblée
       		type : 'GET', // Le type de la requête HTTP.
       		dataType : 'html',
       		data : "function=follow",
	   		success : function (reponse){
	   			console.log(reponse);
	   				setTimeout(function(){ 
						$('#stat_user').load('../vue/profil.vue.php #stat_user');
					}, 1);	
	    	},
	      	error : function(error){
	    		console.log(error);
	    	}
	    });
	}

	function unfollow(){
	    $.ajax({
       		url : '../modelle/profil.modelle.php', // La ressource ciblée
       		type : 'GET', // Le type de la requête HTTP.
       		dataType : 'html',
       		data : "function=unfollow",
	   		success : function (reponse){
	   			console.log(reponse);
	   				setTimeout(function(){ 
						$('#stat_user').load('../vue/profil.vue.php #stat_user');
					}, 1);
	    	},
	      	error : function(error){
	    		console.log(error);
	    	}
	    });
	}

	$('#rah').keyup( function(){
        value = $('#rah').val();
        var nbh = value.indexOf("#");
        var nba = value.indexOf("@");
        if(nbh == 0){
            if(value.length > 2){
                $.ajax({
                    url : '../modelle/compte.modelle.php', // La ressource ciblée
                    type : 'POST', // Le type de la requête HTTP.
                    dataType : 'html',
                    data : "&function=nomhas&rhas="+value,
                    success : function (reponse){
                        console.log(reponse);
                        var splitrep = reponse.split("*/");
                        var MyList = [];
                        splitrep.forEach(function(valu) {
                            MyList.push(valu);
                        })
                        console.log(MyList);
                        $('#rah').autocomplete({
                            source: MyList
                        });
                    },
                    error : function(error){
                        console.log(error);
                    }
                });
            }
        }
        else if(nba == 0){
            if(value.length > 2){
                $.ajax({
                    url : '../modelle/compte.modelle.php', // La ressource ciblée
                    type : 'GET', // Le type de la requête HTTP.
                    dataType : 'html',
                    data : "&function=noma&ra="+value,
                    success : function (reponse){
                        console.log(reponse);
                        var splitrep = reponse.split("*/");
                        var MyList = [];
                        var u = 0;
                        splitrep.forEach(function(valu) {
                            MyList.push(valu);
                        })
                        console.log(MyList);
                        $('#rah').autocomplete({
                            source: MyList
                        });
                    },
                    error : function(error){
                        console.log(error);
                    }
                });
            }
        }
    });

    $('#rah').keyup( function(){
        value = $('#rah').val();
        var nbh = value.indexOf("#");
        var nba = value.indexOf("@");
        if(nbh == 0){
            if(value.length > 2){
                $.ajax({
                    url : '../modelle/profil.modelle.php', // La ressource ciblée
                    type : 'POST', // Le type de la requête HTTP.
                    dataType : 'html',
                    data : "&function=nomhas&rhas="+value,
                    success : function (reponse){
                        console.log(reponse);
                        var splitrep = reponse.split("*/");
                        var MyList = [];
                        splitrep.forEach(function(valu) {
                            MyList.push(valu);
                        })
                        console.log(MyList);
                        $('#rah').autocomplete({
                            source: MyList
                        });
                    },
                    error : function(error){
                        console.log(error);
                    }
                });
            }
        }
        else if(nba == 0){
            if(value.length > 2){
                $.ajax({
                    url : '../modelle/profil.modelle.php', // La ressource ciblée
                    type : 'GET', // Le type de la requête HTTP.
                    dataType : 'html',
                    data : "&function=noma&ra="+value,
                    success : function (reponse){
                        console.log(reponse);
                        var splitrep = reponse.split("*/");
                        var MyList = [];
                        var u = 0;
                        splitrep.forEach(function(valu) {
                            MyList.push(valu);
                        })
                        console.log(MyList);
                        $('#rah').autocomplete({
                            source: MyList
                        });
                    },
                    error : function(error){
                        console.log(error);
                    }
                });
            }
        }
    });

    $('#btheme').click(function(e){
        e.preventDefault();
        $('html').css('background', 'url("https://static1.squarespace.com/static/57840a58f5e2315860ed85bf/t/57853c599f74567650e7e3dc/1468349531775/428160.jpg?format=original")no-repeat fixed');
        $('html').css('font-family', 'cursive');
        $('.block').css('background-color', '#1f2325;');
        $('.main').css('background-color', 'rgb(6, 16, 23);');
        $('.main').css('background-color', 'rgb(31, 35, 37);');
        $('.conteneurp').css('background-color', 'white;');
        $('.over-bubble').css('font-family', 'cursive;');
        $('.main2').css('background-color', 'white;');
        $('p#conteneur').css('color', 'white;');
    });

	setInterval(function refresh(){
		$('#stat_user').load('../vue/profil.vue.php #stat_user');
    }, 5000);