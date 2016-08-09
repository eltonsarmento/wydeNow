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
        $.post("/profile/favorite", {idUser: id}, function(result){  
            if(result == 1){
                $('#divBtnFavorite').html('<button id="btnUnFavorite" onclick="btnFavorito(\'remover\', '+id+'); return false;"  type="button" class="cg fx tv active"> <span class="h aif"></span> Favorite</button>');
                $('#divBtnSeguir').html('<button type="button" onclick="btnFollow(\'remover\', '+id+'); return false;" class="cg fz tt active"><span class="h xl"></span> seguindo</button>');
            }
        });
    }else if(tipo == 'remover'){
        $.post("/profile/unfavorite", {idUser: id}, function(result){  
            if(result == 1){
                $('#divBtnFavorite').html('<button id="btnFavorite" onclick="btnFavorito(\'add\', '+id+'); return false;" type="button" class="cg fx tv "><span class="h aie"></span> Favotite</button>');
            }
        });
    }
}
function btnFollow(tipo,id){
    if(tipo == 'add'){
        $.post("/profile/follow", {idUser: id}, function(result){  
            if(result == 1){
                $('#divBtnSeguir').html('<button type="button" onclick="btnFollow(\'remover\', '+id+'); return false;" class="cg fz tt active"><span class="h xl"></span> seguindo</button>');
            }
        });
    }else if(tipo == 'remover'){
        $.post("/profile/unfollow", {idUser: id}, function(result){  
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
        $.post("/profile/permit", {idUser: id, opcoes: opcoesJason}, function(result){              
            if(result == 1){
                $('#divBtnPermit').html('<button type="button" data-toggle="modal" href="#msgModalPermit" class="cg fx tw "><span class="h ago"></span> Don\'t Permit</button>');                
                $('#msgModalPermit').modal('toggle');
            }
        });
    }else{        
        $.post("/profile/unpermit", {idUser: id}, function(result){  
            if(result == 1){
                $('#divBtnPermit').html('<button type="button" data-toggle="modal" href="#msgModalPermit" class="cg fx ts"><span class="h vc"></span> Permit</button>');
                $('#msgModalPermit').modal('toggle');
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

/************************************* CONCLUIR TAREFA *******************************************************/


/************************************* Formulario *******************************************************/
function actionLock(option){
    if(option == 'lock'){
        limpaCamposModalSenha();
        $('#divLock').html('<button type="button" class="cg fm" onclick="actionLock(\'unlock\'); return false;"><span class="h adw"></span></button> <small> Clique no cadeado para efetuar alterações.</small>');
        document.getElementById("divDadoPessoais").style = "pointer-events:none;";
    }else{        
        $('#modalLock').modal('show');    
    }
    
}
$('#modalLock').on('shown.bs.modal', function () {
    $('#senhaModal').focus();
}) 

function verificaSenhaDesbloquear(){
    var senha = $('#senhaModal').val();
    $.post('/profile/validaSenha', {senha: senha}, function(result){
        if(result == 'true'){            
            $('#divLock').html('<button type="button" class="cg fm" onclick="actionLock(\'lock\'); return false;"><span class="h adv"></span></button> <small> Clique no cadeado para bloquear os campos.</small>');
            document.getElementById("divDadoPessoais").style = "";            
            $('#modalLock').modal('hide');
            limpaCamposModalSenha();
        }else{
            $('#divErrorSenha').html('<smal>* A senha digitada está incorreta. Tente novamente.</smal>'); 
            $('#divLock').html('<button type="button" class="cg fm" onclick="actionLock(\'unlock\'); return false;"><span class="h adw"></span></button> <small> Clique no cadeado para efetuar alterações.</small>');
            document.getElementById("divDadoPessoais").style = "pointer-events:none;";
        }
        
    })
}

function limpaCamposModalSenha(){
    $('#divErrorSenha').html(''); 
    $('#senhaModal').val(''); 
}

function atualizarSenha(){

    var novaSenha     = $('#novaSenha').val();
    var confirmaSenha = $('#confirmaSenha').val();    
    var htmlMessagem = '';
    $.post('/profile/updatepassword', {novaSenha: novaSenha, confirmaSenha: confirmaSenha}, function(result){
        if(result == 'true'){
            htmlMessagem += '<div class="alert fq alert-dismissible fade in" role="alert">';
            htmlMessagem += '    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>';
            htmlMessagem += '    <p><span class="h xl"></span> Senha alterada com sucesso!!</p>';
            htmlMessagem += ' </div>';
            $("#app-growl").html(htmlMessagem);
            $('#novaSenha').val('');
            $('#confirmaSenha').val(''); 
        }else{
            htmlMessagem += '<div class="alert fs alert-dismissible fade in" role="alert">';
            htmlMessagem += '    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>';
            htmlMessagem += '    <p><span class="h akk"></span> <strong>Senha</strong> e <strong>confirma senha</strong> são diferentes!!</p>';
            htmlMessagem += ' </div>';
            $("#app-growl").html(htmlMessagem);   
        }
    })
}

function atualizarDadosPessoais(){

    var nameUser      = $('#nameUser').val();
    var nicknameUser  = $('#nicknameUser').val();
    var livesinUser   = $('#livesinUser').val();
    var workedatUser  = $('#workedatUser').val();
    
    var htmlMessagem = '';
    $.post('/profile/updateprofile', {name: nameUser, nickname: nicknameUser, livesin: livesinUser, workedat: workedatUser}, function(result){
        if(result == 'true'){
            htmlMessagem += '<div class="alert fq alert-dismissible fade in" role="alert">';
            htmlMessagem += '    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>';
            htmlMessagem += '    <p><span class="h xl"></span> Dados pessoais atualizados com sucesso!!</p>';
            htmlMessagem += ' </div>';
            
            $("#app-growl").html(htmlMessagem);                   
        }
        
    })
}
/************************************* Formulario *******************************************************/