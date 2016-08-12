@extends('layouts.social')

@section('content')
<div class="by amt">
  <div class="gc">
    <div class="gn">
      <div class="qv rc aog alu">
        <div class="qx" style="background-image: url(assets/img/iceland.jpg);"></div>
        <div class="qw dj">
          <a href="/profile">
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
        <li class="b aml">
          <h3 class="alc">Notifications</h3>
        </li>

        @foreach($notifications as $n)
        	@if($n->tipo == "1")
        		<!-- usuário seguiu vc -->
		        <li class="b qf aml">
		          <div class="qj">
		            <span class="h ajv dp"></span>
		          </div>

		          <div class="qg">
		            	<small class="eg dp">{{ $n->tempoCadastada }}</small>
			            <div class="qn">
			              <a href="/profile/{{ $n->nickname }}"><strong>{{ $n->name }}</strong></a> está seguindo você
			            </div>

			            <div class="alk">
			              <div class="gc">
			                <div class="gz">
			                  <div class="qv rc aog">
			                    <div class="qx"
			                         style="background-image: url(../assets/img/instagram_4.jpg);"></div>
			                    <div class="qw dj">			                    
			                      <img class="aoh" src="/uploads/avatars/{{ $n->avatar }}">

			                      <h5 class="qy">{{ $n->name }}</h5>			                      
			                      <a class="cg ts fx" href="/profile/{{ $n->nickname }}">
			                        <span class="h vc"></span> Ver Perfil
			                      </a>
			                    </div>
			                  </div>
			                </div>
			              </div>
			            </div>
		          </div>
		        </li>
				<!-- usuário seguiu vc -->
        	@elseif($n->tipo == "2")
        			<!-- usuário sugeriu algo -->
			        <li class="b qf aml">
			          <div class="qj">
			            <span class="h aax dp"></span>
			          </div>

			          <div class="qg">
			            <small class="eg dp">{{ $n->tempoCadastada }}</small>
			            <div class="qn">
			              <a href="/profile/{{ $n->nickname }}"><strong>{{ $n->name }}</strong></a> escreveu na sua tarefa!
			            </div>

			            <div class="qv rc alk">
			              <div class="qw">
			                <div class="qf">
			                  <a class="qj" href="/profile/{{ $n->nickname }}">
			                    <img class="qh cu"src="/uploads/avatars/{{ $n->avatar }}">
			                  </a>
			                  <div class="qg">
			                    <div class="aoc">
			                      <div class="qn">
			                        <h5 class="alf">{{ $n->name }}</h5>
			                      </div>
			                      <a href="return false;" onclick="{{ $n->link }}">{{ $n->message }}</a>
			                      
			                    </div>
			                  </div>
			                </div>
			              </div>
			            </div>
			          </div>
			        </li>
					<!-- usuário sugeriu algo -->
			@elseif($n->tipo == "3")
        			<!-- usuário sugeriu algo -->
			        <li class="b qf aml">
			          <div class="qj">
			            <span class="h aax dp"></span>
			          </div>

			          <div class="qg">
			            <small class="eg dp">{{ $n->tempoCadastada }}</small>
			            <div class="qn">
			              <a href="/profile/{{ $n->nickname }}"><strong>{{ $n->name }}</strong></a> respondeu a tarefa dele!
			            </div>

			            <div class="qv rc alk">
			              <div class="qw">
			                <div class="qf">
			                  <a class="qj" href="/profile/{{ $n->nickname }}">
			                    <img class="qh cu"src="/uploads/avatars/{{ $n->avatar }}">
			                  </a>
			                  <div class="qg">
			                    <div class="aoc">
			                      <div class="qn">
			                        <h5 class="alf">{{ $n->name }}</h5>
			                      </div>
			                      <a href="return false;" onclick="{{ $n->link }}">{{ $n->message }}</a>
			                      
			                    </div>
			                  </div>
			                </div>
			              </div>
			            </div>
			          </div>
			        </li>
					<!-- usuário sugeriu algo -->
        	@else
		        	<!-- usuário fez algo -->
			        <li class="b qf aml">
			          <div class="qj">
			            <span class="h ajw dp"></span>
			          </div>

			          <div class="qg">
			            <small class="eg dp">{{ $n->tempoCadastada }}</small>
			            <div class="qn">
			              {{ $n->message }} 
			              @if($n->link != '')
			              	<button class="cg ts fx egs" onClick="{{ $n->link }}"> ver</button>
			              @endif
			            </div>
			            <a href="/profile/{{ $n->nickname }}">
				            <ul class="ano">			            	
			              		<li class="anp"><img class="cu" src="/uploads/avatars/{{ $n->avatar }}">
			              		<li class="anp"> <small>{{ $n->nickname }}</small>
				            </ul>
			            </a>
			          </div>
			        </li>
			        <!-- usuário fez algo -->
        	@endif
        @endforeach
        
      
        
        
        

      </ul>
    </div>

    @include('helpers.coluna_direita')
   
  </div>
</div>


@include('helpers.modais_home')



<script src="/scripts/home.js"></script>

<script src="/scripts/suggestions.js"></script>
@endsection
