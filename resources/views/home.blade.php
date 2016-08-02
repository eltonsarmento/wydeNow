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
            <a class="aku" href="profile/index.html">{{ Auth::user()->name }}</a>
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
          <h5 class="ald">About <small>· <a href="#">Edit</a></small></h5>
          <ul class="eb tb">
            <li><span class="dp h xh all"></span>Went to <a href="#">Oh, Canada</a>
            <li><span class="dp h ajw all"></span>Became friends with <a href="#">Obama</a>
            <li><span class="dp h abu all"></span>Worked at <a href="#">Github</a>
            <li><span class="dp h ack all"></span>Lives in <a href="#">San Francisco, CA</a>
            <li><span class="dp h adt all"></span>From <a href="#">Seattle, WA</a>
          </ul>
        </div>
      </div>

    </div>

    <div class="gz">
      <ul class="ca qo anx">

        <li class="qf b aml">
          <div class="input-group">
            <input type="text" class="form-control" placeholder="Message">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="fj">
              <button type="button" class="cg fm">
                <span class="h xi"></span>
              </button>
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
                    </div>
                  </div>
                </li>
                <br>
          @endforeach
        @endif
        </div>   
      </ul>
    </div>
    <div class="gn">
      <div class="alert pv alert-dismissible ss" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <a class="pr" href="profile/index.html">Visit your profile!</a> Check your self, you aren't looking too good.
      </div>
     

      <div class="qv rc alu ss">
        <div class="qw">
        <h5 class="ald">Likes <small>· <a href="#">View All</a></small></h5>
        <ul class="qo anx">
          <li class="qf alm">
            <a class="qj" href="#">
              <img
                class="qh cu"
                src="assets/img/avatar-fat.jpg">
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
                src="assets/img/avatar-mdo.png">
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

      <div class="qv rc aok">
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
          <div id="divInputSugestao">
            <input type="text" id="sugestao" class="form-control" placeholder="Write your menssage">
          </div>
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






<script src="/scripts/home.js"></script>

<script src="/scripts/suggestions.js"></script>
@endsection
