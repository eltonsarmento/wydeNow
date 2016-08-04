$.ajaxSetup({  
  headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});



/************************************* CONCLUIR TAREFA *******************************************************/
 /*Setar Modal Concluir*/
    function setaDadosModalConcluir(id,texto){            
        $('#msgModalConcluirCampoTextoTarefa').html(texto);
        $('#idTarefaConcluir').val(id);    
    }
    
    /*Botão Concluir*/
    $('#btnConcluirModalConcluir').click(function(){                      
        var idTarefa = $('#idTarefaConcluir').val(); 

        $.post("/tarefa/concluir", {id: idTarefa}, function(result){            
            
            var json = jQuery.parseJSON(result);

            var htmlAtivas     = '';
            var htmlConcluidas = '';

            $.each(json, function(key,value) {
                if(key == 'tarefasAtivas'){
                    htmlAtivas += ' <ol class="dd-list">';
                     $.each(value, function(key2,item) {
                        htmlAtivas += ' <li class="b qf aml dd-item dd3-item" data-id="'+item['id']+'">';
                        htmlAtivas += '   <div class="qj dd-handles dd3-handles">';
                        htmlAtivas += '     <span class="h';
                        if(item['isdoit']) 
                            htmlAtivas += ' ajw ">';
                        else if(item['privado']) 
                            htmlAtivas += ' adw ">';                                            
                        else
                            htmlAtivas += ' abv ">';                                                                    
                        
                        htmlAtivas += '     </span>';
                        htmlAtivas += '   </div>';
                        htmlAtivas += '   <div class="qg">';   
                        htmlAtivas += '      <small class="eg dp">'+item['tempoCadastada']+'</small>';
                        htmlAtivas += '       <a href="#"><strong>'+item['texto']+'</strong></a>';
                        htmlAtivas += '   </div>';

                        if(item['isdoit']) {
                            htmlAtivas += '   <div class="panel panel-default panel-link-list">';
                            htmlAtivas += '     <div class="panel-body">';
                            htmlAtivas += '         <a data-toggle="modal" href="#msgModalCancelarDoIt" style="margin-right: 10px;" onclick="setaDadosModalCancelarDoIt('+item['id']+',\''+item['texto']+'\'); return false;"><span class="h ya"></span> Cancelar</a>';
                            htmlAtivas += "         <a  onClick='setaDadosModalSugestao("+item['id']+",\'"+item['texto']+"\'); return false;' style='margin-right: 10px;'><span class='h xk'></span> Sugestões</a>";
                            htmlAtivas += '         <a data-toggle="modal" href="#msgModalConcluir" onClick="setaDadosModalConcluir('+item['id']+',\''+item['texto']+'\'); return false;"><span class="h xl"></span> Concluir</a>';  
                            htmlAtivas += '     </div>';
                            htmlAtivas += '   </div>';
                            htmlAtivas += '   <ul class="ano">';
                            htmlAtivas += '     <li class="anp" style="vertical-align: 0">';
                            htmlAtivas += '         <img class="cu" src="/uploads/avatars/'+item['avatar']+'">';
                            htmlAtivas += '     </li>';
                            htmlAtivas += '     <li style="display: inline-block"><small>'+item['nickname']+'</small></li>';
                            htmlAtivas += '   </ul>';
                            htmlAtivas += '</li>';
                        }else{
                            htmlAtivas += '   <div class="panel panel-default panel-link-list">';
                            htmlAtivas += '     <div class="panel-body">';
                            htmlAtivas += '         <a data-toggle="modal" href="#msgModalCancelar" style="margin-right: 10px;" onclick="setaDadosModalCancelar('+item['id']+',\''+item['texto']+'\'); return false;"><span class="h ya"></span> Cancelar</a>';                            
                            htmlAtivas += "         <a  onClick='setaDadosModalSugestao("+item['id']+",\'"+item['texto']+"\'); return false;' style='margin-right: 10px;'><span class='h xk'></span> Sugestões</a>";
                            htmlAtivas += '         <a data-toggle="modal" href="#msgModalConcluir" onClick="setaDadosModalConcluir('+item['id']+',\''+item['texto']+'\'); return false;"><span class="h xl"></span> Concluir</a>';  
                            htmlAtivas += '     </div>';
                            htmlAtivas += '   </div>';
                            htmlAtivas += '</li>';  
                        }
                     });
                    htmlAtivas += '</ol>';  
                }else if(key == 'tarefasConcluidas'){
                    $.each(value, function(key3,item2) {
                        htmlConcluidas +='  <li class="b qf aml" >';
                        htmlConcluidas +='    <div class="qj ">';
                        htmlConcluidas +='      <span class="h'; 
                        if(item2['isdoit']) {
                            htmlConcluidas += ' ajw ">';
                        }else if(item2['privado']){
                            htmlConcluidas += ' adw">';
                        }else{
                            htmlConcluidas += ' abv">';
                        }
                        htmlConcluidas +='      </span>';
                        htmlConcluidas +='    </div>';
                        htmlConcluidas +='  <div class="qg">';
                        htmlConcluidas +='      <small class="eg dp">'+item2['tempoCadastada']+'</small>';
                        htmlConcluidas +='      <strike>'+item2['texto']+'</strike>';
                        htmlConcluidas +='  </div>';

                        if(item2['isdoit']) {                            
                            if(item2['hasSuggestion']){
                                htmlConcluidas += '   <div class="panel panel-default panel-link-list">';
                                htmlConcluidas += '     <div class="panel-body">';
                                htmlConcluidas += '         <a  onClick="setaDadosModalSugestao('+item2['id']+',\''+item2['texto']+'\'); return false;" style="margin-right: 10px;"><span class="h xk"></span> Sugestões</a>';
                                htmlConcluidas += '     </div>';
                                htmlConcluidas += '   </div>';
                            }
                            htmlConcluidas += '   <ul class="ano">';
                            htmlConcluidas += '     <li class="anp" style="vertical-align: 0">';
                            htmlConcluidas += '         <img class="cu" src="/uploads/avatars/'+item2['avatar']+'">';
                            htmlConcluidas += '     </li>';
                            htmlConcluidas += '     <li style="display: inline-block"><small>'+item2['nickname']+'</small></li>';
                            htmlConcluidas += '   </ul>';
                            htmlConcluidas += '</li>';
                        }else{
                            if(item2['hasSuggestion']){
                                htmlConcluidas += '   <div class="panel panel-default panel-link-list">';
                                htmlConcluidas += '     <div class="panel-body">';
                                htmlConcluidas += '         <a  onClick="setaDadosModalSugestao('+item2['id']+',\''+item2['texto']+'\'); return false;" style="margin-right: 10px;"><span class="h xk"></span> Sugestões</a>';
                                htmlConcluidas += '     </div>';
                                htmlConcluidas += '   </div>';
                            }
                            htmlConcluidas += '</li>';  
                        }
                    })
                }
            });
            $('#returnListaAtivas').html(htmlAtivas);
            $('#returnListaConcluidas').html(htmlConcluidas);
            $('#msgModalConcluir').modal('toggle');
            
            limpaCamposModal('Concluir');
        });
    });

    /*Botão Concluir*/
    $('#btnConcluirModalConcluirByFilter').click(function(){                      
        var idTarefa = $('#idTarefaConcluir').val(); 

        $.post("/tarefa/concluirByFilter", {id: idTarefa}, function(result){            
            
            var json = jQuery.parseJSON(result);

            var htmlAtivas     = '';
            var htmlConcluidas = '';

            $.each(json, function(key,value) {
                if(key == 'tarefasAtivas'){
                    htmlAtivas += ' <ol class="dd-list">';
                     $.each(value, function(key2,item) {
                        htmlAtivas += ' <li class="b qf aml dd-item dd3-item" data-id="'+item['id']+'">';
                        htmlAtivas += '   <div class="qj dd-handles dd3-handles">';
                        htmlAtivas += '     <span class="h';
                        if(item['isdoit']) 
                            htmlAtivas += ' ajw ">';
                        else if(item['privado']) 
                            htmlAtivas += ' adw ">';                                            
                        else
                            htmlAtivas += ' abv ">';                                                                    
                        
                        htmlAtivas += '     </span>';
                        htmlAtivas += '   </div>';
                        htmlAtivas += '   <div class="qg">';   
                        htmlAtivas += '      <small class="eg dp">'+item['tempoCadastada']+'</small>';
                        htmlAtivas += '       <a href="#"><strong>'+item['texto']+'</strong></a>';
                        htmlAtivas += '   </div>';

                        if(item['isdoit']) {
                            htmlAtivas += '   <div class="panel panel-default panel-link-list">';
                            htmlAtivas += '     <div class="panel-body">';
                            htmlAtivas += '         <a data-toggle="modal" href="#msgModalCancelarDoIt" style="margin-right: 10px;" onclick="setaDadosModalCancelarDoIt('+item['id']+',\''+item['texto']+'\'); return false;"><span class="h ya"></span> Cancelar</a>';
                            htmlAtivas += "         <a  onClick='setaDadosModalSugestao("+item['id']+",\'"+item['texto']+"\'); return false;' style='margin-right: 10px;'><span class='h xk'></span> Sugestões</a>";
                            htmlAtivas += '         <a data-toggle="modal" href="#msgModalConcluir" onClick="setaDadosModalConcluir('+item['id']+',\''+item['texto']+'\'); return false;"><span class="h xl"></span> Concluir</a>';  
                            htmlAtivas += '     </div>';
                            htmlAtivas += '   </div>';
                            htmlAtivas += '   <ul class="ano">';
                            htmlAtivas += '     <li class="anp" style="vertical-align: 0">';
                            htmlAtivas += '         <img class="cu" src="/uploads/avatars/'+item['avatar']+'">';
                            htmlAtivas += '     </li>';
                            htmlAtivas += '     <li style="display: inline-block"><small>'+item['nickname']+'</small></li>';
                            htmlAtivas += '   </ul>';
                            htmlAtivas += '</li>';
                        }else{
                            htmlAtivas += '   <div class="panel panel-default panel-link-list">';
                            htmlAtivas += '     <div class="panel-body">';
                            htmlAtivas += '         <a data-toggle="modal" href="#msgModalCancelar" style="margin-right: 10px;" onclick="setaDadosModalCancelar('+item['id']+',\''+item['texto']+'\'); return false;"><span class="h ya"></span> Cancelar</a>';                            
                            htmlAtivas += "         <a  onClick='setaDadosModalSugestao("+item['id']+",\'"+item['texto']+"\'); return false;' style='margin-right: 10px;'><span class='h xk'></span> Sugestões</a>";
                            htmlAtivas += '         <a data-toggle="modal" href="#msgModalConcluir" onClick="setaDadosModalConcluir('+item['id']+',\''+item['texto']+'\'); return false;"><span class="h xl"></span> Concluir</a>';  
                            htmlAtivas += '     </div>';
                            htmlAtivas += '   </div>';
                            htmlAtivas += '</li>';  
                        }
                     });
                    htmlAtivas += '</ol>';  
                }
            });
            $('#returnListaAtivas').html(htmlAtivas);
            $('#msgModalConcluir').modal('toggle');
            
            limpaCamposModal('Concluir');
        });
    });
    
    /*Botão Concluir*/
    function limpaCamposModal(tipo){                      
        if(tipo == 'Concluir'){
            $('#msgModalConcluirCampoTextoTarefa').html('');
            $('#idTarefaConcluir').val(''); 
        }else if(tipo == 'Cancelar'){
            $('#msgModalCancelarCampoTextoTarefa').html('');
            $('#idTarefaCancelar').val(''); 
        }else if(tipo == 'Recusar'){
            $('#msgModalRecusarCampoTextoTarefaDoIt').html('');
            $('#idTarefaRecusarDoIt').val('');   
        }else if(tipo == 'Excluir'){
            $('#msgModalExcluirCampoTextoTarefaDoIt').html('');
            $('#idTarefaExcluirDoIt').val('');   
        }
        
    };
/************************************* CONCLUIR TAREFA *******************************************************/


/************************************* CANCELAR, RECUSAR E  EXCLUIR : TAREFA *******************************************************/
/*Setar Modal Concluir*/
function setaDadosModalCancelar(id,texto){        
    $('#msgModalCancelarCampoTextoTarefa').html(texto);
    $('#idTarefaCancelar').val(id);   
}
function setaDadosModalRecusarDoIt(id,texto){        
    $('#msgModalRecusarCampoTextoTarefaDoIt').html(texto);
    $('#idTarefaRecusarDoIt').val(id);   
}
function setaDadosModalExcluirDoIt(id,texto){        
    $('#msgModalExcluirCampoTextoTarefaDoIt').html(texto);
    $('#idTarefaExcluirDoIt').val(id);   
}

/*Botão Cancelar*/
$('#btnContinueModalCancelar').click(function(){                      
    var idTarefa = $('#idTarefaCancelar').val(); 

    $.post("/tarefa/remover", {id: idTarefa}, function(result){            
        var json = jQuery.parseJSON(result);
        var htmlAtivas     = '';
        var htmlConcluidas = '';

        $.each(json, function(key,value) {
            if(key == 'tarefasAtivas'){
                htmlAtivas += ' <ol class="dd-list">';
                 $.each(value, function(key2,item) {
                    htmlAtivas += ' <li class="b qf aml dd-item dd3-item" data-id="'+item['id']+'">';
                    htmlAtivas += '   <div class="qj dd-handles dd3-handles">';
                    htmlAtivas += '     <span class="h';
                    if(item['privado']) 
                        htmlAtivas += ' adw ">';                                            
                    else
                        htmlAtivas += ' abv ">';                                                                    
                    
                    htmlAtivas += '     </span>';
                    htmlAtivas += '   </div>';
                    htmlAtivas += '   <div class="qg">';   
                    htmlAtivas += '      <small class="eg dp">'+item['tempoCadastada']+'</small>';
                    htmlAtivas += '       <a href="#"><strong>'+item['texto']+'</strong></a>';
                    htmlAtivas += '   </div>';
                    htmlAtivas += '   <div class="panel panel-default panel-link-list">';
                    htmlAtivas += '     <div class="panel-body">';
                    htmlAtivas += '         <a data-toggle="modal" href="#msgModalCancelar" style="margin-right: 10px;" onclick="setaDadosModalCancelar('+item['id']+',\''+item['texto']+'\'); return false;"><span class="h ya"></span> Cancelar</a>';                    
                    htmlAtivas += '         <a  onClick="setaDadosModalSugestao('+item['id']+',\''+item['texto']+'\'); return false;" style="margin-right: 10px;"><span class="h xk"></span> Sugestões</a>';
                    htmlAtivas += '         <a data-toggle="modal" href="#msgModalConcluir" onClick="setaDadosModalConcluir('+item['id']+',\''+item['texto']+'\'); return false;"><span class="h xl"></span> Concluir</a>';  
                    htmlAtivas += '     </div>';
                    htmlAtivas += '   </div>';

                    if(item['isdoit']) {
                        htmlAtivas += '   <ul class="ano">';
                        htmlAtivas += '     <li class="anp" style="vertical-align: 0">';
                        htmlAtivas += '         <img class="cu" src="/uploads/avatars/'+item['avatar']+'">';
                        htmlAtivas += '     </li>';
                        htmlAtivas += '     <li style="display: inline-block"><small>'+item['nickname']+'</small></li>';
                        htmlAtivas += '   </ul>';
                    }
                    htmlAtivas += '</li>';  
                 });
                htmlAtivas += '</ol>';  
            }else if(key == 'tarefasConcluidas'){
                $.each(value, function(key3,item2) {
                    htmlConcluidas +='  <li class="b qf aml" >';
                    htmlConcluidas +='    <div class="qj ">';
                    htmlConcluidas +='      <span class="h'; 

                    if(item2['privado']){
                        htmlConcluidas += ' adw">';
                    }else{
                        htmlConcluidas += ' abv">';
                    }
                    htmlConcluidas +='      </span>';
                    htmlConcluidas +='    </div>';
                    htmlConcluidas +='  <div class="qg">';
                    htmlConcluidas +='      <small class="eg dp">'+item2['tempoCadastada']+'</small>';
                    htmlConcluidas +='      <strike>'+item2['texto']+'</strike>';
                    htmlConcluidas +='  </div>';
                    htmlConcluidas +='  <div class="panel panel-default panel-link-list">';
                    htmlConcluidas +='      <div class="panel-body">';                                        
                    htmlConcluidas += '         <a  onClick="setaDadosModalSugestao('+item2['id']+',\''+item2['texto']+'\'); return false;" style="margin-right: 10px;"><span class="h xk"></span> Sugestões</a>';
                    htmlConcluidas +='      </div>';
                    htmlConcluidas +='  </div>';
                    if(item2['isdoit']) {
                        htmlConcluidas += '   <ul class="ano">';
                        htmlConcluidas += '     <li class="anp" style="vertical-align: 0">';
                        htmlConcluidas += '         <img class="cu" src="/uploads/avatars/'+item2['avatar']+'">';
                        htmlConcluidas += '     </li>';
                        htmlConcluidas += '     <li style="display: inline-block"><small>'+item2['nickname']+'</small></li>';
                        htmlConcluidas += '   </ul>';
                    }
                    htmlConcluidas +='</li> ';
                })
            }
        });
        $('#returnListaAtivas').html(htmlAtivas);
        $('#returnListaConcluidas').html(htmlConcluidas);
        $('#msgModalCancelar').modal('toggle');    
        limpaCamposModal('Cancelar');
    });
});
/*Botão Recusar*/
$('#btnContinueModalRecusarDoIt').click(function(){                      
    var idTarefa = $('#idTarefaRecusarDoIt').val(); 

    $.post("/tarefa/recusardoit", {id: idTarefa}, function(result){            
        var json = jQuery.parseJSON(result);

        var htmlAtivas     = '';
        var htmlConcluidas = '';

        $.each(json, function(key,value) {
            if(key == 'tarefasAtivas'){
                htmlAtivas += ' <ol class="dd-list">';
                 $.each(value, function(key2,item) {
                    htmlAtivas += ' <li class="b qf aml dd-item dd3-item" data-id="'+item['id']+'">';
                    htmlAtivas += '   <div class="qj dd-handles dd3-handles">';
                    htmlAtivas += '     <span class="h';
                    if(item['isdoit']) 
                        htmlAtivas += ' ajw ">';
                    else if(item['privado']) 
                        htmlAtivas += ' adw ">';                                            
                    else
                        htmlAtivas += ' abv ">';                                                                    
                    
                    htmlAtivas += '     </span>';
                    htmlAtivas += '   </div>';
                    htmlAtivas += '   <div class="qg">';   
                    htmlAtivas += '      <small class="eg dp">'+item['tempoCadastada']+'</small>';
                    htmlAtivas += '       <a href="#"><strong>'+item['texto']+'</strong></a>';
                    htmlAtivas += '   </div>';
                    if(item['isdoit']) {
                        htmlAtivas += '   <div class="panel panel-default panel-link-list">';
                        htmlAtivas += '     <div class="panel-body">';
                        htmlAtivas += '         <a data-toggle="modal" href="#msgModalCancelarDoIt" style="margin-right: 10px;" onclick="setaDadosModalCancelarDoIt('+item['id']+',\''+item['texto']+'\'); return false;"><span class="h ya"></span> Cancelar</a>';                                                
                        htmlAtivas += '         <a  onClick="setaDadosModalSugestao('+item['id']+',\''+item['texto']+'\'); return false;" style="margin-right: 10px;"><span class="h xk"></span> Sugestões</a>';
                        htmlAtivas += '         <a data-toggle="modal" href="#msgModalConcluir" onClick="setaDadosModalConcluir('+item['id']+',\''+item['texto']+'\'); return false;"><span class="h xl"></span> Concluir</a>';  
                        htmlAtivas += '     </div>';
                        htmlAtivas += '   </div>';
                        htmlAtivas += '   <ul class="ano">';
                        htmlAtivas += '     <li class="anp" style="vertical-align: 0">';
                        htmlAtivas += '         <img class="cu" src="/uploads/avatars/'+item['avatar']+'">';
                        htmlAtivas += '     </li>';
                        htmlAtivas += '     <li style="display: inline-block"><small>'+item['nickname']+'</small></li>';
                        htmlAtivas += '   </ul>';
                        htmlAtivas += '</li>';
                    }else{
                        htmlAtivas += '   <div class="panel panel-default panel-link-list">';
                        htmlAtivas += '     <div class="panel-body">';
                        htmlAtivas += '         <a data-toggle="modal" href="#msgModalCancelar" style="margin-right: 10px;" onclick="setaDadosModalCancelar('+item['id']+',\''+item['texto']+'\'); return false;"><span class="h ya"></span> Cancelar</a>';
                        htmlAtivas += '         <a  onClick="setaDadosModalSugestao('+item['id']+',\''+item['texto']+'\'); return false;" style="margin-right: 10px;"><span class="h xk"></span> Sugestões</a>';
                        htmlAtivas += '         <a data-toggle="modal" href="#msgModalConcluir" onClick="setaDadosModalConcluir('+item['id']+',\''+item['texto']+'\'); return false;"><span class="h xl"></span> Concluir</a>';  
                        htmlAtivas += '     </div>';
                        htmlAtivas += '   </div>';
                        htmlAtivas += '</li>';  
                    }
                 });
                htmlAtivas += '</ol>';  
            }else if(key == 'tarefasConcluidas'){
                $.each(value, function(key3,item2) {
                    htmlConcluidas +='  <li class="b qf aml" >';
                    htmlConcluidas +='    <div class="qj ">';
                    htmlConcluidas +='      <span class="h'; 
                    if(item2['isdoit']){
                        htmlConcluidas += ' ajw ">';
                    }else if(item2['privado']){
                        htmlConcluidas += ' adw">';
                    }else{
                        htmlConcluidas += ' abv">';
                    }
                    htmlConcluidas +='      </span>';
                    htmlConcluidas +='    </div>';
                    htmlConcluidas +='  <div class="qg">';
                    htmlConcluidas +='      <small class="eg dp">'+item2['tempoCadastada']+'</small>';
                    htmlConcluidas +='      <strike>'+item2['texto']+'</strike>';
                    htmlConcluidas +='  </div>';

                    if(item2['isdoit']) {
                        htmlConcluidas += '   <div class="panel panel-default panel-link-list">';
                        htmlConcluidas += '     <div class="panel-body">';                                                
                        htmlConcluidas += '         <a  onClick="setaDadosModalSugestao('+item2['id']+',\''+item2['texto']+'\'); return false;" style="margin-right: 10px;"><span class="h xk"></span> Sugestões</a>';
                        htmlConcluidas += '     </div>';
                        htmlConcluidas += '   </div>';
                        htmlConcluidas += '   <ul class="ano">';
                        htmlConcluidas += '     <li class="anp" style="vertical-align: 0">';
                        htmlConcluidas += '         <img class="cu" src="/uploads/avatars/'+item2['avatar']+'">';
                        htmlConcluidas += '     </li>';
                        htmlConcluidas += '     <li style="display: inline-block"><small>'+item2['nickname']+'</small></li>';
                        htmlConcluidas += '   </ul>';
                        htmlConcluidas += '</li>';
                    }else{
                        htmlConcluidas += '   <div class="panel panel-default panel-link-list">';
                        htmlConcluidas += '     <div class="panel-body">';
                        htmlConcluidas += '         <a  onClick="setaDadosModalSugestao('+item2['id']+',\''+item2['texto']+'\'); return false;" style="margin-right: 10px;"><span class="h xk"></span> Sugestões</a>';
                        htmlConcluidas += '     </div>';
                        htmlConcluidas += '   </div>';
                        htmlConcluidas += '</li>';  
                    }
                })
            }
        });
        $('#returnListaAtivas').html(htmlAtivas);
        $('#returnListaConcluidas').html(htmlConcluidas);
        $('#msgModalRecusarDoIt').modal('toggle');    
        limpaCamposModal('Recusar');
    });
});
/*Botão Excluir*/
$('#btnContinueModalExcluirDoIt').click(function(){                      
    var idTarefa = $('#idTarefaExcluirDoIt').val(); 

    $.post("/tarefa/removerdoit", {id: idTarefa}, function(result){            
        var json = jQuery.parseJSON(result);

        var htmlAtivas     = '';
        var htmlConcluidas = '';

        $.each(json, function(key,value) {
            if(key == 'tarefasAtivas'){
                htmlAtivas += ' <ol class="dd-list">';
                 $.each(value, function(key2,item) {
                    htmlAtivas += ' <li class="b qf aml dd-item dd3-item" data-id="'+item['id']+'">';
                    htmlAtivas += '   <div class="qj dd-handles dd3-handles">';

                    if(item['status'] == "A"){
                        htmlAtivas += '     <span class="h ajw "></span>';
                    }else if(item['status'] == "R"){
                        htmlAtivas += '     <span class="h ya"></span>'; 
                    }
                    htmlAtivas += '   </div>';
                    htmlAtivas += '   <div class="qg">';   
                    htmlAtivas += '      <small class="eg dp">'+item['tempoCadastada']+'</small>';

                    if(item['status'] == "A"){
                        htmlAtivas += '       <a href="#"><strong>'+item['texto']+'</strong></a>';
                    }else if(item['status'] == "R"){
                        htmlAtivas += '       <strike>'+item['texto']+'</strike> - RECUSADA';
                    }

                    htmlAtivas += '   </div>';                
                    htmlAtivas += '   <div class="panel panel-default panel-link-list">';
                    htmlAtivas += '     <div class="panel-body">';

                    if(item['status'] == "A"){                    
                        htmlAtivas += '         <a data-toggle="modal" href="#msgModalExcluirDoIt" style="margin-right: 10px;" onclick="setaDadosModalExcluirDoIt('+item['id']+',\''+item['texto']+'\'); return false;"><span class="h ya"></span> Excluir</a>';                    
                        htmlAtivas += '         <a  onClick="setaDadosModalSugestao('+item['id']+',\''+item['texto']+'\'); return false;" style="margin-right: 10px;"><span class="h xk"></span> Sugestões</a>';
                        htmlAtivas += '         <a data-toggle="modal" href="#msgModalConcluir" onClick="setaDadosModalConcluir('+item['id']+',\''+item['texto']+'\'); return false;"><span class="h xl"></span> Concluir</a>';  
                    }else if(item['status'] == "R"){
                        htmlAtivas += '    <a data-toggle="modal" href="#msgModalExcluirDoIt" style="margin-right: 10px;" onclick="setaDadosModalCancelar(\''+item['id']+'\',\''+item['texto']+'\'); return false;"><span class="h ya"></span> Excluir</a>';
                    }
                    htmlAtivas += '     </div>';
                    htmlAtivas += '   </div>';

                    
                    htmlAtivas += '   <ul class="ano">';
                    htmlAtivas += '     <li class="anp" style="vertical-align: 0">';
                    htmlAtivas += '         <img class="cu" src="/uploads/avatars/'+item['avatar']+'">';
                    htmlAtivas += '     </li>';
                    htmlAtivas += '     <li style="display: inline-block"><small>'+item['nickname']+'</small></li>';
                    htmlAtivas += '   </ul>';
                
                    htmlAtivas += '</li>';
                    

                 });
                htmlAtivas += '</ol>';  
            }else if(key == 'tarefasConcluidas'){
                $.each(value, function(key3,item2) {
                    htmlConcluidas +='  <li class="b qf aml" >';
                    htmlConcluidas +='    <div class="qj ">';
                    htmlConcluidas +='      <span class="h ajw "></span>';
                    htmlConcluidas +='    </div>';
                    htmlConcluidas +='  <div class="qg">';
                    htmlConcluidas +='      <small class="eg dp">'+item2['tempoCadastada']+'</small>';
                    htmlConcluidas +='      <strike>'+item2['texto']+'</strike>';
                    htmlConcluidas +='  </div>';                    
                    htmlConcluidas += '   <div class="panel panel-default panel-link-list">';
                    htmlConcluidas += '     <div class="panel-body">';                                         
                    htmlConcluidas += '         <a  onClick="setaDadosModalSugestao('+item2['id']+',\''+item2['texto']+'\'); return false;" style="margin-right: 10px;"><span class="h xk"></span> Sugestões</a>';
                    htmlConcluidas += '     </div>';
                    htmlConcluidas += '   </div>';
                    htmlConcluidas += '   <ul class="ano">';
                    htmlConcluidas += '     <li class="anp" style="vertical-align: 0">';
                    htmlConcluidas += '         <img class="cu" src="/uploads/avatars/'+item2['avatar']+'">';
                    htmlConcluidas += '     </li>';
                    htmlConcluidas += '     <li style="display: inline-block"><small>'+item2['nickname']+'</small></li>';
                    htmlConcluidas += '   </ul>';
                    htmlConcluidas += '</li>';                    
                })
            }
        });
        $('#returnListaAtivas').html(htmlAtivas);
        $('#returnListaConcluidas').html(htmlConcluidas);
        $('#msgModalExcluirDoIt').modal('toggle');    
        limpaCamposModal('Excluir');
    });
});
/************************************* CANCELAR TAREFA *******************************************************/


$(document).ready(function(){
	/*Botão Privado*/
	$('#privado').click(function(){                      
      if($('#isPrivado').val() == '1'){
        var texto = $('#texto').val();
        var textoSemPrivado = texto.replace("#privado", "");
        $('#texto').val(textoSemPrivado); 
        $('#isPrivado').val('0');        
        $('#privado').removeClass('fp');                
        $('#privado').addClass('tr');
      }else{
        $('#texto').val($('#texto').val() + " #privado");
        $('#isPrivado').val('1');
        $('#privado').removeClass('tr');                
        $('#privado').addClass('fp');        
      }
    });

	/*nestable*/
   var updateOutput = function(e){
        var list   = e.length ? e : $(e.target),
            output = list.data('output');
            
        var categoria = $('#categoriaSetada').val();

        if (window.JSON) {                    
            var response = window.JSON.stringify(list.nestable('serialize'));            
            var json = jQuery.parseJSON(response);

            var html = '';
            var array = '';
            $.each(json, function(key,value) {
                array += '{"id":'+value['id']+', "ordem":'+(key+1)+'},';
            });
            
            var novoJason = array.slice(0,array.length-1);
            var novoJason = '['+novoJason+']';
            
            $.post("/tarefa/prioridade/"+categoria, {json: novoJason}, function(result){                
                $('#tipoOrdenacaoReturn').html('Prioridade');
            });
            
        } else {
            output.val('JSON browser support required for this demo.');
        }
    };
    $('#nestable3').nestable().on('change', updateOutput);



    /*Excluir*/
});