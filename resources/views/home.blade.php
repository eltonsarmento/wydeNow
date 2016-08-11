@extends('layouts.social')

@section('content')
<div class="by amt">
  <div class="gc">
    <div class="gn">
      <div class="qv rc aog alu">
        <div class="qx" style="background-image: url(assets/img/iceland.jpg);"></div>
        <div class="qw dj">
          <a href="profile/index.html">
            <img class="aoh" src="/uploads/avatars/{{ Auth::user()->avatar }}">
          </a>

          <h5 class="qy">
            <a class="aku" href="/profile">{{ Auth::user()->name }}</a>
          </h5>          

          <ul class="aoi">
            <li class="aoj">
              <a href="#userModal" class="aku" data-toggle="modal">
                Friends
                <h5 class="ali">{{Auth::user()->countFollowers()}}</h5>
              </a>
            </li>

            <li class="aoj">
              <a href="#userModal" class="aku" data-toggle="modal">
                Task
                <h5 class="ali">{{Auth::user()->my_tarefas()->count()}}</h5>
              </a>
            </li>
          </ul>
        </div>
      </div>

      <div class="qv rc sm sp">
        <div class="qw">
          <h5 class="ald">About <small>· <a href="/profile">Edit</a></small></h5>
          <ul class="eb tb">
            <!-- <li><span class="dp h xh all"></span>Went to <a href="#">Oh, Canada</a> -->
            @if(Auth::user()->worked_at)
              <li><span class="dp h abu all"></span>Worked at <a href="#">{{ Auth::user()->worked_at }}</a>
            @endif
            @if(Auth::user()->lives_in)
              <li><span class="dp h ack all"></span>Lives in <a href="#">{{ Auth::user()->lives_in }}</a>
            @endif
            <!-- <li><span class="dp h adt all"></span>From <a href="#">Seattle, WA</a> -->
          </ul>
        </div>
      </div>

    </div>

    <div class="gz">
      <ul class="ca qo anx">

        <li class="qf b aml">
          <div class="input-group">
            <input type="text" class="form-control" id="messageHome" autofocus placeholder="Crie agora sua tarefa">            
            <input type="hidden" id="nicknameMessageHome" value="">
            <input type="hidden" id="isSearch" value="0">
            <input type="hidden" id="textSearch" value="">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="fj">
              <button type="button" class="cg fm" onclick="btnMessagePrivado(); return false;">
                <span class="h adw"></span>
              </button>
            </div>
          </div>
            <div class="popover fade bottom in" role="tooltip" id="listaPerquisaDoit" style="top: 42px; left: 45%; display: none;">
                <div class="arrow" style="left: 90%;"></div>
                <div class="popover-content p-x-0" id="conteudoListaPerquisaDoit">
                </div>
            </div>
        </li>
        <br>
        <input type="hidden" id="totalTarefas" value="{{ $tarefasPublicas->count()}}">
        <div id="timeline">
        @if($tarefasPublicas->count() > 0)
          @foreach($tarefasPublicas as $tarefa)
                <li class="qf b aml">
                  <a class="qj" href="/profile/{{ $tarefa->nickname }}"><img class="qh cu" src="/uploads/avatars/{{ $tarefa->avatar }}"></a>
                  <div class="qg">
                    <div class="aoc">
                      <div class="qn">
                        <small class="eg dp">{{ $tarefa->tempoCadastada }}</small>
                        <h5>{{ $tarefa->name }}</h5>
                      </div>                      
                      <p>{{ $tarefa->texto }}</p>                      
                      <a  onClick="setaDadosModalSugestao('{{$tarefa->id}}','{{$tarefa->texto}}'); return false;"style="margin-right: 10px;"><span class="h xk"></span> Sugestões</a></a>
                      <a  style="margin-left: 75%;" title="Copy" onclick="setaTarefaCopiar('{{$tarefa->texto}}'); return false;"><span class="h age"></span> </a>
                      
                    </div>
                  </div>
                </li>
                <br>
          @endforeach
        @endif
        </div>   
      </ul>
    </div>

    @include('helpers.coluna_direita')
   
  </div>
</div>


@include('helpers.modais_home')



<script src="/scripts/home.js"></script>

<script src="/scripts/suggestions.js"></script>
@endsection
