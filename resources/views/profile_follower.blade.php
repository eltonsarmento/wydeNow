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
            <input name="idUser" id="idUser" value="{{$user->id}}" type="hidden">            
            <h5 class="qy">{{ $user->name }} </h5>            
            <div id="divBtnSeguir">

              @if($follower)
                <button type="button" class="cg fz tt active" onclick="btnFollow('remover', '+id+'); return false;" ><span class="h xl"></span> seguindo</button>      
              @else
                <button type="button" class="cg fz tt " onclick="btnFollow('add', '+id+'); return false;"><span class="h vc"></span> seguir</button>
              @endif              
            </div>
            <br><br>

        

            <div style="display:none" id="divImage">
              <form enctype="multipart/form-data" action="/profile" method="post">                
                  <input type="file" name="avatar">
                  
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">                  
                  <button type="submit" class="cg fm"><span class="h xi"></span></button>
                  <!-- <input type="submit" class="pull-right btn btn-sm btn-primary" value="Update Image"> -->
              </form> 
              
            </div>

            <ul class="aoi">
              <li class="aoj">
                <a href="#userModal" class="aku" data-toggle="modal">
                  Followers
                  <h5 class="ali">{{$user->followers()->count()}}</h5>
                </a>
              </li>

              <li class="aoj">
                <a href="#userModal" class="aku" data-toggle="modal">
                  Task
                  <h5 class="ali">{{$user->tarefas()->count()}}</h5>
                </a>
              </li>
            </ul>

            
          </div>
      </div>
      
      <div class="qv rc aog alu">          
          <div class="qw dj">          
            <p class="alu">Permitir este usuário adiconar tarefas a mim?</p>

            <ul class="aoi">
              <li class="aoj">   
                <div id="divBtnPermit">         
                    @if($follower)
                        @if($follower->permit == 1)
                            <button type="button" onclick="btnPermit('remover', {{$user->id}}); return false;" class="cg fx tw "><span class="h ago"></span> Don't Permit</button>    
                        @else
                            <button type="button" onclick="btnPermit('add', {{$user->id}}); return false;" class="cg fx ts "><span class="h vc "></span> Permit</button>                        
                        @endif
                    @else
                        <button type="button" onclick="btnPermit('add', {{$user->id}}); return false;" class="cg fx ts"><span class="h vc "></span> Permit</button>                        
                    @endif                    
                </div>
              </li>

              <li class="aoj">  
                <div id="divBtnFavorite">
                    @if($follower)
                        @if($follower->favorite == 1)
                            <button id="btnUnFavorite" onclick="btnFavorito('remover', {{$user->id}} );return false;" type="button" class="cg fx tv active"> <span class="h aif"></span>Favotite</button>                            
                        @else
                            <button id="btnFavorite" onclick="btnFavorito('add', {{$user->id}} );return false;" type="button" class="cg fx tv "><span class="h aie"></span> Favotite</button>               
                        @endif
                    @else
                        <button id="btnFavorite" onclick="btnFavorito('add', {{$user->id}} );return false;" type="button" class="cg fx tv "><span class="h aie"></span> Favotite</button>
                    @endif                  
                </div>
              </li>
            </ul>
          </div>
      </div>
      
       <div class="qv rc sm sp">
        
      </div>
    </div>

    <div class="gz">
      <ul class="nav ol">
        @foreach($user->categorias as $categoria)
          <li @if($categoriaSetada->descricao == $categoria->descricao) class="active" @endif >
            <a href="/profile/{{$user->nickname}}/{{$categoria->descricao}}">{{$categoria->descricao}}</a></li>        
        @endforeach
      </ul>      

      
          <div class="tab-content">
            <div id="{{$categoriaSetada->descricao}}" class="tab-pane fade in active">        

              <ul class="ca qo anx">
                <li class="b aml">
                  <h3 class="alcs">Tarefas de hoje</h3>                  
                </li>

              @foreach($categoriasAutorizadas as $categoriasAutorizada)                      
                  @if($categoriaSetada->descricao == $categoriasAutorizada->descricao)
                      <li class="qf b aml">   
                          <form enctype="multipart/form-data" action="/tarefa/envia" method="post">    
                            <input type="hidden" name="categoria_id"  value="{{$categoria->id}}">                                  
                            <input type="text" class="form-control" id="texto" name="texto" placeholder="Escreva para ele">
                            <input type="hidden" id="isPrivado" value="0">
                            <br>                                    
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">                  
                            <button type="submit" class="cg tr">Salvar</button>                
                          </form> 
                      </li>
                      <br>
                      @break
                  @endif                    
              @endforeach
          
              @foreach($user->tarefas as $tarefa)
                  @if($categoriaSetada->id == $tarefa->categoria_id)
                    @unless($tarefa->privado)
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
                    @endunless
                  @endif
              @endforeach               
              </ul>
              
            </div>            
          </div>
      
      


    </div>

    <div class="gn">
          <div class="qv rc alu ss">
            <div class="qw"> 
            @if(Auth::user()->followers()->count() > 0)  
                  <h5 class="ald">Estou Seguindo<small> · <a href="#"> Ver todos</a></small></h5>
                  <ul class="qo anx">
                    @foreach(Auth::user()->followers()->get() as $key => $follow)  
                      @if($key < 5)
                        <li class="qf alm">
                          <a class="qj" href="/profile/{{ $follow->nickname }}"><img class="qh cu" src="/uploads/avatars/{{$follow->avatar}}"></a>
                          <div class="qg">
                            <strong>{{ $follow->name }}</strong> 
                            <small>{{ $follow->nickname }}</small>
                            <br>                    
                            @if($follow->tarefas()->count() > 0)
                              {{ $follow->tarefas()->where('status', 'A')->count() }} Pendentes
                            @else
                              <small>Nenhuma Pendente</small>
                            @endif                    
                            <div class="aoa">                      
                                {{ $follow->tarefas()->count() }} <span class="h aif"></span>
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


  </div>
</div>

<script src="/scripts/profile.js"></script>
@endsection
