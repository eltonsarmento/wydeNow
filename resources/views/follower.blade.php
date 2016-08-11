@extends('layouts.social')

@section('content')
<div class="by amt">
  <div class="gc">

    <div class="gn">

       <div class="qv rc aog alu">
          <div class="qx" style="background-image: url(/assets/img/iceland.jpg);"></div>
          <div class="qw dj">
            <a href="profile/index.html">
              <img class="aoh" src="/uploads/avatars/{{ Auth::user()->avatar }}">
            </a>

            <h5 class="qy">{{ Auth::user()->name }} </h5>
            <p id="imageEdit">edit image</p>
            <div style="display:none" id="divImage">
              <form enctype="multipart/form-data" action="/profile" method="post">                
                  <input type="file" name="avatar">
                  
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">                  
                  <button type="submit" class="cg fm"><span class="h xi"></span></button>
                  <!-- <input type="submit" class="pull-right btn btn-sm btn-primary" value="Update Image"> -->
              </form> 
            </div>


            <p class="alu">I wish i was a little bit taller, wish i was a baller, wish i had a girl… also.</p>

            <ul class="aoi">
              <li class="aoj">
                <a href="#userModal" class="aku" data-toggle="modal">
                  Friends
                  <h5 class="ali">0</h5>
                </a>
              </li>

              <li class="aoj">
                <a href="#userModal" class="aku" data-toggle="modal">
                  Task
                  <h5 class="ali">0</h5>
                </a>
              </li>
            </ul>
          </div>
      </div>

      <div class="ca alu">
        <a href="#" class="b">
          <span class="h uy eg"></span>
          Notifications
        </a>
        <a href="#" class="b">
          <span class="h uy eg"></span>
          Mentions
        </a>
      </div>

       <div class="qv rc sm sp">
        
      </div>

      <div class="qv rc sm sp">
        <div class="qw">
          <h5 class="ald">Trending Searches <small>· <a href="#">Change</a></small></h5>
          <ul class="eb tb">
            <li><a href="#">#Bootstrap</a>
            <li><a href="#">Mdo for pres</a>
            <li><a href="#">#fatsux</a>
            <li><a href="#">#buyme</a>
            <li><a href="#">#designishard</a>
            <li><a href="#">#helpawesomepeople</a>
            <li><a href="#">#doawesomestuff</a>
            <li><a href="#">Tom Brady</a>
            <li><a href="#">Magna Carta</a>
            <li><a href="#">Mark Otto</a>
            <li><a href="#">Dave Gamache</a>
            <li><a href="#">Jacob Thornton</a>
          </ul>
        </div>
      </div>

    </div>

    <div class="gz">
      <ul class="nav ol">
        @foreach($user->categorias as $categoria)
          <li @if($categoriaSetada == $categoria->descricao) class="active" @endif ><a data-toggle="tab" href="#{{$categoria->descricao}}">{{$categoria->descricao}}</a></li>        
        @endforeach
        <li><a data-toggle="tab" href="#menu1">+</a></li>        
      </ul>      

      @foreach($user->categorias as $categoria)
          <div class="tab-content">
            <div id="{{$categoria->descricao}}" 
              class="tab-pane fade 
                  @if($categoriaSetada == $categoria->descricao) 
                      in active
                  @endif">        

              <ul class="ca qo anx">
                <li class="b aml">
                  <h3 class="alcs">Suas Tarefas</h3>

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
                </li>

                <li class="qf b aml">                          
                    <form enctype="multipart/form-data" action="/tarefa/adiciona" method="post">    
                      <input type="hidden" name="categoria_id" value="{{$categoria->id}}">            
                      <input type="text" class="form-control" id="texto" name="texto" placeholder="Escreva sua tarefa">
                      <input type="hidden" id="isPrivado" value="0">
                      <br>
                      <button class="cg ts fx" type="button" id="privado">
                        <span class="h vc"></span> 
                        Privado
                      </button>               
                      
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">                  
                      <button type="submit" class="cg ts fx">Salvar</button>                
                    </form> 
                    <script type="text/javascript">
                        $('#privado').click(function(){                      
                          if($('#isPrivado').val() == '1'){
                            var texto = $('#texto').val();
                            var textoSemPrivado = texto.replace("#privado", "");
                            $('#texto').val(textoSemPrivado); 
                            $('#isPrivado').val('0');
                          }else{
                            $('#texto').val($('#texto').val() + " #privado");
                            $('#isPrivado').val('1');
                          }
                        });
                    </script>
                </li>
                <br>
                @foreach($user->tarefas as $tarefa)
                    @if($categoria->id == $tarefa->categoria_id)
                        <li class="b qf aml">
                          <div class="qj">
                            <span class="h 
                                @if($tarefa->privado)
                                  ajv
                                @else
                                  abv
                                @endif
                                 dp"></span>
                          </div>

                          <div class="qg">
                            <small class="eg dp">{{ $tarefa->tempoCadastada}} </small>
                            <div class="qn">
                              <a href="#"><strong>{{$tarefa->texto}}</strong></a> 
                            </div>
                          </div>
                        </li>
                    @endif
                @endforeach
               

                    <li class="b qf aml">
                      <div class="qj">
                        <span class="h ajv dp"></span>
                      </div>

                      <div class="qg">
                        <small class="eg dp">34 min</small>
                        <div class="qn">
                          <a href="#"><strong>Fat</strong></a> and <a href="#"><strong>1 other</strong></a> followed you
                        </div>
                        <ul class="ano">
                          <li class="anp"><img class="cu" src="/assets/img/avatar-fat.jpg">
                          <li class="anp"><img class="cu" src="/assets/img/avatar-dhg.png">
                        </ul>
                      </div>
                    </li>
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
      @endforeach
      


    </div>

    @include('helpers.coluna_direita')
  </div>
</div>
@endsection
