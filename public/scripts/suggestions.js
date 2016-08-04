function setaDadosModalSugestao(id, texto){
    $('#tituloTarefaSugestao').html(texto);
    $('#idTarefaSugestao').val(id);   
    getSuggestion(id);
}




function getSuggestion(tarefa_id){

    $.post("/tarefa/getSuggestion", {tarefa_id: tarefa_id}, function(result){  
               
        $("#divInputSugestao").html('<input type="text" id="sugestao" class="form-control" placeholder="Write your menssage">');
   
        var json = jQuery.parseJSON(result);
        
        var htmlBody = '<ul class="qo aob">';

        var texto = '';

        $.each(json, function(key,item) {    
            
            if(item['statusTarefa'] != "A"){
                $("#divInputSugestao").html('');
            }

            if((key+1) == json.length){
                texto  += item['texto'];             
                if(item['isOwner']){                    
                    htmlBody += '<li class="qf aoe alu">';
                    htmlBody += '    <div class="qg">';
                    htmlBody += '      <div class="aoc">'+texto+'</div>';
                    htmlBody += '      <div class="aod"><small class="dp"><a href="/profile/'+item['nickname']+'">'+item['name']+'</a> at '+item['data']+'</small></div>';
                    htmlBody += '    </div>';
                    htmlBody += '    <a class="qi" href="#"><img class="cu qh" src="/uploads/avatars/'+item['avatar']+'"></a>';
                    htmlBody += '</li>';
                }else{
                    htmlBody += '<li class="qf alu">';
                    htmlBody += '    <a class="qj" href="/profile/'+item['nickname']+'"><img class="cu qh" src="/uploads/avatars/'+item['avatar']+'"></a>';
                    htmlBody += '      <div class="qg">';
                    htmlBody += '           <div class="aoc">'+texto+'</div>';
                    htmlBody += '           <div class="aod"><small class="dp"><a href="/profile/'+item['nickname']+'">'+item['name']+'</a> at '+item['data']+'</small></div>';
                    htmlBody += '    </div>';
                    htmlBody += '</li>';                        
                }
            }else{
                if(json[key+1]['id_usuario'] != item['id_usuario']){    
                    texto  += item['texto'];                                
                    if(item['isOwner']){
                        htmlBody += '<li class="qf aoe alu">';
                        htmlBody += '    <div class="qg">';
                        htmlBody += '      <div class="aoc">'+texto+'</div>';
                        htmlBody += '      <div class="aod"><small class="dp"><a href="/profile/'+item['nickname']+'">'+item['name']+'</a> at '+item['data']+'</small></div>';
                        htmlBody += '    </div>';
                        htmlBody += '    <a class="qi" href="#"><img class="cu qh" src="/uploads/avatars/'+item['avatar']+'"></a>';
                        htmlBody += '</li>';
                    }else{
                        htmlBody += '<li class="qf alu">';
                        htmlBody += '    <a class="qj" href="/profile/'+item['nickname']+'"><img class="cu qh" src="/uploads/avatars/'+item['avatar']+'"></a>';
                        htmlBody += '      <div class="qg">';
                        htmlBody += '           <div class="aoc">'+texto+'</div>';
                        htmlBody += '           <div class="aod"><small class="dp"><a href="/profile/'+item['nickname']+'">'+item['name']+'</a> at '+item['data']+'</small></div>';
                        htmlBody += '    </div>';
                        htmlBody += '</li>';                        
                    }
                    texto = '';
                }else{                                      
                    texto  += item['texto'] + '<br>';                    
                }
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

            $.post("/tarefa/suggestion", {tarefa_id: tarefa_id, texto: texto}, function(result){  
               
                var json = jQuery.parseJSON(result);
                
                var htmlBody = '<ul class="qo aob">';
                var texto = '';
                $.each(json, function(key,item) {                    
                    if((key+1) == json.length){
                        texto  += item['texto'];             
                        if(item['isOwner']){                    
                            htmlBody += '<li class="qf aoe alu">';
                            htmlBody += '    <div class="qg">';
                            htmlBody += '      <div class="aoc">'+texto+'</div>';
                            htmlBody += '      <div class="aod"><small class="dp"><a href="/profile/'+item['nickname']+'">'+item['name']+'</a> at '+item['data']+'</small></div>';
                            htmlBody += '    </div>';
                            htmlBody += '    <a class="qi" href="#"><img class="cu qh" src="/uploads/avatars/'+item['avatar']+'"></a>';
                            htmlBody += '</li>';
                        }else{
                            htmlBody += '<li class="qf alu">';
                            htmlBody += '    <a class="qj" href="/profile/'+item['nickname']+'"><img class="cu qh" src="/uploads/avatars/'+item['avatar']+'"></a>';
                            htmlBody += '      <div class="qg">';
                            htmlBody += '           <div class="aoc">'+texto+'</div>';
                            htmlBody += '           <div class="aod"><small class="dp"><a href="/profile/'+item['nickname']+'">'+item['name']+'</a> at '+item['data']+'</small></div>';
                            htmlBody += '    </div>';
                            htmlBody += '</li>';                        
                        }
                    }else{
                        if(json[key+1]['id_usuario'] != item['id_usuario']){    
                            texto  += item['texto'];                               
                            if(item['isOwner']){
                                htmlBody += '<li class="qf aoe alu">';
                                htmlBody += '    <div class="qg">';
                                htmlBody += '      <div class="aoc">'+texto+'</div>';
                                htmlBody += '      <div class="aod"><small class="dp"><a href="/profile/'+item['nickname']+'">'+item['name']+'</a> at '+item['data']+'</small></div>';
                                htmlBody += '    </div>';
                                htmlBody += '    <a class="qi" href="#"><img class="cu qh" src="/uploads/avatars/'+item['avatar']+'"></a>';
                                htmlBody += '</li>';
                            }else{
                                htmlBody += '<li class="qf alu">';
                                htmlBody += '    <a class="qj" href="/profile/'+item['nickname']+'"><img class="cu qh" src="/uploads/avatars/'+item['avatar']+'"></a>';
                                htmlBody += '      <div class="qg">';
                                htmlBody += '           <div class="aoc">'+texto+'</div>';
                                htmlBody += '           <div class="aod"><small class="dp"><a href="/profile/'+item['nickname']+'">'+item['name']+'</a> at '+item['data']+'</small></div>';
                                htmlBody += '    </div>';
                                htmlBody += '</li>';                        
                            }
                            texto = '';
                        }else{                                      
                            texto  += item['texto'] + '<br>';             
                        }
                    }
                });    
                
                htmlBody += '</ul>';
                $('#corpoTarefaSugestao').html(htmlBody);
                                   
            });
        }

        var messageHome = $('#messageHome').val(); 
        if(messageHome.length > 3){
            $('#radioStatusPublico').prop('checked', true);            
            $('#msgModalMessage').modal('show');   
        }   
    }
});

