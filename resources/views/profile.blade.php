@extends('layouts.social')

@section('content')
<div class="by amt">
  <div class="gc">

    <div class="gn">

       <div class="qv rc aog alu">
          <div class="qx" style="background-image: url(/assets/img/iceland.jpg);"></div>
          <div class="qw dj">
            
            <img class="aoh" src="/uploads/avatars/{{ $user->avatar }}">
            

            <h5 class="qy">{{ $user->name }} </h5>            
          
            <button type="button" class="cg fz tr" id="imageEdit"><span class="h xi"></span> edit image</button>      

            <div style="display:none" id="divImage">
              <form enctype="multipart/form-data" action="/profile" method="post">                
                  <input type="file" name="avatar">                  
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">                  
                  <button type="submit" class="cg fm"><span class="h xi"></span></button>                  
              </form> 
              
            </div>

            <ul class="aoi">
              <li class="aoj">
                <a href="#userModal" class="aku" data-toggle="modal">
                  Followers
                  <h5 class="ali">{{$user->countFollowers()}}</h5>
                </a>
              </li>

              <li class="aoj">
                <a href="#userModal" class="aku" data-toggle="modal">
                  Task
                  <h5 class="ali">{{$user->my_tarefas()->count()}}</h5>
                </a>
              </li>
            </ul>

            
          </div>
      </div>
    
       

       <div class="qv rc sm sp">
           <li class="b aml">
              <h3 class="alcs">Privacidade</h3>                       
            </li>

            <!-- Nome e Nickname -->
             <li class="qf b aml">
                <p></p>
                <div class="input-group" style="width: 100%;">
                    <label style="width: 50%;">Name</label>
                    <label style="width: 50%;">Nickname</label>
                </div>
                <div class="input-group" style="width: 100%;">                    
                    <div class="fj" style="width: 50%;">
                      <button type="button" class="cg fm" onclick="btnMessagePrivado(); return false;">
                        <span class="h agz"></span>
                      </button>
                    </div>
                                      
                    <div class="fj" style="width: 50%;">
                      <button type="button" class="cg fm" onclick="btnMessagePrivado(); return false;">
                        <span class="h agz"></span>
                      </button>
                    </div>
                </div>                
            </li>
            <!-- Nome e Nickname -->

      </div>
    </div>

    <div class="gz">
        <ul class="ca qo anx">            
            <li class="b aml">
              <h3 class="alcs">Dados pessoais</h3>        
              
                  <div id="divLock">
                    <button type="button" class="cg fm" onclick="actionLock('unlock');" ><span class="h adw"></span></button>                  
                    <small>Clique no cadeado para efetuar alterações.</small>
                  </div>
                  
            </li>

            <div style="pointer-events:none;" id="divDadoPessoais">
                <!-- Nome e Nickname -->
                 <li class="qf b aml" >
                    <div class="input-group" style="width: 100%;">
                        <label style="width: 50%;">Name</label>
                        <label style="width: 50%;">Nickname</label>
                    </div>
                    <div class="input-group" style="width: 100%;">
                        <input type="text" class="form-control" id="nameUser" placeholder="Nome do usuário"  value="{{ Auth::user()->name }}">                  
                        <div class="fj" style="width: 1%;">
                          <!-- <button type="button" class="cg fm" onclick="btnMessagePrivado(); return false;">
                            <span class="h agz"></span>
                          </button> -->
                        </div>
                      
                        <input type="text" class="form-control" id="nicknameUser" placeholder="Ex: @johnyblack" value="{{ Auth::user()->nickname }}">                  
                        <div class="fj" style="width: 1%;">
                          <!-- <button type="button" class="cg fm" onclick="btnMessagePrivado(); return false;">
                            <span class="h agz"></span>
                          </button> -->
                        </div>
                    </div>                
                    <br>

                    <div class="input-group" style="width: 100%;">
                        <label style="width: 50%;">Lives in</label>
                        <label style="width: 50%;">Worked at</label>
                    </div>
                    <div class="input-group" style="width: 100%;">
                        <input type="text" class="form-control" id="livesinUser" placeholder="San Francisco, CA" value="{{ Auth::user()->lives_in }}">                  
                        <div class="fj" style="width: 1%;">
                          <!-- <button type="button" class="cg fm" onclick="btnMessagePrivado(); return false;">
                            <span class="h agz"></span>
                          </button> -->
                        </div>
                      
                        <input type="text" class="form-control" id="workedatUser" placeholder="Github" value="{{ Auth::user()->worked_at }}">                  
                        <div class="fj" style="width: 1%;">
                          <!-- <button type="button" class="cg fm" onclick="btnMessagePrivado(); return false;">
                            <span class="h agz"></span>
                          </button> -->
                        </div>
                    </div>    
                    <br>                                                    
                    <button type="button" onclick="atualizarDadosPessoais(); return false;" class="cg tr" >Atualizar</button>                
                </li>

                <!-- Nome e Nickname -->

                <!-- Senha -->
                <li class="qf b aml">
                    <label>Alterar Senha</label>                                                              
                    <input type="password" class="form-control" id="novaSenha"  placeholder="Nova Senha">                            
                    <br>
                    <input type="password" class="form-control" id="confirmaSenha"  placeholder="Repita nova senha">                            
                    <br>                                                    
                    <button type="button" onclick="atualizarSenha(); return false;" class="cg tr" >Atualizar</button>                                    
                </li>      
            </div>

        </ul>

    </div>

   @include('helpers.coluna_direita')


  </div>
</div>

<!-- Modal Sugestões -->
<div class="cd fade" id="modalLock" tabindex="-1" role="dialog" aria-labelledby="msgModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="d">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>        
        <h4 class="modal-title">Insira abaixo sua senha</h4>
      </div>

      <div class="modal-body amf js-modalBody">        
        <div class="uq">          
          <div class="alj js-conversation">
            <ul class="qo aob">
                <li class="qf b aml">
                    <label>Senha</label>   
                    <div id="divErrorSenha"></div>                                       
                    <input type="password" class="form-control"  placeholder="senha" id="senhaModal">
                    <br>
                    <button type="button" onclick="verificaSenhaDesbloquear(); return false" class="cg tr">Desbloquear</button>                                    
                </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<script src="/scripts/profile.js"></script>
@endsection
