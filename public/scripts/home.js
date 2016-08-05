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
setInterval("atualizarTimeline()", 60000);

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
	var htmlMessagem = '';

	$('#msgModalMessage').modal('hide');
	$('#messageHome').val('');
	$('#radioStatusPublico').prop('checked', false);
	$('#radioStatusPrivado').prop('checked', false);     
	$('#radioCategoria').prop('checked', false); 

    $.post("/tarefa/adiciona", {categoria_id: categoria_id, texto: texto}, function(result){            
    	htmlMessagem += '<div class="alert fq alert-dismissible fade in" role="alert">';
		htmlMessagem += '	 <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>';
		htmlMessagem += '	 <p><span class="h xl"></span> Sua tarefa foi adicionada!!</p>';
		htmlMessagem += ' </div>';
		$("#app-growl").html(htmlMessagem);
		  
    });
}
function btnMessagePrivado(){
    var messageHome = $('#messageHome').val();
    $('#radioStatusPrivado').prop('checked', true);
    if(messageHome.length > 3){    
    	$('#messageHome').val(messageHome + " #privado");    
        $('#msgModalMessage').modal('show');  
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



