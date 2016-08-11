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
		                            @if($tarefa->id_suggestion)
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

	                                        <a data-toggle="modal" href="#msgModalConcluir" onClick="setaDadosModalConcluirBy('{{$tarefa->id}}','{{$tarefa->texto}}'); return false;"><span class="h xl"></span> Concluir</a>    
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

    @include('helpers.coluna_direita')

  </div>
</div>

@include('helpers.modais_edicao_tarefa')

@include('helpers.modal_sugestao')

<script src="/assets/js/jquery.nestable.js"></script>
<script src="/scripts/tarefas.js"></script>
<script src="/scripts/suggestions.js"></script>
@endsection
