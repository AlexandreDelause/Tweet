
	$('#textareaChars').keyup( function(){
		var nb_char = ($('#textareaChars').val()).length;
		var char = 140 - nb_char;
		if (nb_char == 0)
			char = 140;
		$('#compteur').html(char);
	})

	$("#tweetform").submit(function(e){
		e.preventDefault();
	    var donnees = $(this).serialize();
	    $.ajax({
       		url : '../modelle/compte.modelle.php', // La ressource ciblée
       		type : 'POST', // Le type de la requête HTTP.
       		dataType : 'html',
       		data : donnees,
	   		success : function (reponse){
	   			console.log(reponse);
   				$('#textareaChars').val("");
   				$('#compteur').html(140);	
	    	},
	      	error : function(error){
	    		console.log(error);
	    	}
	    });
	});

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


	$('#textareaChars').keyup( function(){
        var tw_char = $('#textareaChars').val();
        var splittweet = tw_char.split(" ");
        splittweet.forEach(function(value) {
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
                                var char = $('#textareaChars').val();
                                //console.log("CHAR ===> "+char);
                                //console.log("VALU ===> "+valu);
                                //console.log("VALUE ===> "+value)
                                var res = char.replace(value, valu);
                                //console.log("RES ====> "+res);
                                    MyList.push(res);
                            })
                            $('#textareaChars').autocomplete({
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
                    //console.log(value);
                    $.ajax({
                        url : '../modelle/compte.modelle.php', // La ressource ciblée
                        type : 'GET', // Le type de la requête HTTP.
                        dataType : 'html',
                        data : "&function=noma&ra="+value,
                        success : function (reponse){
                        	console.log(reponse);
                            var splitrep = reponse.split("*/");
                            var MyList = [];
                            splitrep.forEach(function(valu) {
                                var char = $('#textareaChars').val();

                                //console.log("CHAR ===> "+char);
                                //console.log("VALU ===> "+valu);
                                //console.log("VALUE ===> "+value)
                                var res = char.replace(value, valu);
                                //console.log("RES ====> "+res);
                                    MyList.push(res);
                            })
                            $('#textareaChars').autocomplete({
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
    });


    function like(id){  
        $.ajax({
            url : '../modelle/compte.modelle.php', // La ressource ciblée
            type : 'GET', // Le type de la requête HTTP.
            dataType : 'html',
            data : "function=like&id_tweet="+id,
            success : function (reponse){
                console.log(reponse);
                    setTimeout(function(){ 
                        $('#all_t').load('../vue/compte.vue.php #all_t');
                        $('#info_user').load('../vue/compte.vue.php #info_user');
                    }, 1)  
            },
            error : function(error){
                console.log(error);
            }
        });
    }

    function retweet(id){  
        $.ajax({
            url : '../modelle/compte.modelle.php', // La ressource ciblée
            type : 'GET', // Le type de la requête HTTP.
            dataType : 'html',
            data : "function=retweet&id_tweet="+id,
            success : function (reponse){
                console.log(reponse);
                    setTimeout(function(){ 
                        $('#all_t').load('../vue/compte.vue.php #all_t');
                        $('#info_user').load('../vue/compte.vue.php #info_user');
                    }, 1)  
            },
            error : function(error){
                console.log(error);
            }
        });
    }

    function new_com(id_t){
        var com = $('#text_'+id_t).val();
        $.ajax({
            url : '../modelle/compte.modelle.php', // La ressource ciblée
            type : 'GET', // Le type de la requête HTTP.
            dataType : 'html',
            data : 'function=new_com&idt='+id_t+'&com='+com,
            success : function (reponse){
                console.log(reponse);
                $('#text_'+id_t).val("");
                setTimeout(function(){ 
                    $('#all_t').load('../vue/compte.vue.php #all_t');
                    $('#info_user').load('../vue/compte.vue.php #info_user');
                }, 1)
                start();
            },
            error : function(error){
                console.log(error);
            }
        });
    }

    var timer = null, 
    interval = 5000,
    value = 0;

    function start() {
      if (timer !== null) return;
      timer = setInterval(function () {
        $('#all_t').load('../vue/compte.vue.php #all_t');
        $('#info_user').load('../vue/compte.vue.php #info_user');
      }, interval); 
    };

    start();

    function stop() {
      clearInterval(timer);
      timer = null
    };

    $('#buttweet').click( function(){
        setTimeout(function(){ 
            $('#all_t').load('../vue/compte.vue.php #all_t');
            $('#info_user').load('../vue/compte.vue.php #info_user');
        }, 1)
    })



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

    $('#user_na').keyup( function(){
        value = $('#user_na').val();
        var nba = value.indexOf("@");
        if(nba == 0){
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
                        $('#user_na').autocomplete({
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


    $("#nou_mes").submit(function(e){
        e.preventDefault();
        var donnees = $(this).serialize();
        $.ajax({
            url : '../modelle/messagerie.modelle.php', // La ressource ciblée
            type : 'POST', // Le type de la requête HTTP.
            dataType : 'html',
            data : donnees,
            success : function (reponse){
                console.log(reponse);
                if(reponse == "ok"){
                    $('#user_na').css("border","1px solid green");
                    $('#textareaChars').css("border","1px solid green");
                    window.location.replace("../controlleur/messagerie.controleur.php");
                }
                else if(reponse == "false_name"){
                    $('#user_na').css("border","1px solid red");
                }
                else if(reponse == "false_mess"){
                    $('#textareaChars').css("border","1px solid red");
                }
                else if(reponse == "no_name"){
                    $('#user_na').css("border","1px solid red");
                }
            },
            error : function(error){
                console.log(error);
            }
        });
    });

    setInterval(function () {
        $('#okok').load('../vue/compte.vue.php #okok');
    }, 5000);