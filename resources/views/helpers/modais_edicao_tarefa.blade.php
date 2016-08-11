<!-- Modal Confirmação Concluir -->
<div class="cd fade" id="msgModalConcluir" tabindex="-1" role="dialog" aria-labelledby="msgModal" aria-hidden="true">
  <div class="modal-dialog rq" >
    <div class="modal-content">
      <div class="d">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        <h4 class="modal-title">Concluir tarefa</h4>
      </div>
      <div class="modal-body">
        <p>Deseja concluir a terefa: <strong id="msgModalConcluirCampoTextoTarefa"></strong>  ?</p>        
        <input type="hidden" id="idTarefaConcluir">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">    
      </div>
      <div class="ur">
        <button type="button" class="fu us" onclick="limpaCamposModal('Concluir');" data-dismiss="modal">Cancel</button>
        <button type="button" class="fu us" id="btnConcluirModalConcluir"><strong>Continue</strong></button>
        <!-- <button type="button" class="fu us" data-dismiss="modal"><strong>Continue</strong></button> -->
      </div>
    </div>
  </div>
</div>
<!-- Modal Confirmação Concluir -->

<!-- Modal Confirmação Cancelar -->
<div class="cd fade" id="msgModalCancelar" tabindex="-1" role="dialog" aria-labelledby="msgModal" aria-hidden="true">
  <div class="modal-dialog rq" >
    <div class="modal-content">
      <div class="d">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        <h4 class="modal-title">Cancelar tarefa</h4>
      </div>
      <div class="modal-body">
        <p>Deseja cancelar a terefa: <strong id="msgModalCancelarCampoTextoTarefa"></strong>  ?</p>        
        <input type="hidden" id="idTarefaCancelar">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">    
      </div>
      <div class="ur">
        <button type="button" class="fu us" onclick="limpaCamposModal('Cancelar');" data-dismiss="modal">Cancel</button>
        <button type="button" class="fu us" id="btnContinueModalCancelar"><strong>Continue</strong></button>
        <!-- <button type="button" class="fu us" data-dismiss="modal"><strong>Continue</strong></button> -->
      </div>
    </div>
  </div>
</div>
<!-- Modal Confirmação Cancelar -->

<!-- Modal Confirmação Recusar -->
<div class="cd fade" id="msgModalRecusarDoIt" tabindex="-1" role="dialog" aria-labelledby="msgModal" aria-hidden="true">
  <div class="modal-dialog rq" >
    <div class="modal-content">
      <div class="d">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        <h4 class="modal-title">Recusar tarefa (Do It)</h4>
      </div>
      <div class="modal-body">
        <p>Deseja recusar a terefa: <strong id="msgModalRecusarCampoTextoTarefaDoIt"></strong>  ?</p>        
        <input type="hidden" id="idTarefaRecusarDoIt">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">    
      </div>
      <div class="ur">
        <button type="button" class="fu us" onclick="limpaCamposModal('Recusar');" data-dismiss="modal">Cancel</button>
        <button type="button" class="fu us" id="btnContinueModalRecusarDoIt"><strong>Continue</strong></button>
        <!-- <button type="button" class="fu us" data-dismiss="modal"><strong>Continue</strong></button> -->
      </div>
    </div>
  </div>
</div>
<!-- Modal Confirmação Recusar -->

<!-- Modal Excluir DoIt -->
<div class="cd fade" id="msgModalExcluirDoIt" tabindex="-1" role="dialog" aria-labelledby="msgModal" aria-hidden="true">
  <div class="modal-dialog rq" >
    <div class="modal-content">
      <div class="d">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        <h4 class="modal-title">Excluir tarefa (Do It)</h4>
      </div>
      <div class="modal-body">
        <p>Deseja excluir a terefa: <strong id="msgModalExcluirCampoTextoTarefaDoIt"></strong>  ?</p>        
        <input type="hidden" id="idTarefaExcluirDoIt">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">    
      </div>
      <div class="ur">
        <button type="button" class="fu us" onclick="limpaCamposModal('Excluir');" data-dismiss="modal">Cancel</button>
        <button type="button" class="fu us" id="btnContinueModalExcluirDoIt"><strong>Continue</strong></button>
        <!-- <button type="button" class="fu us" data-dismiss="modal"><strong>Continue</strong></button> -->
      </div>
    </div>
  </div>
</div>
<!-- Modal Excluir DoIt -->