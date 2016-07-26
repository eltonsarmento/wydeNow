$.ajaxSetup({  
  headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

$('#imageEdit').click(function(){
  $('#divImage').show();
});      


function setaDadosModalSugestao(id, texto){
    $('#tituloTarefaSugestao').html(texto);
    $('#idTarefaSugestao').val(id);   

    $('#msgModalSugestao').modal('toggle');
    
}
$(document).keypress(function(e) {
    if(e.which == 13){
        var texto = $('#sugestao').val()        
        if(texto.length > 3){
            var tarefa_id  = $('#idTarefaSugestao').val();  

            $.post("/tarefa/sugestao/", {tarefa_id: tarefa_id, texto: texto}, function(result){  
                alert(result);
               /* var json = jQuery.parseJSON(result);
                
                var htmlBody = '<ul class="qo aob">';

                $.each(json, function(key,value) {
                    if(key == 'owner'){

                        htmlBody += '<li class="qf aoe alu">';
                        htmlBody += '    <div class="qg">';
                        htmlBody += '      <div class="aoc">MEU TEXTO</div>';
                        htmlBody += '      <div class="aod"><small class="dp"><a href="#">Dave Gamache</a> at 4:20PM</small></div>';
                        htmlBody += '    </div>';
                        htmlBody += '    <a class="qi" href="#"><img class="cu qh" src="/assets/img/avatar-dhg.png"></a>';
                        htmlBody += '</li>';
                    }else{
                        htmlBody += '<li class="qf alu">';
                        htmlBody += '    <a class="qj" href="#"><img class="cu qh" src="/assets/img/avatar-fat.jpg"></a>';
                        htmlBody += '      <div class="qg">';
                        htmlBody += '           <div class="aoc">TEXTO SUJERIDO</div>';
                        htmlBody += '           <div class="aod"><small class="dp"><a href="#">Fat</a> at 4:28PM</small></div>';
                        htmlBody += '    /div>';
                        htmlBody += '</li>';                        
                    }
                });    
                htmlBody += '</ul>';
                $('#corpoTarefaSugestao').html(htmlBody); */                 
            });
        }
    }
});
              
/************************************* CONCLUIR TAREFA *******************************************************/
 
function btnFavorito(tipo,id){
    if(tipo == 'add'){
        $.post("/profile/favorite/", {idUser: id}, function(result){  
            if(result == 1){
                $('#divBtnFavorite').html('<button id="btnUnFavorite" onclick="btnFavorito(\'remover\', '+id+'); return false;"  type="button" class="cg fx tv active"> <span class="h aif"></span> Favorite</button>');
                $('#divBtnSeguir').html('<button type="button" onclick="btnFollow(\'remover\', '+id+'); return false;" class="cg fz tt active"><span class="h xl"></span> seguindo</button>');
            }
        });
    }else if(tipo == 'remover'){
        $.post("/profile/unfavorite/", {idUser: id}, function(result){  
            if(result == 1){
                $('#divBtnFavorite').html('<button id="btnFavorite" onclick="btnFavorito(\'add\', '+id+'); return false;" type="button" class="cg fx tv "><span class="h aie"></span> Favotite</button>');
            }
        });
    }
}
function btnFollow(tipo,id){
    if(tipo == 'add'){
        $.post("/profile/follow/", {idUser: id}, function(result){  
            if(result == 1){
                $('#divBtnSeguir').html('<button type="button" onclick="btnFollow(\'remover\', '+id+'); return false;" class="cg fz tt active"><span class="h xl"></span> seguindo</button>');
            }
        });
    }else if(tipo == 'remover'){
        $.post("/profile/unfollow/", {idUser: id}, function(result){  
            if(result == 1){
                $('#divBtnSeguir').html('<button type="button" onclick="btnFollow(\'add\', '+id+'); return false;" class="cg fz tt" ><span class="h vc"></span> seguir</button>');
                $('#divBtnFavorite').html('<button id="btnFavorite" onclick="btnFavorito(\'add\', '+id+'); return false;" type="button" class="cg fx tv "><span class="h aie"></span> Favotite</button>');
            }
        });
    }
}

function btnPermit(id){
    
    var aChk = document.getElementsByName('lista');
    var opcoes = "";
    for (var i=0; i < aChk.length;i++){
         if (aChk[i].checked == true){             
             opcoes += '{"categoria_id":"'+ aChk[i].value +'"},';
         }
    }
    if(opcoes.length > 0){
        var opcoesJason = opcoes.slice(0,opcoes.length-1);        
        var opcoesJason = '['+opcoesJason+']';        
        $.post("/profile/permit/", {idUser: id, opcoes: opcoesJason}, function(result){              
            if(result == 1){
                $('#divBtnPermit').html('<button type="button" data-toggle="modal" href="#msgModalPermit" class="cg fx tw "><span class="h ago"></span> Don\'t Permit</button>');                
                $('#msgModalPermit').modal('toggle');
            }
        });
    }else{        
        $.post("/profile/unpermit/", {idUser: id}, function(result){  
            if(result == 1){
                $('#divBtnPermit').html('<button type="button" data-toggle="modal" href="#msgModalPermit" class="cg fx ts"><span class="h vc"></span> Permit</button>');
                $('#msgModalPermit').modal('toggle');
            }
        });

    }
        
    


    /*if(tipo == 'add'){

        $.post("/profile/permit/", {idUser: id}, function(result){  
            if(result == 1){
                $('#divBtnPermit').html('<button type="button" onclick="btnPermit(\'remover\','+id+'); return false;" class="cg fx tw "><span class="h ago"></span> Don\'t Permit</button>');
            }
        });
    }else if(tipo == 'remover'){
        $.post("/profile/unpermit/", {idUser: id}, function(result){  
            if(result == 1){
                $('#divBtnPermit').html('<button type="button" onclick="btnPermit(\'add\', '+id+'); return false;" class="cg fx ts "><span class="h vc "></span> Permit</button>');
            }
        });
    }*/
}



    
/************************************* CONCLUIR TAREFA *******************************************************/


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
});