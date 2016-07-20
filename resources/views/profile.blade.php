@extends('layouts.social')

@section('content')
<div class="by amt">
  <div class="gc">

    <div class="gn">

       <div class="qv rc aog alu">
          <div class="qx" style="background-image: url(/assets/img/iceland.jpg);"></div>
          <div class="qw dj">
            <a href="profile/index.html">
              <img class="aoh" src="/uploads/avatars/{{ $user->avatar }}">
            </a>

            <h5 class="qy">{{ $user->name }} </h5>
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
                  Followers
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
      @unless($my_perfil)
          <div class="qv rc aog alu">          
              <div class="qw dj">          
                <p class="alu">Permitir este usuário escrever nas minhas tarefas ?</p>

                <ul class="aoi">
                  <li class="aoj">
                    @if($follower)
                        @if($follower->permit == 1)
                            <button type="button" class="cg fx tw"><span class="h ago"></span> Don't Permit</button>    
                        @else
                            <button type="button" class="cg fx ts"><span class="h vc "></span> Permit</button>                        
                        @endif
                    @else
                        <button type="button" class="cg fx ts"><span class="h vc "></span> Permit</button>                        
                    @endif                    
                  </li>

                  <li class="aoj">                
                    @if($follower)
                        @if($follower->favorite == 1)
                            <button type="button" class="cg fx tv active"> <span class="h aif"></span>Favotite</button>                            
                        @else
                            <button type="button" class="cg fx tv "><span class="h aie"></span> Favotite</button>               
                        @endif
                    @else
                        <button type="button" class="cg fx tv "><span class="h aie"></span> Favotite</button>
                    @endif                  
                  </li>
                </ul>
              </div>
          </div>
      @endunless
       

       <div class="qv rc sm sp">
        
      </div>
    </div>

    <div class="gz">
      <ul class="nav ol">
        @foreach($user->categorias as $categoria)
          <li @if($categoriaSetada == $categoria->descricao) class="active" @endif ><a data-toggle="tab" href="#{{$categoria->descricao}}">{{$categoria->descricao}}</a></li>        
        @endforeach
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
              </ul>
              
            </div>            
          </div>
      @endforeach
      


    </div>

    <div class="gn">
      <div class="qv rc alu ss">
        <div class="qw">
        <h5 class="ald">Active Users <small>· <a href="#">View All</a></small></h5>
        <ul class="qo anx">
          <li class="qf alm">
            <a class="qj" href="#">
              <img
                class="qh cu"
                src="/assets/img/avatar-fat.jpg">
            </a>
            <div class="qg">
              <strong>Jacob Thornton</strong> @fat
              <div class="aoa">
                <button class="cg ts fx">
                  <span class="h vc"></span> Follow</button>
              </div>
            </div>
          </li>
           <li class="qf">
            <a class="qj" href="#">
              <img
                class="qh cu"
                src="/assets/img/avatar-mdo.png">
            </a>
            <div class="qg">
              <strong>Mark Otto</strong> @mdo
              <div class="aoa">
                <button class="cg ts fx">
                  <span class="h vc"></span> Follow</button></button>
              </div>
            </div>
          </li>
        </ul>
        </div>
        <div class="qz">
          Dave really likes these nerds, no one knows why though.
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
  </div>
</div>
@endsection
