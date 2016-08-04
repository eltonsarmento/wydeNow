function setaDadosModalSugestaoNotification(id, texto, notification_id){
    $('#tituloTarefaSugestao').html(texto);
    $('#idTarefaSugestao').val(id);   

    /*Pega as sugestões para aquela notificação*/
    getSuggestion(id);

    /*Fechar o modal de notificações caso ele estaja aberto*/
    $('#msgModalNotification').modal('hide');
}


function redirectFor(caminho){
	window.location.href = caminho;
}

function setStatusNotification(vIds,status){
	$.post("/notification/setStatus", {vIds: vIds, status: status}, function(result){});
}


function openModalNotification(){	
	var vIdNoticiations = $('#idsAtivas').val(); 
	 /*Alterar o status da notificação para Visualizado*/            
	 if(vIdNoticiations.length > 0)
    	setStatusNotification(vIdNoticiations,'V');

    $('#idsAtivas').val('');   
    $("#divNumberNotification").html('');
	$('#msgModalNotification').modal('show');
}
/*=======================================================================================================*/

verificaNotifications();
setInterval("verificaNotifications()", 15000);

function verificaNotifications(){
	$("#app-growl").html('');
	$.get('/notification/verificanotifications',  function (result) {
 		var json = jQuery.parseJSON(result);
 		if(json != ''){
 			var htmlMessagem = '';
 			var htmlMessagemModal = '<ul class="qo cj ca">';
 			$.each(json, function(key,item) {

 				
 				if(key == 'ativas'){
 					var cont = 0;

 					if(item[0]['total'] != 0){
 						
 						var idsAtivas = [];
	 					$.each(item, function(key2,value) { 
	 						cont++;
	 						idsAtivas.push(value['id']);
	 						
							htmlMessagemModal += '<li class="b">';
							htmlMessagemModal += ' 	<div class="qf">';
							htmlMessagemModal += ' 		<a class="qj" href="/profile/'+value['nickname']+'">';
							htmlMessagemModal += ' 			<img class="qh cu" src="/uploads/avatars/'+value['avatar']+'">';
							htmlMessagemModal += ' 		</a>';
							htmlMessagemModal += ' 		<div class="qg">';
							if(value['link'] != ''){
							 	htmlMessagemModal += '	 		<button class="cg ts fx eg" onClick="'+value['link']+'">ver</button>';
							}
							htmlMessagemModal += ' 			<strong>'+value['name']+'</strong>';
							htmlMessagemModal += ' 			<small>'+value['nickname']+'</small><br>';
							htmlMessagemModal += ' 			<small>'+value['message']+'</small><br>';
							htmlMessagemModal += ' 			<small>'+value['data']+'</small><br>';
							htmlMessagemModal += ' 		</div>';
							htmlMessagemModal += ' 	</div>';
							htmlMessagemModal += '</li>';
						
	 					});						
	 					$("#idsAtivas").val(idsAtivas);	 					
	 					if(cont > 0)
	 						$("#divNumberNotification").html('('+cont+')');
 					}else{
 						$("#divNumberNotification").html('');
 					}
 				}
 				if(key == 'visualizadas'){
 					$.each(item, function(key3,value2) { 							 					
						htmlMessagemModal += '<li class="b">';
						htmlMessagemModal += ' 	<div class="qf">';
						htmlMessagemModal += ' 		<a class="qj" href="/profile/'+value2['nickname']+'">';
						htmlMessagemModal += ' 			<img class="qh cu" src="/uploads/avatars/'+value2['avatar']+'">';
						htmlMessagemModal += ' 		</a>';
						htmlMessagemModal += ' 		<div class="qg">';
						if(value2['link'] != ''){
						 	htmlMessagemModal += '	 		<button class="cg ts fx eg" onClick="'+value2['link']+'">ver</button>';
						}
						htmlMessagemModal += ' 			<strong>'+value2['name']+'</strong>';
						htmlMessagemModal += ' 			<small>'+value2['nickname']+'</small><br>';
						htmlMessagemModal += ' 			<small>'+value2['message']+'</small><br>';
						htmlMessagemModal += ' 			<small>'+value2['data']+'</small><br>';
						htmlMessagemModal += ' 		</div>';
						htmlMessagemModal += ' 	</div>';
						htmlMessagemModal += '</li>';
					
 					});	 					
 				}
 				if(key == 'inativas'){

 					$.each(item, function(key4,value3) {
						 htmlMessagem += '<div class="alert pv alert-dismissible fade in" role="alert">';
						 htmlMessagem += '	 <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>';
						 htmlMessagem += '	 	<ul class="ano">';
						 htmlMessagem += '	 	<a href="/profile/'+value3['nickname']+'">';
		                 htmlMessagem += '	 		<li class="anp" style="vertical-align: 0"><img class="cu" src="/uploads/avatars/'+value3['avatar']+'"></li>';
		                 htmlMessagem += '	 		<li style="display: inline-block"><small>'+value3['nickname']+'</small></li>';                 
		                 htmlMessagem += '	 	</a>';
		                 htmlMessagem += '	 	</ul>';
						 htmlMessagem += '	 <p>'+value3['message']+'</p>';
						 if(value3['link'] != ''){
						 	htmlMessagem += '	 <div class="aoa"><a class="cg ts fx" onClick="'+value3['link']+'">ver</a></div>';
						 }
						 htmlMessagem += ' </div>';
					});
					$("#app-growl").html(htmlMessagem);
				}
				
 			});

			htmlMessagemModal += '</ul>';	 		
 			$("#corpoModalNotification").html(htmlMessagemModal);				
			
 		}else{
			$("#app-growl").html('');
 		}
	});	
}

/*=======================================================================================================*/
