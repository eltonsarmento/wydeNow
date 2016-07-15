$.ajaxSetup({  
  headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
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


	/*Botão Concluir*/
	$('#btnConcluir').click(function(){                      
		var idTarefa = 
		$.post("tarefa/concluir/"+categoria, {id: idTarefa}, function(result){
            alert(result);
            //$('#msgModalConcluir').modal('hide');
        });
		
      
    });

    /*Setar Modal Concluir*/
    function setaDadosModalConcluir(id,descricao){
    	alert(id + " - "+descricao);
    }


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
                //alert(result);
                $('#tipoOrdenacaoReturn').html('Prioridade');
            });
            
        } else {
            output.val('JSON browser support required for this demo.');
        }
    };
    $('#nestable3').nestable().on('change', updateOutput);



    /*Excluir*/
});