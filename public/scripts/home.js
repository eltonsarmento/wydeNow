$.ajaxSetup({  
  headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});


function atualizarTimeline(){
    var count = $('#totalTarefas').val();
    $.post('home/getTimeline', {totalTarefas : count},  function (result) {
 
 		var json = jQuery.parseJSON(result);

 		if(json != ''){
 			var htmlBody = '';
 			var totalTarefas = 0;
 			
        
	        $.each(json, function(key,value) {
	        	if(key == 'tarefas'){
	        		$.each(value, function(key2,item) {
		        		htmlBody += '<li class="qf b aml">';
		                htmlBody += '  <a class="qj" href="/profile/'+item['nickname']+'"><img class="qh cu" src="/uploads/avatars/'+item['avatar']+'"></a>';
		                htmlBody += '  <div class="qg">';
		                htmlBody += '    <div class="aoc">';
		                htmlBody += '      <div class="qn">';
		                htmlBody += '        <small class="eg dp">'+item['tempoCadastada']+'</small>';
		                htmlBody += '        <h5>'+item['name']+'</h5>';
		                htmlBody += '      </div>';
		                htmlBody += '      <p>'+item['texto']+'</p>';
		                htmlBody += '        <a  onClick="setaDadosModalSugestao('+item['id']+',\''+item['texto']+'\'); return false;"style="margin-right: 10px;"><span class="h xk"></span> Sugestões</a></a>';
		                htmlBody += '    </div>';
		                htmlBody += '  </div>';
		                htmlBody += '</li>';
		                htmlBody += '<br>';
		            });
	            }else if(key == 'totalTarefas'){
	            	totalTarefas = value;
	            }
	        });    
	           
	        $('#timeline').html(htmlBody);
	        $('#totalTarefas').val(totalTarefas);
	        
			
 		}
    });
}
 
// Definindo intervalo que a função será chamada
setInterval("atualizarTimeline()", 120000);

/*======================================================= Pega todas categorias para modal mensagem ============================================================*/


getMyCategories();
function getMyCategories(){
	$.get("/tarefa/getMyCategories", function(result){            
        var json = jQuery.parseJSON(result);
        
        var htmlBody = '<div class="bv" >';        

        $.each(json, function(key,item) { 
        	htmlBody += ' 	<div class="ex ug uk">';
        	htmlBody += ' 		<label>';
        	htmlBody += ' 			<input type="radio" id="radioCategoria" onclick="cadastraTarefaHome('+item['id']+'); return false;" value="'+item['id']+'" name="radioCategoria"><span class="uh"></span>'+item['descricao'];
        	htmlBody += ' 		</label>';
        	htmlBody += ' 	</div>';  
        });

        htmlBody += ' </div>';
        $('#divModalMessageCategorias').html(htmlBody);

		var htmlBodyCopy = '<div class="bv" >';           
        $.each(json, function(key,item) { 
        	htmlBodyCopy += ' 	<div class="ex ug uk">';
        	htmlBodyCopy += ' 		<label>';
        	htmlBodyCopy += ' 			<input type="radio" id="radioCopiar" onclick="copiarTarefaHome('+item['id']+'); return false;" value="'+item['id']+'" name="radioCopiar"><span class="uh"></span>'+item['descricao'];
        	htmlBodyCopy += ' 		</label>';
        	htmlBodyCopy += ' 	</div>';  
        });

        htmlBodyCopy += ' </div>';
        $('#divModalCopiarCategorias').html(htmlBodyCopy);        
        
    });
}
/*============================================================================================================================================*/



/*======================================================== Cadastra Tarefa home =============================================================*/
function cadastraTarefaHome(categoria_id){
	var texto = $('#messageHome').val();

	if(texto.indexOf("@") != -1){
		var nickname = $('#nicknameMessageHome').val();
		texto    	 = texto.replace(nickname,"");
		cadastraDoIt(categoria_id,nickname,texto);			
		$('#msgModalMessageDoIt').modal('hide');
	}else{
		var htmlMessagem = '';

	    $.post("/tarefa/adiciona", {categoria_id: categoria_id, texto: texto}, function(result){            
	    	htmlMessagem += '<div class="alert fq alert-dismissible fade in" role="alert">';
			htmlMessagem += '	 <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>';
			htmlMessagem += '	 <p><span class="h xl"></span> Sua tarefa foi adicionada!!</p>';
			htmlMessagem += ' </div>';
			$("#app-growl").html(htmlMessagem);
	    });
	}
	$('#msgModalMessage').modal('hide');
	$('#radioStatusPublico').prop('checked', false);
	$('#radioStatusPrivado').prop('checked', false);     
	$('#radioCategoria').prop('checked', false); 
	setDefaultCamposTarefaHome();
}

function btnMessagePrivado(){
	var messageHome = $('#messageHome').val();

    if(messageHome.indexOf("@") != -1){	    			    		  
		getcategoriasdoitbynickname();	
	}else{
	    $('#radioStatusPrivado').prop('checked', true);
	    if(messageHome.length > 3){    
	    	$('#messageHome').val(messageHome + " #privado");    
	        $('#msgModalMessage').modal('show');  
	    }
	}
}

function opcaoStatus(status){
	var messageHome = $('#messageHome').val();
	if(status == "privado"){
		var mensagem = messageHome.replace("#privado", "");
		$('#messageHome').val(mensagem + " #privado");    
		$('#radioStatusPublico').prop('checked', false);
		$('#radioStatusPrivado').prop('checked', true);
	}else{
		var mensagem = messageHome.replace("#privado", "");
		$('#messageHome').val(mensagem);    
		$('#radioStatusPrivado').prop('checked', false);
		$('#radioStatusPublico').prop('checked', true);
	}	
}
/*======================================================== Cadastra Tarefa home =============================================================*/


/*=========================================================== Copiar Tarefa =================================================================*/
function setaTarefaCopiar(texto){
	$('#textoTarefaCopiar').val(texto);
	$('#msgModalCopiar').modal('show');	
}


function copiarTarefaHome(categoria_id){
	var texto  = $('#textoTarefaCopiar').val();
	var status = $('#statusTarefaCopiar').val();
	

	$('#msgModalCopiar').modal('hide');    
	$('#radioStatusCopiarPrivado').prop('checked', true); 
	$('#statusTarefaCopiar').val('1');
	var htmlMessagem = '';
    $.post("/tarefa/copiar", {categoria_id: categoria_id, texto: texto, status: status}, function(result){            
    	htmlMessagem += ' <div class="alert fq alert-dismissible fade in" role="alert">';
		htmlMessagem += '	 <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>';
		htmlMessagem += '	 <p><span class="h xl"></span> Sua tarefa foi copiada!!</p>';
		htmlMessagem += ' </div>';
		$("#app-growl").html(htmlMessagem);		  
    });
}


function opcaoStatusCopiar(status){	
	if(status == "privado"){
		$('#statusTarefaCopiar').val(1);
		$('#radioStatusCopiarPublico').prop('checked', false);
		$('#radioStatusCopiarPrivado').prop('checked', true);
	}else{		
		$('#statusTarefaCopiar').val(0);
		$('#radioStatusCopiarPrivado').prop('checked', false);
		$('#radioStatusCopiarPublico').prop('checked', true);
	}	
}
/*=========================================================== Copiar Tarefa =================================================================*/



$(document).keypress(function(e) {    	

	
	var isSearch 	  =  $('#isSearch').val();
	var textSearch 	  =  $('#textSearch').val();
	var textoCompleto = $('#messageHome').val();

	if(e.which == 64){
    	$('#isSearch').val('1');
    	$('#textSearch').val('@');
    	textoCompleto += "@";
    }

    if(textoCompleto.indexOf("@") == -1){
		textSearch = "";
		$('#textSearch').val('');
	}else{
		if(isSearch == '1'){    	
	    	textSearch += e.key;
	    	$('#textSearch').val(textSearch);    	
	    }

	    if(textSearch.length > 3){	    	
	    	$.post("/profile/getusersearch", {textSearch: textSearch}, function(result){
	    		if(result != 'false'){

	    			var json = jQuery.parseJSON(result);
	    			var htmlRetorno = '';
	    			$.each(json, function(key,item) {
	    					    				
		    			htmlRetorno += '<div class="b" onClick="setNicknameDoit(\''+textSearch+'\',\''+item['nickname']+'\'); return false;">';
						htmlRetorno += '	 <div class="anp">';
						htmlRetorno += '	 	<img class="cu"  src="/uploads/avatars/'+item['avatar']+'">';
						htmlRetorno += ' 	</div>';
						htmlRetorno += ' 	<smal><strong>'+item['name']+'</strong></smal>';
						htmlRetorno += '</div>';					
					});

					$("#conteudoListaPerquisaDoit").html(htmlRetorno);
					$("#listaPerquisaDoit").css("display", "block");
	    		}else{
	    			$("#conteudoListaPerquisaDoit").html('');
					$("#listaPerquisaDoit").css("display", "none");
	    		}
		    	
		    });
	    }
	}

	if(e.which == 13){
		var messageHome = $('#messageHome').val(); 
	    if(messageHome.length > 3){
	    	if(messageHome.indexOf("@") != -1){	    			    		  
	    		getcategoriasdoitbynickname();	    		
	    	}else{
	        	$('#radioStatusPublico').prop('checked', true);            
	        	$('#msgModalMessage').modal('show');   
	        }
	    }
	}
});
function getcategoriasdoitbynickname(){
	var nickname = $('#nicknameMessageHome').val();
	var texto    = $('#messageHome').val();
	texto    	 = texto.replace(nickname,"");	
	$.post("/profile/getcategoriasdoitbynickname", {nickname: nickname}, function(result){
		
		var json = jQuery.parseJSON(result);		    			
		if(json.length == 1){
			$.each(json, function(key,item) {	 
				var categoria_id = item['id'];	    					
				cadastraDoIt(categoria_id,nickname,texto);	    					
			})						
		}else if(json.length > 1){
			var htmlRetornoCategorias = '';
			$.each(json, function(key,item) {	    						
				htmlRetornoCategorias += ' 	<div class="ex ug uk">';
	        	htmlRetornoCategorias += ' 		<label>';
	        	htmlRetornoCategorias += ' 			<input type="radio" id="radioCategoria" onclick="cadastraTarefaHome('+item['id']+'); return false;" value="'+item['id']+'" name="radioCategoria"><span class="uh"></span>'+item['descricao'];
	        	htmlRetornoCategorias += ' 		</label>';
	        	htmlRetornoCategorias += ' 	</div>'; 
			});
			$('#categoriasmsgModalMessageDoIt').html(htmlRetornoCategorias);
			$('#msgModalMessageDoIt').modal('show'); 
		}
    	
    });
}
function setNicknameDoit(textSearch,nickname){	
	var textoCompleto = $('#messageHome').val();
	textoCompleto = textoCompleto.replace(textSearch,nickname);	
	
	setDefaultCamposTarefaHome();
	$('#nicknameMessageHome').val(nickname);
	$('#messageHome').val(textoCompleto);
}

function setDefaultCamposTarefaHome(){
	$('#messageHome').val('');
	$('#nicknameMessageHome').val('');
	$("#conteudoListaPerquisaDoit").html('');
	$("#listaPerquisaDoit").css("display", "none");
	$('#textSearch').val('');
	$('#isSearch').val('0');
	$('#messageHome').focus();	
}

function cadastraDoIt(categoria_id,nickname,texto){
	var htmlMessagem = '';
	$.post("/tarefa/doit", {categoria_id: categoria_id, nickname: nickname, texto: texto}, function(result){            
    	htmlMessagem += '<div class="alert fq alert-dismissible fade in" role="alert">';
		htmlMessagem += '	 <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>';
		htmlMessagem += '	 <p><span class="h xl"></span> Tarefa doit para '+nickname+' foi criada!!</p>';
		htmlMessagem += ' </div>';
		$("#app-growl").html(htmlMessagem);	
		setDefaultCamposTarefaHome();
    });
}