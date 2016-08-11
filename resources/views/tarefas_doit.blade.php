@extends('layouts.social')

@section('content')
<div class="by amt">
  <div class="gc">    

    <div class="gz" style="width: 75%;">
      <ul class="nav ol">
        @foreach($user->categorias as $categoria)
          <li><a  href="/tarefa/{{$categoria->descricao}}">{{$categoria->descricao}} </a></li>        
        @endforeach
        
          <li class='active' ><a  href="/tarefa/compartilhadas">Compatilhadas ({{$user->tarefas->count() }})</a></li>                
        <li><a data-toggle="tab" href="#menu1">+</a></li>        
      </ul>      
    
        <div class="tab-content">
          <div class="tab-pane fade in active">        

            <ul class="ca qo anx">
              <li class="b aml">
                <h3 class="alcs">Tarefas Compartilhadas (Do It)</h3>
              </li>

              
              <br>       
              <link rel="stylesheet" type="text/css" href="/assets/css/natstable.css">  
                 <div class="dd" id="nestable3">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">  
                  <div id="returnListaAtivas">   
                  
                  <ol class="dd-list" > 
                      @foreach($user->tarefas as $tarefa)
                          @if($tarefa->status == 'R')
                              <li class="b qf aml" >
                              <div class="qj ">
                                <span class="h ya"></span>
                              </div>

                              <div class="qg">   
                                <small class="eg dp">{{ $tarefa->tempoCadastada}}</small>                                                         
                                  <strike>{{$tarefa->texto}}</strike> - RECUSADA
                              </div> 
                               <div class="panel panel-default panel-link-list">
                                <div class="panel-body">
                                      <a data-toggle="modal" href="#msgModalExcluirDoIt" style="margin-right: 10px;" onclick="setaDadosModalCancelar('{{$tarefa->id}}','{{$tarefa->texto}}'); return false;"><span class="h ya"></span> Excluir</a>
                                </div>
                              </div>
                              <ul class="ano">
                                <li class="anp" style="vertical-align: 0">                                              
                                  <img class="cu" src="/uploads/avatars/{{$tarefa->avatar}}">
                                </li>
                                <li style="display: inline-block"><small>{{$tarefa->nickname}}</small></li>
                              </ul>                             
                            </li>  
                          @else
                          
                              <li class="b qf aml dd-item dd3-item" data-id="{{$tarefa->id}}">
                                <div class="qj dd-handles dd3-handles">
                                  <span class="h ajw"></span>
                                </div>

                                <div class="qg">   
                                    <small class="eg dp">{{ $tarefa->tempoCadastada}}</small>                                                         
                                    <a href="#"><strong>{{$tarefa->texto}}</strong></a>  
                                </div>                                      
                                <div class="panel panel-default panel-link-list">
                                  <div class="panel-body">

                                        <a data-toggle="modal" href="#msgModalExcluirDoIt" style="margin-right: 10px;" onclick="setaDadosModalExcluirDoIt('{{$tarefa->id}}','{{$tarefa->texto}}'); return false;"><span class="h ya"></span> Excluir</a>

                                        <a  onClick="setaDadosModalSugestao('{{$tarefa->id}}','{{$tarefa->texto}}'); return false;"style="margin-right: 10px;"><span class="h xk"></span> Sugestões</a></a>                                    
                                                                              
                                  </div>
                                </div>                                    
                                
                                <ul class="ano">
                                  <li class="anp" style="vertical-align: 0">                                              
                                    <img class="cu" src="/uploads/avatars/{{$tarefa->avatar}}">
                                  </li>
                                  <li style="display: inline-block"><small>{{$tarefa->nickname}}</small></li>
                                </ul>
                            
                              </li>  
                          @endif                            
                      @endforeach                      
                    </ol>
                    </div>
                </div>
                
                <div id="returnListaConcluidas">
                @if($user->tarefasConcluidas->count() > 0)
                      @foreach($user->tarefasConcluidas as $tarefa)
                            <li class="b qf aml" >
                            <div class="qj ">
                              <span class="h adw"></span>
                            </div>

                            <div class="qg">   
                              <small class="eg dp">{{ $tarefa->tempoCadastada}}</small>                                                         
                                <strike>{{$tarefa->texto}}</strike>
                            </div>
                            @if($tarefa->sugestao)
                                <div class="panel panel-default panel-link-list">
                                  <div class="panel-body">                                  
                                        <a  onClick="setaDadosModalSugestao('{{$tarefa->id}}','{{$tarefa->texto}}'); return false;"style="margin-right: 10px;"><span class="h xk"></span> Sugestões</a></a>
                                  </div>
                                </div>
                            @endif
                           <ul class="ano">
                              <li class="anp" style="vertical-align: 0">                                              
                                <img class="cu" src="/uploads/avatars/{{$tarefa->avatar}}">
                              </li>
                              <li style="display: inline-block"><small>{{$tarefa->nickname}}</small></li>
                            </ul>
                          </li>     
                  @endforeach
                @endif
                </div>
                <br>   

            </ul>
            
          </div>
        <div id="menu1" class="tab-pane fade">
          <h3>Nova Categoria</h3>          
           <form  action="/tarefa/novaCategoria" method="post">                
                <input type="text" name="categoria" placehold="Nova categoria">
                
                <input type="hidden" name="_token" value="{{ csrf_token() }}">                  
                <button type="submit" class="cg fm">Salvar</button>
                <!-- <input type="submit" class="pull-right btn btn-sm btn-primary" value="Update Image"> -->
            </form> 
        </div>
      </div>




    </div>

   @include('helpers.coluna_direita')
    
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




  </div>
</div>

@include('helpers.modais_edicao_tarefa')

@include('helpers.modal_sugestao')


<script src="/assets/js/jquery.nestable.js"></script>
<script src="/scripts/tarefas.js"></script>
<script src="/scripts/suggestions.js"></script>
@endsection
