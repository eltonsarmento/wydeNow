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

        $.post("/tarefa/concluir/", {id: idTarefa}, function(result){            
            
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
                        htmlAtivas += '         <a data-toggle="modal" href="#msgModalCancelar" style="margin-right: 10px;" onclick="setaDadosModalCancelar("'+item['id']+'","'+item['texto']+'"); return false;"><span class="h ya"></span> Cancelar</a>';
                        htmlAtivas += '         <a data-toggle="modal" href="#msgModalSugestao" style="margin-right: 10px;"><span class="h xk"></span> Sugestões</a></a>';
                        htmlAtivas += '         <a data-toggle="modal" href="#msgModalConcluir" onClick="setaDadosModalConcluir("'+item['id']+'","'+item['texto']+'"); return false;"><span class="h xl"></span> Concluir</a>';  
                        htmlAtivas += '     </div>';
                        htmlAtivas += '   </div>';
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
                        htmlConcluidas +='          <a data-toggle="modal" href="#msgModalSugestao" style="margin-right: 10px;"><span class="h xk"></span> Sugestões</a></a>';
                        htmlConcluidas +='      </div>';
                        htmlConcluidas +='  </div>';
                        htmlConcluidas +='</li> ';
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

    $.post("/tarefa/remover/", {id: idTarefa}, function(result){            
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
                    htmlAtivas += '         <a data-toggle="modal" href="#msgModalCancelar" style="margin-right: 10px;" onclick="setaDadosModalCancelar("'+item['id']+'","'+item['texto']+'"); return false;"><span class="h ya"></span> Cancelar</a>';
                    htmlAtivas += '         <a data-toggle="modal" href="#msgModalSugestao" style="margin-right: 10px;"><span class="h xk"></span> Sugestões</a></a>';
                    htmlAtivas += '         <a data-toggle="modal" href="#msgModalConcluir" onClick="setaDadosModalConcluir("'+item['id']+'","'+item['texto']+'"); return false;"><span class="h xl"></span> Concluir</a>';  
                    htmlAtivas += '     </div>';
                    htmlAtivas += '   </div>';
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
                    htmlConcluidas +='          <a data-toggle="modal" href="#msgModalSugestao" style="margin-right: 10px;"><span class="h xk"></span> Sugestões</a></a>';
                    htmlConcluidas +='      </div>';
                    htmlConcluidas +='  </div>';
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