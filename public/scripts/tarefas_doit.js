$.ajaxSetup({  
  headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

/************************************* CONCLUIR TAREFA *******************************************************/    
    /*Botão Concluir*/
    function limpaCamposModal(tipo){                      
        if(tipo == 'Concluir'){
            $('#msgModalConcluirCampoTextoTarefa').html('');
            $('#idTarefaConcluir').val(''); 
        }else if(tipo == 'Cancelar'){
            $('#msgModalCancelarCampoTextoTarefa').html('');
            $('#idTarefaCancelar').val(''); 
        }
    };
/************************************* CONCLUIR TAREFA *******************************************************/


/************************************* CANCELAR TAREFA *******************************************************/
/*Setar Modal Concluir*/
function setaDadosModalCancelar(id,texto){        
    $('#msgModalCancelarCampoTextoTarefa').html(texto);
    $('#idTarefaCancelar').val(id);   
}

/*Botão Concluir*/
$('#btnContinueModalCancelar').click(function(){                      
    var idTarefa = $('#idTarefaCancelar').val(); 

    $.post("/tarefa/removerdoit", {id: idTarefa}, function(result){            
        var json = jQuery.parseJSON(result);

        var htmlAtivas     = '';
        var htmlConcluidas = '';

        $.each(json, function(key,value) {
            if(key == 'tarefasAtivas'){
                htmlAtivas += ' <ol class="dd-list">';
                 $.each(value, function(key2,item) {
                    alert(item['status']);
                    htmlAtivas += ' <li class="b qf aml dd-item dd3-item" data-id="'+item['id']+'">';
                    htmlAtivas += '   <div class="qj dd-handles dd3-handles">';

                    if(item['status'] == "A")
                        htmlAtivas += '     <span class="h ajw "></span>';                                                
                    if(item['status'] == "R")
                        htmlAtivas += '     <span class="h ya"></span>'; 

                    htmlAtivas += '   </div>';
                    htmlAtivas += '   <div class="qg">';   
                    htmlAtivas += '      <small class="eg dp">'+item['tempoCadastada']+'</small>';

                    if(item['status'] == "A")
                        htmlAtivas += '       <strong>'+item['texto']+'  </strong>';
                    if(item['status'] == "R")
                        htmlAtivas += '       <strike>'+item['texto']+'</strike> - RECUSADA';
                    
                    htmlAtivas += '   </div>';                    
                    htmlAtivas += '   <div class="panel panel-default panel-link-list">';
                    htmlAtivas += '     <div class="panel-body">';

                    if(item['status'] == "A"){
                        htmlAtivas += '    <a data-toggle="modal" href="#msgModalCancelar" style="margin-right: 10px;" onclick="setaDadosModalCancelar('+item['id']+',\''+item['texto']+'\'); return false;"><span class="h ya"></span> Cancelar</a>';
                        htmlAtivas += '    <a  onClick="setaDadosModalSugestao('+item['id']+',\''+item['texto']+'\'); return false;" style="margin-right: 10px;"><span class="h xk"></span> Sugestões</a>';
                    }if(item['status'] == "R"){
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
                $.each(value, function(key4,item3) {
                    htmlConcluidas +='  <li class="b qf aml" >';
                    htmlConcluidas +='    <div class="qj "> <span class="h ajw"> </span></div>';                        
                    htmlConcluidas +='  <div class="qg">';
                    htmlConcluidas +='      <small class="eg dp">'+item3['tempoCadastada']+'</small>';
                    htmlConcluidas +='      <strike>'+item3['texto']+'</strike>';
                    htmlConcluidas +='  </div>';
                    if(item3['hasSuggestion']){
                        htmlConcluidas +='  <div class="panel panel-default panel-link-list">';
                        htmlConcluidas +='      <div class="panel-body">';
                        htmlConcluidas += '         <a  onClick="setaDadosModalSugestao('+item3['id']+',\''+item3['texto']+'\'); return false;" style="margin-right: 10px;"><span class="h xk"></span> Sugestões</a>';
                        htmlConcluidas +='      </div>';
                        htmlConcluidas +='  </div>';
                    }
                    htmlConcluidas += '   <ul class="ano">';
                    htmlConcluidas += '     <li class="anp" style="vertical-align: 0">';
                    htmlConcluidas += '         <img class="cu" src="/uploads/avatars/'+item3['avatar']+'">';
                    htmlConcluidas += '     </li>';
                    htmlConcluidas += '     <li style="display: inline-block"><small>'+item3['nickname']+'</small></li>';
                    htmlConcluidas += '   </ul>';
                    htmlConcluidas += '</li>';
                })
            }

        });
        $('#returnListaAtivas').html(htmlAtivas);
        $('#returnListaConcluidas').html(htmlConcluidas);
        $('#msgModalCancelar').modal('toggle');    
        limpaCamposModal('Cancelar');
    });
});
/************************************* CANCELAR TAREFA *******************************************************/