@extends('layouts.social')

@section('content')
<div class="by amt">
  <div class="gc">    

    <div class="gz" style="width: 75%;">
      <ul class="nav ol">
        @foreach($user->categorias as $categoria)
          <li @if($categoriaSetada == $categoria->descricao) class="active" @endif >
            <a  href="/tarefa/{{$categoria->descricao}}">{{$categoria->descricao}}
              @if($categoria->tarefasAtivas->count() > 0)
                ({{ $categoria->tarefasAtivas->count() }}) 
              @endif
            </a>
          </li>        
        @endforeach
        @if($user->tarefasDoIT->count() > 0)
          <li @if($categoriaSetada == $categoria->descricao) class='active' @endif >
            <a  href="/tarefa/doit">Compatilhadas ({{$user->tarefasDoIT->count() }})</a>
          </li>        
        @endif
        <li><a data-toggle="tab" href="#menu1">+</a></li>        
      </ul>      

      @foreach($user->categorias as $categoria)
          @if($categoriaSetada == $categoria->descricao) 
              <input type="hidden" id="categoriaSetada"  value="{{$categoria->id}}">
          
                <div class="tab-content">
                  <div id="{{$categoria->descricao}}" 
                    class="tab-pane fade 
                        @if($categoriaSetada == $categoria->descricao) 
                            in active
                        @endif">        

                    <ul class="ca qo anx">
                      <li class="b aml">
                        <h3 class="alcs">Tarefas de hoje</h3>

                        <div class="btn-group">
                          <button type="button" class="cg ts fx dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Ordenação <span class="caret"></span>
                          </button>

                          <ul class="dropdown-menu">
                            <li><a href="/tarefa/ordenar/{{$categoria->id}}/data">Por Data de Cadastro</a></li>
                            <li><a href="/tarefa/ordenar/{{$categoria->id}}/dataDesc">Por Data de Cadastro inversa</a></li>                      
                            <li role="separator" class="divider"></li>
                            <li><a href="/tarefa/ordenar/{{$categoria->id}}/prioridade">Por Prioridade</a></li>
                          </ul>
                        </div>
                        <p>Ordenado por: <strong id="tipoOrdenacaoReturn">{{$opcaoEscolhida}}</strong></p>
                      </li>

                      <li class="qf b aml">                          
                          <form enctype="multipart/form-data" action="/tarefa/adiciona" method="post">    
                            <input type="hidden" name="categoria_id"  value="{{$categoria->id}}">                                  
                            <input type="text" class="form-control" id="texto" name="texto" placeholder="Escreva sua tarefa">
                            <input type="hidden" id="isPrivado" value="0">
                            <br>
                            <button class="cg tr" type="button" id="privado">
                              <span class="h adw" id="btnIconPrivado"></span>
                            </button>                                     
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">                  
                            <button type="submit" class="cg tr">Salvar</button>                
                          </form>                     
                      </li>
                      <br>       
                      <link rel="stylesheet" type="text/css" href="/assets/css/natstable.css">                            
                         <div class="dd" id="nestable3">
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">  
                          <div id="returnListaAtivas">   
                            <ol class="dd-list" > 
                                @foreach($user->tarefas as $tarefa)
                                    @if($categoria->id == $tarefa->categoria_id)
                                
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
                              <!-- </div>   -->
                              </ol>
                              </div>
                          </div>
                        

                        <div id="returnListaConcluidas">
                        @if($user->tarefasConcluidas)
                              @foreach($user->tarefasConcluidas as $tarefa)
                                  @if($categoria->id == $tarefa->categoria_id)
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
                              @endif
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
          @endif 
      @endforeach
      


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
