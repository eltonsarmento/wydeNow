function setaDadosModalSugestaoNotification(id, texto, notification_id){
    $('#tituloTarefaSugestao').html(texto);
    $('#idTarefaSugestao').val(id);   


    /*Alterar o status da notificação para Visualizado*/    
    setStatusNotification(notification_id,'V');

    /*Pega as sugestões para aquela notificação*/
    getSuggestion(id);

    /*Fechar o modal de notificações caso ele estaja aberto*/
    $('#msgModalNotification').modal('hide');
}

function setStatusNotification(id,status){
	$.post("/notification/setStatus", {id: id, status: status}, function(result){});
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

 			$.each(json, function(key,item) {

 				if(key == 'ativas'){
 					var cont = 0;

 					if(item[0]['total'] != 0){
 						htmlMessagemAtivas = '<ul class="qo cj ca">';
	 					$.each(item, function(key2,value) { 						
	 						cont++;
							htmlMessagemAtivas += '<li class="b">';
							htmlMessagemAtivas += ' 	<div class="qf">';
							htmlMessagemAtivas += ' 		<a class="qj" href="/profile/'+value['nickname']+'">';
							htmlMessagemAtivas += ' 			<img class="qh cu" src="/uploads/avatars/'+value['avatar']+'">';
							htmlMessagemAtivas += ' 		</a>';
							htmlMessagemAtivas += ' 		<div class="qg">';
							if(value['link'] != ''){
							 	htmlMessagemAtivas += '	 		<button class="cg ts fx eg" onClick="'+value['link']+'">ver</button>';
							}
							htmlMessagemAtivas += ' 			<strong>'+value['name']+'</strong>';
							htmlMessagemAtivas += ' 			<small>'+value['nickname']+'</small><br>';
							htmlMessagemAtivas += ' 			<small>'+value['message']+'</small><br>';
							htmlMessagemAtivas += ' 			<small>'+value['data']+'</small><br>';
							htmlMessagemAtivas += ' 		</div>';
							htmlMessagemAtivas += ' 	</div>';
							htmlMessagemAtivas += '</li>';
						
	 					});
	 					htmlMessagemAtivas += '</ul>';
	 					
	 					$("#corpoModalNotification").html(htmlMessagemAtivas);
	 					$("#divNumberNotification").html('('+cont+')');
 					}else{
 						$("#divNumberNotification").html('');
 					}
 				}else if(key == 'inativas'){
 					$.each(item, function(key3,value2) {
						 htmlMessagem += '<div class="alert pv alert-dismissible fade in" role="alert">';
						 htmlMessagem += '	 <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>';
						 htmlMessagem += '	 	<ul class="ano">';
						 htmlMessagem += '	 	<a href="/profile/'+value2['nickname']+'">';
		                 htmlMessagem += '	 		<li class="anp" style="vertical-align: 0"><img class="cu" src="/uploads/avatars/'+value2['avatar']+'"></li>';
		                 htmlMessagem += '	 		<li style="display: inline-block"><small>'+value2['nickname']+'</small></li>';                 
		                 htmlMessagem += '	 	</a>';
		                 htmlMessagem += '	 	</ul>';
						 htmlMessagem += '	 <p>'+value2['message']+'</p>';
						 if(value2['link'] != ''){
						 	htmlMessagem += '	 <div class="aoa"><a class="cg ts fx" onClick="'+value2['link']+'">ver</a></div>';
						 }
						 htmlMessagem += ' </div>';
					});
					$("#app-growl").html(htmlMessagem);
				}
 			});
 			
 		}else{
			$("#app-growl").html('');
 		}
	});	
}

/*=======================================================================================================*/
