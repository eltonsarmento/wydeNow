@extends('layouts.social')

@section('content')
<div class="by amt">
  <div class="gc">    

    <div class="gz" style="width: 75%;">
      <ul class="nav ol">        
          <li class="active">
            <a  href="#">{{$opcao}} </a>
          </li>                
      </ul>      

     
          
        <div class="tab-content">
          <div  class="tab-pane fade in active">        

            <ul class="ca qo anx">
              <li class="b aml"><h3 class="alcs">Tarefas {{$opcao}}</h3></li>              
              <br>       
              <link rel="stylesheet" type="text/css" href="/assets/css/natstable.css">                            
                 <div class="dd" id="nestable3">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">  
                  <div id="returnListaAtivas">   
                    <ol class="dd-list" > 
                        @foreach($user->tarefas as $tarefa)                         	
                              
                            @if($tarefa->status == 'C')
	                            <li class="b qf aml" >
		                            <div class="qj ">
		                              <span class="h 
		                                        @if($tarefa->privado)
		                                          adw
		                                        @else
		                                          abv
		                                        @endif">
		                              </span>
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
                          		</li>  	   
                            @elseif($tarefa->status == 'A')            
	                            <li class="b qf aml dd-item dd3-item" data-id="{{$tarefa->id}}">
	                              <div class="qj dd-handles dd3-handles">
	                                <span class="h 
	                                          @if($tarefa->isdoit)
	                                            ajw
	                                          @elseif($tarefa->privado)
	                                            adw
	                                          @else
	                                            abv
	                                          @endif">
	                                </span>
	                              </div>

	                              <div class="qg">   
	                                  <small class="eg dp">{{ $tarefa->tempoCadastada}}</small>                                                         
	                                  <a href="#"><strong>{{$tarefa->texto}}</strong></a>  
	                              </div>                                      
	                              <div class="panel panel-default panel-link-list">
	                                <div class="panel-body">
	                                    
	                                      @if($tarefa->isdoit)
	                                        <a data-toggle="modal" href="#msgModalRecusarDoIt" style="margin-right: 10px;" onclick="setaDadosModalRecusarDoIt('{{$tarefa->id}}','{{$tarefa->texto}}'); return false;"><span class="h ya"></span> Recusar</a>

	                                        <a  onClick="setaDadosModalSugestao('{{$tarefa->id}}','{{$tarefa->texto}}'); return false;"style="margin-right: 10px;"><span class="h xk"></span> Sugestões</a></a>

	                                        <a data-toggle="modal" href="#msgModalConcluir" onClick="setaDadosModalConcluir('{{$tarefa->id}}','{{$tarefa->texto}}'); return false;"><span class="h xl"></span> Concluir</a>    
	                                      @else
	                                        <a data-toggle="modal" href="#msgModalCancelar" style="margin-right: 10px;" onclick="setaDadosModalCancelar('{{$tarefa->id}}','{{$tarefa->texto}}'); return false;"><span class="h ya"></span> Cancelar</a>

	                                        <a  onClick="setaDadosModalSugestao('{{$tarefa->id}}','{{$tarefa->texto}}'); return false;"style="margin-right: 10px;"><span class="h xk"></span> Sugestões</a></a>

	                                        <a data-toggle="modal" href="#msgModalConcluir" onClick="setaDadosModalConcluir('{{$tarefa->id}}','{{$tarefa->texto}}'); return false;"><span class="h xl"></span> Concluir</a>    
	                                      @endif
	                                </div>
	                              </div>                                    
	                              @if($tarefa->isdoit)
	                                  <ul class="ano">
	                                    <li class="anp" style="vertical-align: 0">                                              
	                                      <img class="cu" src="/uploads/avatars/{{$tarefa->userDoIt->avatar}}">
	                                    </li>
	                                    <li style="display: inline-block"><small>{{$tarefa->userDoIt->nickname}}</small></li>
	                                  </ul>
	                              @endif                                    
	                            </li> 
	                        @endif     
                        @endforeach                                            
                      </ol>
                      </div>
                  </div>
              
            </ul>
            
          </div>          
        </div>
          
      


    </div>

    <div class="gn">
      <div class="qv rc alu ss">
            <div class="qw">             
            @if($user->followers->count() > 0)  
                  <h5 class="ald">Estou Seguindo<small> · <a href="#"> Ver todos</a></small></h5>
                  <ul class="qo anx">
                    @foreach($user->followers as $key => $follow)  
                      @if($key < 5)
                        <li class="qf alm">
                          <a class="qj" href="/profile/{{ $follow->nickname }}"><img class="qh cu" src="/uploads/avatars/{{$follow->avatar}}"></a>
                          <div class="qg">
                            <strong>{{ $follow->name }}</strong> 
                            <small>{{ $follow->nickname }}</small>
                            <br>                    
                            @if($follow->tarefas->count() > 0)
                              {{ $follow->tarefas->where('status', 'A')->count() }} Pendentes
                            @else
                              <small>Nenhuma Pendente</small>
                            @endif                    
                            <div class="aoa">                      
                                {{ $follow->tarefas->count() }} <span class="h aif"></span>
                            </div>
                          </div>
                        </li>           
                      @endif
                    @endforeach
                    </ul>
                    </div>
            @else          
                <h5 class="ald">Nenhum Seguidor <small> ·<a href="#"> Procurar</a></small></h5>
                <ul class="qo anx">
                  @foreach($people as $key => $person) 
                          <li class="qf alm">
                            <a class="qj" href="/profile/{{$person->nickname}}"><img class="qh cu" src="/uploads/avatars/{{$person->avatar}}"></a>
                            <div class="qg">
                              <strong>{{$person->name}}</strong> {{$person->nickname}}
                              <div class="aoa">
                                <a href="/profile/{{$person->nickname}}" class="cg ts fx">
                                  <span class="h vc"></span> Follow</a>
                              </div>
                            </div>
                          </li>                        
                  @endforeach
                </ul>
                </div>
                <div class="qz">
                  Descubra colaboradores para lhe ajudar em suas tarefas e juntos compartilharem sugestões.
                </div>          
            @endif
        </div>

        <div class="qv rc">
          <div class="qw">
          © 2015 Bootstrap

          <a href="#">About</a>
          <a href="#">Help</a>
          <a href="#">Terms</a>
          <a href="#">Privacy</a>
          <a href="#">Cookies</a>
          <a href="#">Ads </a>

          <a href="#">info</a>
          <a href="#">Brand</a>
          <a href="#">Blog</a>
          <a href="#">Status</a>
          <a href="#">Apps</a>
          <a href="#">Jobs</a>
          <a href="#">Advertise</a>
          </div>


      </div>
    </div>
    
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
          <input type="text" id="sugestao" class="form-control" placeholder="Write your menssage">
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

  </div>
</div>


<script src="/assets/js/jquery.nestable.js"></script>
<script src="/scripts/tarefas.js"></script>
<script src="/scripts/suggestions.js"></script>
@endsection
