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
setInterval("atualizarTimeline()", 30000);

verificaNotifications();
setInterval("verificaNotifications()", 10000);
function verificaNotifications(){
	$.get('notification/verificanotifications',  function (result) {
 		var json = jQuery.parseJSON(result);
 		if(json != ''){
 			var htmlMessagem = '';
 			$.each(json, function(key,value) {
				 htmlMessagem += '<div class="alert pv alert-dismissible fade in" role="alert">';
				 htmlMessagem += '	 <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>';
				 htmlMessagem += '	 <p>'+value['message']+'</p>';
				 htmlMessagem += ' </div>';
 			})
 			$("#app-growl").html(htmlMessagem);
 		}else{
			$("#app-growl").html('');
 		}
	});
	
}
