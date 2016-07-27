function setaDadosModalSugestao(id, texto){
    $('#tituloTarefaSugestao').html(texto);
    $('#idTarefaSugestao').val(id);   



    $.post("/tarefa/getSuggestion/", {tarefa_id: id}, function(result){  
               
        var json = jQuery.parseJSON(result);
        
        var htmlBody = '<ul class="qo aob">';

        $.each(json, function(key,item) {
            if(item['isOwner']){

                htmlBody += '<li class="qf aoe alu">';
                htmlBody += '    <div class="qg">';
                htmlBody += '      <div class="aoc">'+item['texto']+'</div>';
                htmlBody += '      <div class="aod"><small class="dp"><a href="/profile/'+item['nickname']+'">'+item['name']+'</a> at '+item['data']+'</small></div>';
                htmlBody += '    </div>';
                htmlBody += '    <a class="qi" href="#"><img class="cu qh" src="/uploads/avatars/'+item['avatar']+'"></a>';
                htmlBody += '</li>';
            }else{
                htmlBody += '<li class="qf alu">';
                htmlBody += '    <a class="qj" href="/profile/'+item['nickname']+'"><img class="cu qh" src="/uploads/avatars/'+item['avatar']+'"></a>';
                htmlBody += '      <div class="qg">';
                htmlBody += '           <div class="aoc">'+item['texto']+'</div>';
                htmlBody += '           <div class="aod"><small class="dp"><a href="/profile/'+item['nickname']+'">'+item['name']+'</a> at '+item['data']+'</small></div>';
                htmlBody += '    </div>';
                htmlBody += '</li>';                        
            }
        });    
        
        htmlBody += '</ul>';
        $('#corpoTarefaSugestao').html(htmlBody);   
        $('#msgModalSugestao').modal('toggle');               
    });
}

$(document).keypress(function(e) {
    if(e.which == 13){
        var texto = $('#sugestao').val();        
        var tarefa_id  = $('#idTarefaSugestao').val(); 
        if(texto.length > 3){            
            $('#sugestao').val('');

            $.post("/tarefa/sugestao/", {tarefa_id: tarefa_id, texto: texto}, function(result){  
               
                var json = jQuery.parseJSON(result);
                
                var htmlBody = '<ul class="qo aob">';

                $.each(json, function(key,item) {
                    
                    if(item['isOwner']){
		                htmlBody += '<li class="qf aoe alu">';
		                htmlBody += '    <div class="qg">';
		                htmlBody += '      <div class="aoc">'+item['texto']+'</div>';
		                htmlBody += '      <div class="aod"><small class="dp"><a href="/profile/'+item['nickname']+'">'+item['name']+'</a> at '+item['data']+'</small></div>';
		                htmlBody += '    </div>';
		                htmlBody += '    <a class="qi" href="#"><img class="cu qh" src="/uploads/avatars/'+item['avatar']+'"></a>';
		                htmlBody += '</li>';
		            }else{
		                htmlBody += '<li class="qf alu">';
		                htmlBody += '    <a class="qj" href="/profile/'+item['nickname']+'"><img class="cu qh" src="/uploads/avatars/'+item['avatar']+'"></a>';
		                htmlBody += '      <div class="qg">';
		                htmlBody += '           <div class="aoc">'+item['texto']+'</div>';
		                htmlBody += '           <div class="aod"><small class="dp"><a href="/profile/'+item['nickname']+'">'+item['name']+'</a> at '+item['data']+'</small></div>';
		                htmlBody += '    </div>';
		                htmlBody += '</li>';                        
		            }
                });    
                
                htmlBody += '</ul>';
                $('#corpoTarefaSugestao').html(htmlBody);
                                   
            });
        }
    }
});