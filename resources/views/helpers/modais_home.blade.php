<!-- Modal Sugestões -->
<div class="cd fade" id="msgModalSugestao" tabindex="-1" role="dialog" aria-labelledby="msgModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="d">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>        
        <h4 class="modal-title" id="tituloTarefaSugestao"></h4>
      </div>

      <div class="modal-body amf js-modalBody">
        <div class="modal-body">
          <input type="hidden" id="idUserTarefaSugestao">
          <input type="hidden" id="idTarefaSugestao">
          <div id="divInputSugestao">
            <input type="text" id="sugestao" class="form-control" placeholder="Write your menssage">
          </div>
        </div>        
        <div class="uq">          

          <div class="alj js-conversation" id="corpoTarefaSugestao">
            <ul class="qo aob">

            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- Modal Sugestões -->
<div class="cd fade" id="msgModalMessage" tabindex="-1" role="dialog" aria-labelledby="msgModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="d">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>        
        <h4 class="modal-title">Escolha a categoria para sua tarefa</h4>
      </div>

          <div class="modal-body amf js-modalBody">
            <div class="modal-body">          
              
                  <div class="dj" >
                      <div class="ex ug uk">
                        <label>
                          <input type="radio" id="radioStatusPublico" onclick="opcaoStatus('publico');"  name="radioStatus"><span class="uh"></span>Público
                        </label>
                      </div>
                      <div class="ex ug uk">
                        <label>
                          <input type="radio" id="radioStatusPrivado" onclick="opcaoStatus('privado');" name="radioStatus"><span class="uh"></span>Privado
                        </label>
                      </div>
                  </div>
                  <hr>
                  <div id="divModalMessageCategorias"></div>
            </div>        
          <div class="uq">          

          <div class="alj js-conversation" id="corpoTarefaSugestao">
            <ul class="qo aob">

            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- Modal Sugestões -->
<div class="cd fade" id="msgModalMessageDoIt" tabindex="-1" role="dialog" aria-labelledby="msgModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="d">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>        
        <h4 class="modal-title">Escolha a categoria do usuário</h4>
      </div>

          <div class="modal-body amf js-modalBody">            
            <div class="uq">          
              <div class="alj js-conversation" id="categoriasmsgModalMessageDoIt"></div>
            </div>
      </div>
    </div>
  </div>
</div>


<!-- Modal Sugestões -->
<div class="cd fade" id="msgModalCopiar" tabindex="-1" role="dialog" aria-labelledby="msgModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="d">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>        
          <h4 class="modal-title">Copiar tarefa</h4>
        </div>
        <input type='hidden' id="textoTarefaCopiar">
        <input type='hidden' id="statusTarefaCopiar" value="1">
        <div class="modal-body amf js-modalBody">
          <div class="modal-body">          
              
              <div class="ex ug uk">
                <label>
                  <input type="radio" id="radioStatusCopiarPublico"  onclick="opcaoStatusCopiar('publico');"  name="radioStatusCopiar"><span class="uh"></span>Público
                </label>
              </div>
              <div class="ex ug uk">
                <label>
                  <input type="radio" id="radioStatusCopiarPrivado" checked="true" onclick="opcaoStatusCopiar('privado');" name="radioStatusCopiar"><span class="uh"></span>Privado
                </label>
              </div> 
              <hr>
              <p>Escolha em qual categoria deseja salvar</p>                  
              
              <hr>

              <div id="divModalCopiarCategorias"></div>

          </div>
        </div>
    </div>
  </div>
</div>