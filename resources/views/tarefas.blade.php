@extends('layouts.social')

@section('content')
<div class="by amt">
  <div class="gc">    

    <div class="gz" style="width: 75%;">
      <ul class="nav ol">
        @foreach($user->categorias as $categoria)
          <li @if($categoriaSetada == $categoria->descricao) class="active" @endif >
            <a  href="/tarefa/{{$categoria->descricao}}">{{$categoria->descricao}}</a></li>        
            <!-- <a data-toggle="tab" href="#{{$categoria->descricao}}">{{$categoria->descricao}}</a></li>         -->
        @endforeach
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
                        <p>Ordenado por: <strong id="tipoOrdenacaoReturn">{{$opçãoEscolhida}}</strong></p>
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
                                                  @if($tarefa->privado)
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
                                              <a data-toggle="modal" href="#msgModalCancelar" style="margin-right: 10px;" onclick="setaDadosModalCancelar('{{$tarefa->id}}','{{$tarefa->texto}}'); return false;"><span class="h ya"></span> Cancelar</a>
                                            
                                              <a data-toggle="modal" href="#msgModalSugestao" style="margin-right: 10px;"><span class="h xk"></span> Sugestões</a></a>                                    
                                            
                                              <a data-toggle="modal" href="#msgModalConcluir" 
                                                onClick="setaDadosModalConcluir('{{$tarefa->id}}','{{$tarefa->texto}}'); return false;"><span class="h xl"></span> Concluir</a>  
                                        </div>
                                      </div>
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
                                    @if($tarefa->sugestao)
                                        <div class="panel panel-default panel-link-list">
                                          <div class="panel-body">                                  
                                                <a data-toggle="modal" href="#msgModalSugestao" style="margin-right: 10px;"><span class="h xk"></span> Sugestões</a></a>
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

    <div class="gn">

      
      <div class="qv rc alu ss">
        <div class="qw">
        <h5 class="ald">Usuários sugeridos <small>· <a href="#">Ver todos</a></small></h5>
        <ul class="qo anx">
          <li class="qf alm">
            <a class="qj" href="#"><img class="qh cu" src="/assets/img/avatar-fat.jpg"></a>
            <div class="qg">
              <strong>Jacob Thornton</strong> @fat
              <div class="aoa">
                <button class="cg ts fx">
                  <span class="h vc"></span> Seguir</button>
              </div>
            </div>
          </li>           
        </ul>
        </div>
        <div class="qz">
          Descubra colaboradores para lhe ajudar em suas tarefas e juntos compartilharem sugestões.
        </div>
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
    
<!-- Modal Sugestões -->
<div class="cd fade" id="msgModalSugestao" tabindex="-1" role="dialog" aria-labelledby="msgModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="d">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>        
        <h4 class="modal-title">Titulo da Tarefa</h4>
      </div>

      <div class="modal-body amf js-modalBody">
        <div class="modal-body">
          <input type="text" class="form-control" placeholder="Messages">
        </div>        
        <div class="uq">          

          <div class="alj js-conversation">
            <ul class="qo aob">

              <li class="qf aoe alu">
                <div class="qg">
                  <div class="aoc">MEU TEXTO</div>
                  <div class="aod"><small class="dp"><a href="#">Dave Gamache</a> at 4:20PM</small></div>
                </div>
                <a class="qi" href="#"><img class="cu qh" src="/assets/img/avatar-dhg.png"></a>
              </li>

              <li class="qf alu">
                <a class="qj" href="#"><img class="cu qh" src="/assets/img/avatar-fat.jpg"></a>
                <div class="qg">
                  <div class="aoc">TEXTO SUJERIDO</div>
                  <div class="aod"><small class="dp"><a href="#">Fat</a> at 4:28PM</small></div>
                </div>
              </li>

            </ul>
          </div>
        </div>
      </div>
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


<!-- Modal Confirmação Concluir -->
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

  </div>
</div>


<script src="/assets/js/jquery.nestable.js"></script>
<script src="/scripts/tarefas.js"></script>
@endsection
