$.ajaxSetup({  
  headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

$('#imageEdit').click(function(){
  $('#divImage').show();
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
                $('#divBtnSeguir').html('<button type="button" onclick="btnFollow(\'add\', '+id+'); return false;" class="cg fz tt active" ><span class="h xl"></span> seguindo</button>');
            }
        });
    }
}

function btnPermit(tipo,id){
    if(tipo == 'add'){

        $.post("/profile/permit/", {idUser: id}, function(result){  
            if(result == 1){
                $('#divBtnPermit').html('<button type="button" onclick="btnPermit(\'remover\','+id+'); return false;" class="cg fx tw "><span class="h ago"></span> Don\'t Permit</button>');
                $('#divBtnSeguir').html('<button type="button" onclick="btnFollow(\'remover\', '+id+'); return false;" class="cg fz tt active"><span class="h xl"></span> seguindo</button>');
            }
        });
    }else if(tipo == 'remover'){
        $.post("/profile/unpermit/", {idUser: id}, function(result){  
            if(result == 1){
                $('#divBtnPermit').html('<button type="button" onclick="btnPermit(\'add\', '+id+'); return false;" class="cg fx ts "><span class="h vc "></span> Permit</button>');
            }
        });
    }
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